<?php

namespace App\Services;

use App\Models\SettingsModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayService
{
    protected ?Api $client = null;

    public function isConfigured(): bool
    {
        return (bool) ($this->settingValue('razorpay_key_id', config('razorpay.key_id'))
            && $this->settingValue('razorpay_key_secret', config('razorpay.key_secret')));
    }

    public function getKeyId(): ?string
    {
        return $this->settingValue('razorpay_key_id', config('razorpay.key_id'));
    }

    public function getCurrency(): string
    {
        return (string) $this->settingValue('razorpay_currency', config('razorpay.currency', 'INR'));
    }

    public function getCompanyName(): string
    {
        return (string) $this->settingValue('razorpay_company_name', config('razorpay.company_name', 'MyPlexus'));
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
        $webhookSecret = $this->settingValue('razorpay_webhook_secret', config('razorpay.webhook_secret'));

        if (!$signature || !$webhookSecret) {
            return false;
        }

        try {
            $this->client()->utility->verifyWebhookSignature($payload, $signature, $webhookSecret);

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
            $this->client = new Api(
                $this->settingValue('razorpay_key_id', config('razorpay.key_id')),
                $this->settingValue('razorpay_key_secret', config('razorpay.key_secret'))
            );
        }

        return $this->client;
    }

    protected function settingValue(string $key, ?string $fallback = null): ?string
    {
        try {
            if (Schema::hasTable('options')) {
                $value = SettingsModel::getSettingValue($key);

                if ($value !== '') {
                    return $value;
                }
            }
        } catch (\Throwable $exception) {
        }

        return $fallback;
    }
}
