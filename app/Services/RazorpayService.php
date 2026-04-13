<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayService
{
    protected ?Api $client = null;

    public function isConfigured(): bool
    {
        return (bool) (config('razorpay.key_id') && config('razorpay.key_secret'));
    }

    public function getKeyId(): ?string
    {
        return config('razorpay.key_id');
    }

    public function createOrder(array $payload): array
    {
        return $this->client()->order->create($payload)->toArray();
    }

    public function fetchPayment(string $paymentId): array
    {
        return $this->client()->payment->fetch($paymentId)->toArray();
    }

    public function cancelSubscription(string $subscriptionId): array
    {
        return $this->client()->subscription->fetch($subscriptionId)->cancel()->toArray();
    }

    public function verifyPaymentSignature(array $attributes): bool
    {
        try {
            $this->client()->utility->verifyPaymentSignature($attributes);

            return true;
        } catch (SignatureVerificationError $exception) {
            return false;
        }
    }

    public function verifyWebhookSignature(string $payload, ?string $signature): bool
    {
        if (!$signature || !config('razorpay.webhook_secret')) {
            return false;
        }

        try {
            $this->client()->utility->verifyWebhookSignature($payload, $signature, config('razorpay.webhook_secret'));

            return true;
        } catch (SignatureVerificationError $exception) {
            return false;
        }
    }

    protected function client(): Api
    {
        if (!$this->isConfigured()) {
            throw new \RuntimeException('Razorpay keys are not configured.');
        }

        if ($this->client === null) {
            $this->client = new Api(config('razorpay.key_id'), config('razorpay.key_secret'));
        }

        return $this->client;
    }
}
