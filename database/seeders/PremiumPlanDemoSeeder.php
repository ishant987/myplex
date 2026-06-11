<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class PremiumPlanDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment(['production'])) {
            $this->command?->error('PremiumPlanDemoSeeder cannot run in production.');
            return;
        }

        $now = now();
        $email = 'premium.demo@myplexus.com';
        $password = 'Premium@123';

        $planPayload = [
            'name' => 'Premium',
            'slug' => 'premium',
            'price_monthly' => 1999.00,
            'price_yearly' => 19999.00,
            'duration_months' => 12,
            'allow_trial' => true,
            'features' => ['All Standard features', 'Premium analytics', 'Dedicated onboarding'],
            'is_active' => true,
        ];

        if (!Schema::hasColumn('subscription_plans', 'duration_months')) {
            unset($planPayload['duration_months']);
        }

        if (!Schema::hasColumn('subscription_plans', 'allow_trial')) {
            unset($planPayload['allow_trial']);
        }

        $plan = SubscriptionPlan::updateOrCreate(['slug' => 'premium'], $planPayload);

        $userPayload = [
            'u_id' => 9013,
            'u_code' => 'UPREM13',
            'acc_type' => 'a',
            's_acc_medium' => '',
            's_account' => null,
            'f_name' => 'Premium',
            'l_name' => 'Demo',
            'email' => $email,
            'password' => Hash::make($password),
            'forget_code' => null,
            'mobile' => '7777777777',
            'birthday' => '1991-01-01',
            'p_picture' => null,
            'pincode' => '400001',
            'address' => 'Local demo address',
            'about' => 'Premium plan demo user',
            'profile' => null,
            'company' => 'Premium Demo Company',
            'status' => 1,
            'is_approved' => 'y',
            'note' => 'Seeded by PremiumPlanDemoSeeder',
            'created_by' => 'a',
            'created_id' => 1,
            'updated_by' => 'a',
            'updated_id' => 1,
            'contact_person' => 'Premium Demo',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'gst' => '27ABCDE1234F1Z5',
            'arn' => 'ARN-789012',
            'pan' => 'ABCDE1234F',
            'arn_verification_status' => 'verified',
            'subscription_status' => 'active',
            'subscription_expiry_date' => $now->copy()->addYear()->toDateString(),
            'trial_ends_at' => null,
        ];

        foreach (['subscription_status', 'trial_ends_at', 'arn_verification_status'] as $column) {
            if (!Schema::hasColumn('users', $column)) {
                unset($userPayload[$column]);
            }
        }

        $user = User::updateOrCreate(['email' => $email], $userPayload);

        if (Schema::hasColumn('users', 'arn_verification_status')) {
            DB::table('users')
                ->where('u_id', $user->u_id)
                ->update(['arn_verification_status' => 'verified']);
        }

        Subscription::updateOrCreate(
            [
                'user_id' => $user->u_id,
                'plan_id' => $plan->id,
                'subscription_type' => 'premium',
            ],
            [
                'u_id' => $user->u_id,
                'u_code' => $user->u_code,
                'billing_cycle' => 'yearly',
                'status' => Subscription::databaseStatusFor('active'),
                'starts_at' => $now,
                'ends_at' => $now->copy()->addYear(),
                'subscription_expiry_date' => $now->copy()->addYear()->toDateString(),
                'amount' => 19999.00,
                'currency' => 'INR',
                'created_date' => $now->toDateString(),
                'created_by' => 'a',
                'created_id' => 1,
                'updated_by' => 'a',
                'updated_id' => 1,
            ]
        );

        $this->command?->info('Premium plan demo user seeded.');
        $this->command?->line('User ID: ' . $user->u_id);
        $this->command?->line('Email: ' . $email);
        $this->command?->line('Password: ' . $password);
        $this->command?->line('Premium expires: ' . $now->copy()->addYear()->toDateString());
    }
}
