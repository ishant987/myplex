<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Models\Subscription;
use App\Services\RazorpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RazorpayWebhookController extends Controller
{
    public function __construct(protected RazorpayService $razorpayService)
    {
    }

    public function handle(Request $request)
    {
        abort_unless(config('features.subscription_enabled'), 404);

        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');

        if (!$this->razorpayService->verifyWebhookSignature($payload, $signature)) {
            return response()->json(['status' => 'invalid-signature'], 400);
        }

        $event = $request->json('event');
        $entity = $request->json('payload.payment.entity', []);
        $subscriptionEntity = $request->json('payload.subscription.entity', []);

        match ($event) {
            'payment.captured' => $this->handlePaymentCaptured($entity),
            'payment.failed' => $this->handlePaymentFailed($entity),
            'subscription.cancelled' => $this->handleSubscriptionCancelled($subscriptionEntity),
            default => null,
        };

        return response()->json(['status' => 'ok']);
    }

    protected function handlePaymentCaptured(array $payment): void
    {
        $transaction = PaymentTransaction::where('razorpay_order_id', data_get($payment, 'order_id'))->first();

        if (!$transaction) {
            return;
        }

        DB::transaction(function () use ($transaction, $payment) {
            $transaction->update([
                'razorpay_payment_id' => data_get($payment, 'id'),
                'status' => 'captured',
                'metadata' => array_merge($transaction->metadata ?? [], ['webhook' => $payment]),
            ]);

            if ($transaction->subscription) {
                $subscription = $transaction->subscription;
                $durationMonths = $subscription->billing_cycle === 'yearly' ? 12 : 1;
                $startsAt = now();
                $endsAt = now()->addMonthsNoOverflow($durationMonths);

                Subscription::query()
                    ->where('user_id', $subscription->user_id)
                    ->where('id', '!=', $subscription->id)
                    ->whereIn('status', [
                        Subscription::databaseStatusFor('active'),
                        Subscription::databaseStatusFor('pending'),
                    ])
                    ->update([
                        'status' => Subscription::databaseStatusFor('cancelled'),
                        'updated_by' => 'u',
                        'updated_id' => $subscription->user_id ?? 0,
                    ]);

                $subscription->update([
                    'razorpay_payment_id' => data_get($payment, 'id'),
                    'status' => Subscription::databaseStatusFor('active'),
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                    'subscription_expiry_date' => $endsAt->toDateString(),
                    'updated_by' => 'u',
                    'updated_id' => $subscription->user_id ?? 0,
                ]);

                if ($subscription->user) {
                    $subscription->user->update([
                        'subscription_status' => 'active',
                        'trial_ends_at' => null,
                        'subscription_expiry_date' => $endsAt->toDateString(),
                    ]);
                }
            }
        });
    }

    protected function handlePaymentFailed(array $payment): void
    {
        $transaction = PaymentTransaction::where('razorpay_order_id', data_get($payment, 'order_id'))->first();

        if (!$transaction) {
            return;
        }

        $transaction->update([
            'razorpay_payment_id' => data_get($payment, 'id'),
            'status' => 'failed',
            'failure_reason' => data_get($payment, 'error_description') ?: data_get($payment, 'error.reason'),
            'metadata' => array_merge($transaction->metadata ?? [], ['webhook' => $payment]),
        ]);

        if ($transaction->subscription) {
            $transaction->subscription->update(['status' => Subscription::databaseStatusFor('failed')]);
        }
    }

    protected function handleSubscriptionCancelled(array $subscriptionEntity): void
    {
        $subscription = Subscription::where('razorpay_subscription_id', data_get($subscriptionEntity, 'id'))->first();

        if (!$subscription) {
            return;
        }

        $subscription->update(['status' => Subscription::databaseStatusFor('cancelled')]);

        if ($subscription->user) {
            $subscription->user->update(['subscription_status' => 'cancelled']);
        }
    }
}
