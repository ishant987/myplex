<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\PaymentConfirmation;
use App\Models\PaymentTransaction;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use App\Services\RazorpayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{
    protected array $defaultPlans = [
        [
            'name' => 'Basic',
            'slug' => 'basic',
            'price_monthly' => 10000.00,
            'price_yearly' => 10000.00,
            'duration_months' => 1,
            'allow_trial' => true,
            'features' => ['Core research tools', 'Ratio and composition reports', '0-day trial for new users'],
            'is_active' => true,
        ],
        [
            'name' => 'Premium',
            'slug' => 'premium',
            'price_monthly' => 15000.00,
            'price_yearly' => 15000.00,
            'duration_months' => 12,
            'allow_trial' => true,
            'features' => ['Everything in Basic', 'Extended access and best value', '0-day trial only if unused'],
            'is_active' => true,
        ],
        [
            'name' => 'White Label',
            'slug' => 'white-label',
            'price_monthly' => 5000.00,
            'price_yearly' => 5000.00,
            'duration_months' => 1,
            'allow_trial' => false,
            'features' => ['All Premium features', 'Custom PDF branding', 'Your logo and company name'],
            'is_active' => true,
        ],
    ];

    public function __construct(protected RazorpayService $razorpayService)
    {
    }

    public function index()
    {
        abort_unless(config('features.subscription_enabled'), 404);

        $this->ensureDefaultPlans();

        $plans = SubscriptionPlan::query()
            ->where('is_active', true)
            ->whereIn('slug', ['basic', 'premium', 'white-label'])
            ->orderByRaw("CASE slug WHEN 'basic' THEN 1 WHEN 'premium' THEN 2 WHEN 'white-label' THEN 3 ELSE 4 END")
            ->get();

        $user = Auth::user();
        $activeSubscription = null;
        $upgradePreview = [];
        $hasUsedTrial = false;

        if ($user && Schema::hasTable('subscriptions')) {
            $hasUsedTrial = $user->hasUsedTrial();
            $activeSubscription = $user->razorpaySubscriptions()
                ->with('plan')
                ->whereIn('status', [
                    Subscription::databaseStatusFor('active'),
                    'active',
                ])
                ->latest('id')
                ->first();

            foreach ($plans as $plan) {
                $upgradePreview[$plan->id] = $this->buildUpgradeBreakdown($user, $plan);
            }
        }

        return view('subscription.index', compact('plans', 'user', 'activeSubscription', 'upgradePreview', 'hasUsedTrial'));
    }

    protected function ensureDefaultPlans(): void
    {
        if (!Schema::hasTable('subscription_plans')) {
            return;
        }

        foreach ($this->defaultPlans as $plan) {
            $payload = $plan;

            if (!Schema::hasColumn('subscription_plans', 'duration_months')) {
                unset($payload['duration_months']);
            }

            if (!Schema::hasColumn('subscription_plans', 'allow_trial')) {
                unset($payload['allow_trial']);
            }

            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $payload
            );
        }
    }

    protected function activePaidSubscription($user): ?Subscription
    {
        if (!$user) {
            return null;
        }

        return $user->razorpaySubscriptions()
            ->with('plan')
            ->whereIn('status', [
                Subscription::databaseStatusFor('active'),
                'active',
            ])
            ->latest('id')
            ->first();
    }

    protected function planChargeAmount(SubscriptionPlan $plan): float
    {
        return (float) $plan->price_monthly;
    }

    protected function planDurationMonths(SubscriptionPlan $plan): int
    {
        return max(1, (int) ($plan->duration_months ?: 1));
    }

    protected function calculatePlanEndDate(SubscriptionPlan $plan): Carbon
    {
        return match (strtolower((string) $plan->slug)) {
            'basic' => now()->copy()->addDays(4),
            default => now()->copy()->addMonthsNoOverflow($this->planDurationMonths($plan)),
        };
    }

    protected function buildUpgradeBreakdown($user, SubscriptionPlan $newPlan): array
    {
        $originalAmount = $this->planChargeAmount($newPlan);
        $currentSubscription = $this->activePaidSubscription($user);

        if (
            !$currentSubscription
            || !$currentSubscription->isActive()
            || !$currentSubscription->plan
            || (int) $currentSubscription->plan_id === (int) $newPlan->id
            || $this->planChargeAmount($newPlan) <= $this->planChargeAmount($currentSubscription->plan)
        ) {
            return [
                'is_upgrade' => false,
                'original_amount' => round($originalAmount, 2),
                'credit' => 0.0,
                'upgrade_amount' => round($originalAmount, 2),
                'days_remaining' => 0,
            ];
        }

        $currentPlanSlug = strtolower((string) optional($currentSubscription->plan)->slug);
        $newPlanSlug = strtolower((string) $newPlan->slug);

        // White Label is treated as a standalone monthly branding plan.
        // Moving from White Label to Basic/Premium should always charge full price.
        if ($currentPlanSlug === 'white-label' && in_array($newPlanSlug, ['basic', 'premium'], true)) {
            return [
                'is_upgrade' => false,
                'original_amount' => round($originalAmount, 2),
                'credit' => 0.0,
                'upgrade_amount' => round($originalAmount, 2),
                'days_remaining' => 0,
                'current_plan_id' => $currentSubscription->plan_id,
                'current_plan_name' => optional($currentSubscription->plan)->name,
                'trial_allowed' => false,
            ];
        }

        $endDate = $currentSubscription->ends_at
            ? Carbon::parse($currentSubscription->ends_at)
            : Carbon::parse($currentSubscription->subscription_expiry_date);
        $daysRemaining = max(0, now()->diffInDays($endDate, false));
        $totalDays = max(1, $this->planDurationMonths($currentSubscription->plan) * 30);
        $amountPaid = (float) ($currentSubscription->amount ?: $this->planChargeAmount($currentSubscription->plan));
        $credit = ($daysRemaining / $totalDays) * $amountPaid;
        $upgradeAmount = max(0, $originalAmount - $credit);

        return [
            'is_upgrade' => true,
            'original_amount' => round($originalAmount, 2),
            'credit' => round($credit, 2),
            'upgrade_amount' => round($upgradeAmount, 2),
            'days_remaining' => $daysRemaining,
            'current_plan_id' => $currentSubscription->plan_id,
            'current_plan_name' => optional($currentSubscription->plan)->name,
            'trial_allowed' => false,
        ];
    }

    public function calculateUpgradeAmount(Request $request): JsonResponse
    {
        abort_unless(config('features.subscription_enabled'), 404);

        $validated = $request->validate([
            'plan_id' => ['required', 'integer', Rule::exists('subscription_plans', 'id')],
        ]);

        $plan = SubscriptionPlan::findOrFail($validated['plan_id']);

        return response()->json($this->buildUpgradeBreakdown($request->user(), $plan));
    }

    public function checkout(Request $request)
    {
        abort_unless(config('features.subscription_enabled'), 404);

        $validated = $request->validate([
            'plan_id' => ['required', 'integer', Rule::exists('subscription_plans', 'id')],
        ]);

        $plan = SubscriptionPlan::findOrFail($validated['plan_id']);
        $user = $request->user();
        $upgrade = $this->buildUpgradeBreakdown($user, $plan);
        $amount = (float) $upgrade['upgrade_amount'];

        if (!$this->razorpayService->isConfigured()) {
            return response()->json([
                'message' => 'Razorpay keys are not configured yet.',
            ], 422);
        }

        $order = $this->razorpayService->createOrder([
            'receipt' => 'mplx_' . $user->u_id . '_' . now()->timestamp,
            'amount' => (int) round($amount * 100),
            'currency' => $this->razorpayService->getCurrency(),
            'notes' => [
                'user_id' => $user->u_id,
                'plan_id' => $plan->id,
                'upgrade_amount' => $amount,
            ],
        ]);

        $subscription = Subscription::create([
            'user_id' => $user->u_id,
            'u_id' => $user->u_id,
            'u_code' => $user->u_code,
            'plan_id' => $plan->id,
            'subscription_type' => $plan->slug,
            'razorpay_order_id' => $order['id'],
            'billing_cycle' => 'fixed',
            'status' => Subscription::databaseStatusFor('pending'),
            'trial_ends_at' => $user->trial_ends_at,
            'amount' => $amount,
            'currency' => $this->razorpayService->getCurrency(),
            'created_date' => now()->toDateString(),
            'created_by' => 'u',
            'created_id' => $user->u_id,
            'updated_by' => 'u',
            'updated_id' => $user->u_id,
        ]);

        PaymentTransaction::create([
            'user_id' => $user->u_id,
            'subscription_id' => $subscription->id,
            'razorpay_order_id' => $order['id'],
            'amount' => $amount,
            'currency' => $this->razorpayService->getCurrency(),
            'status' => 'pending',
            'metadata' => [
                'plan_id' => $plan->id,
                'is_upgrade' => $upgrade['is_upgrade'],
                'credit' => $upgrade['credit'],
                'original_amount' => $upgrade['original_amount'],
                'days_remaining' => $upgrade['days_remaining'],
            ],
        ]);

        return response()->json([
            'key_id' => $this->razorpayService->getKeyId(),
            'order_id' => $order['id'],
            'amount' => $order['amount'],
            'currency' => $order['currency'],
            'company_name' => $this->razorpayService->getCompanyName(),
            'plan_name' => $plan->name,
            'display_amount' => number_format($amount, 2, '.', ''),
            'credit' => $upgrade['credit'],
            'is_upgrade' => $upgrade['is_upgrade'],
            'user_name' => trim($user->f_name . ' ' . $user->l_name),
            'user_email' => $user->email,
            'user_phone' => $user->mobile,
        ]);
    }

    public function verifyPayment(Request $request)
    {
        abort_unless(config('features.subscription_enabled'), 404);

        $validated = $request->validate([
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
        ]);

        if (!$this->razorpayService->verifyPaymentSignature($validated)) {
            return response()->json(['message' => 'Payment signature verification failed.'], 422);
        }

        $user = $request->user();
        $paymentDetails = [];

        try {
            $paymentDetails = $this->razorpayService->fetchPayment($validated['razorpay_payment_id']);
        } catch (\Throwable $exception) {
            $paymentDetails = [];
        }

        $transaction = PaymentTransaction::query()
            ->where('user_id', $user->u_id)
            ->where('razorpay_order_id', $validated['razorpay_order_id'])
            ->latest('id')
            ->firstOrFail();

        $subscription = Subscription::findOrFail($transaction->subscription_id);
        $plan = $subscription->plan()->first();
        $startsAt = now();
        $endsAt = $plan ? $this->calculatePlanEndDate($plan) : now()->copy()->addMonthsNoOverflow(1);

        DB::transaction(function () use ($validated, $transaction, $subscription, $user, $startsAt, $endsAt, $paymentDetails) {
            Subscription::query()
                ->where('user_id', $user->u_id)
                ->where('id', '!=', $subscription->id)
                ->whereIn('status', [
                    Subscription::databaseStatusFor('active'),
                    Subscription::databaseStatusFor('pending'),
                ])
                ->update([
                    'status' => Subscription::databaseStatusFor('cancelled'),
                    'updated_by' => 'u',
                    'updated_id' => $user->u_id,
                ]);

            $transaction->update([
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'razorpay_signature' => $validated['razorpay_signature'],
                'status' => 'captured',
                'metadata' => array_merge($transaction->metadata ?? [], ['payment' => $paymentDetails]),
            ]);

            $subscription->update([
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'status' => Subscription::databaseStatusFor('active'),
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'subscription_expiry_date' => $endsAt->toDateString(),
                'updated_by' => 'u',
                'updated_id' => $user->u_id,
            ]);

            $user->update([
                'trial_ends_at' => null,
                'subscription_status' => 'active',
                'subscription_expiry_date' => $endsAt->toDateString(),
            ]);
        });

        try {
            Mail::to($user->email)->send(new PaymentConfirmation($user, $subscription->fresh('plan'), $transaction));
        } catch (\Throwable $exception) {
        }

        return response()->json([
            'status' => 'ok',
            'redirect' => route('user.index_dashboard'),
        ]);
    }

    public function cancel(Request $request)
    {
        abort_unless(config('features.subscription_enabled'), 404);

        $subscription = $request->user()
            ->razorpaySubscriptions()
            ->latest('id')
            ->firstOrFail();

        if ($subscription->razorpay_subscription_id && $this->razorpayService->isConfigured()) {
            $this->razorpayService->cancelSubscription($subscription->razorpay_subscription_id);
        }

        $subscription->update(['status' => Subscription::databaseStatusFor('cancelled')]);
        $request->user()->update(['subscription_status' => 'cancelled']);

        return response()->json(['status' => 'ok']);
    }
}
