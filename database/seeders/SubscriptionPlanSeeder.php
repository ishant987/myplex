<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'price_monthly' => 499.00,
                'price_yearly' => 4999.00,
                'features' => ['Feature 1', 'Feature 2', 'Feature 3'],
            ],
            [
                'name' => 'Standard',
                'slug' => 'standard',
                'price_monthly' => 999.00,
                'price_yearly' => 9999.00,
                'features' => ['Priority research', 'Monthly insights', 'Advisor support'],
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'price_monthly' => 1999.00,
                'price_yearly' => 19999.00,
                'features' => ['All Standard features', 'Premium analytics', 'Dedicated onboarding'],
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                array_merge($plan, ['is_active' => true])
            );
        }
    }
}
