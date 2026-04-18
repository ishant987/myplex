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

class SubscriptionController extends Controller
{
    protected array $defaultPlans = [
        [
            'name' => 'Basic',
            'slug' => 'basic',
            'price_monthly' => 499.00,
            'price_yearly' => 4999.00,
            'features' => ['Feature 1', 'Feature 2', 'Feature 3'],
            'is_active' => true,
        ],
        [
            'name' => 'Standard',
            'slug' => 'standard',
            'price_monthly' => 999.00,
            'price_yearly' => 9999.00,
            'features' => ['Priority research', 'Monthly insights', 'Advisor support'],
            'is_active' => true,
        ],
        [
            'name' => 'Premium',
            'slug' => 'premium',
            'price_monthly' => 1999.00,
            'price_yearly' => 19999.00,
            'features' => ['All Standard features', 'Premium analytics', 'Dedicated onboarding'],
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
            ->orderByRaw("CASE slug WHEN 'basic' THEN 1 WHEN 'standard' THEN 2 WHEN 'premium' THEN 3 ELSE 4 END")
            ->get();

        $user = Auth::user();
        $activeSubscription = null;

        if ($user && Schema::hasTable('subscriptions')) {
            $activeSubscription = $user->razorpaySubscriptions()
                ->with('plan')
                ->latest('id')
                ->first();
        }

        return view('subscription.index', compact('plans', 'user', 'activeSubscription'));
    }

    protected function ensureDefaultPlans(): void
    {
        if (!Schema::hasTable('subscription_plans')) {
            return;
        }

        if (SubscriptionPlan::query()->where('is_active', true)->exists()) {
            return;
        }

        foreach ($this->defaultPlans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }

    public function checkout(Request $request)
    {
        abort_unless(config('features.subscription_enabled'), 404);

        $validated = $request->validate([
            'plan_id' => ['required', 'integer', Rule::exists('subscription_plans', 'id')],
            'billing_cycle' => ['required', Rule::in(['monthly', 'yearly'])],
        ]);

        $plan = SubscriptionPlan::findOrFail($validated['plan_id']);
        $user = $request->user();
        $amount = $plan->getPriceForCycle($validated['billing_cycle']);

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
                'billing_cycle' => $validated['billing_cycle'],
            ],
        ]);

        $subscription = Subscription::create([
            'user_id' => $user->u_id,
            'u_id' => $user->u_id,
            'u_code' => $user->u_code,
            'plan_id' => $plan->id,
            'subscription_type' => $plan->slug,
            'razorpay_order_id' => $order['id'],
            'billing_cycle' => $validated['billing_cycle'],
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
                'billing_cycle' => $validated['billing_cycle'],
            ],
        ]);

        return response()->json([
            'key_id' => $this->razorpayService->getKeyId(),
            'order_id' => $order['id'],
            'amount' => $order['amount'],
            'currency' => $order['currency'],
            'company_name' => $this->razorpayService->getCompanyName(),
            'plan_name' => $plan->name,
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
        $durationMonths = $subscription->billing_cycle === 'yearly' ? 12 : 1;
        $startsAt = now();
        $endsAt = now()->copy()->addMonthsNoOverflow($durationMonths);

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
            'redirect' => route('user.ratio_dashboard'),
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
