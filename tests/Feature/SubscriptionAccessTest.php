<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class SubscriptionAccessTest extends TestCase
{
    public function test_legacy_active_subscription_with_past_expiry_is_not_active(): void
    {
        $subscription = new Subscription([
            'status' => 'a',
            'subscription_expiry_date' => Carbon::now()->subDays(5)->toDateString(),
        ]);

        $this->assertFalse($subscription->isActive());
    }

    public function test_legacy_active_subscription_with_future_expiry_is_active(): void
    {
        $subscription = new Subscription([
            'status' => 'a',
            'subscription_expiry_date' => Carbon::now()->addDays(5)->toDateString(),
        ]);

        $this->assertTrue($subscription->isActive());
    }

    public function test_trial_user_without_trial_end_date_does_not_have_access_after_expiry(): void
    {
        $user = new class extends User {
            public function activeSubscription()
            {
                return new class {
                    public function first()
                    {
                        return null;
                    }
                };
            }
        };

        $user->subscription_status = 'trial';
        $user->subscription_expiry_date = Carbon::now()->subDays(5)->toDateString();
        $user->trial_ends_at = null;

        $this->assertFalse($user->hasActiveSubscription());
        $this->assertFalse($user->isOnTrial());
        $this->assertFalse($user->hasValidAccess());
    }

    public function test_trial_user_with_future_trial_end_date_has_access(): void
    {
        $user = new class extends User {
            public function activeSubscription()
            {
                return new class {
                    public function first()
                    {
                        return null;
                    }
                };
            }
        };

        $user->subscription_status = 'trial';
        $user->subscription_expiry_date = Carbon::now()->addDays(5)->toDateString();
        $user->trial_ends_at = Carbon::now()->addDays(5);

        $this->assertFalse($user->hasActiveSubscription());
        $this->assertTrue($user->isOnTrial());
        $this->assertTrue($user->hasValidAccess());
    }
}
