<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class BasicPlanDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment(['production'])) {
            $this->command?->error('BasicPlanDemoSeeder cannot run in production.');
            return;
        }

        $now = now();
        $email = 'basic.demo@myplexus.com';
        $password = 'Basic@123';

        $planPayload = [
            'name' => 'Basic',
            'slug' => 'basic',
            'price_monthly' => 10000.00,
            'price_yearly' => 10000.00,
            'duration_months' => 1,
            'allow_trial' => true,
            'features' => ['Core research tools', 'Ratio and composition reports'],
            'is_active' => true,
        ];

        if (!Schema::hasColumn('subscription_plans', 'duration_months')) {
            unset($planPayload['duration_months']);
        }

        if (!Schema::hasColumn('subscription_plans', 'allow_trial')) {
            unset($planPayload['allow_trial']);
        }

        $plan = SubscriptionPlan::updateOrCreate(['slug' => 'basic'], $planPayload);

        $userPayload = [
            'u_id' => 9002,
            'u_code' => 'UBASIC01',
            'acc_type' => 'a',
            's_acc_medium' => '',
            's_account' => null,
            'f_name' => 'Basic',
            'l_name' => 'Demo',
            'password' => Hash::make($password),
            'forget_code' => null,
            'mobile' => '8888888888',
            'birthday' => '1992-01-01',
            'p_picture' => null,
            'pincode' => '400001',
            'address' => 'Local demo address',
            'about' => 'Basic plan demo user',
            'profile' => null,
            'company' => 'Basic Demo Company',
            'status' => 1,
            'is_approved' => 'y',
            'note' => 'Seeded by BasicPlanDemoSeeder',
            'created_by' => 'a',
            'created_id' => 1,
            'updated_by' => 'a',
            'updated_id' => 1,
            'contact_person' => 'Basic Demo',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'gst' => '27ABCDE1234F1Z5',
            'arn' => 'ARN-654321',
            'pan' => 'ABCDE1234F',
            'subscription_status' => 'active',
            'subscription_expiry_date' => $now->copy()->addMonthNoOverflow()->toDateString(),
            'trial_ends_at' => null,
        ];

        foreach (['subscription_status', 'trial_ends_at'] as $column) {
            if (!Schema::hasColumn('users', $column)) {
                unset($userPayload[$column]);
            }
        }

        $user = User::updateOrCreate(['email' => $email], $userPayload);

        Subscription::updateOrCreate(
            [
                'user_id' => $user->u_id,
                'plan_id' => $plan->id,
                'subscription_type' => 'basic',
            ],
            [
                'u_id' => $user->u_id,
                'u_code' => $user->u_code,
                'billing_cycle' => 'monthly',
                'status' => Subscription::databaseStatusFor('active'),
                'starts_at' => $now,
                'ends_at' => $now->copy()->addMonthNoOverflow(),
                'subscription_expiry_date' => $now->copy()->addMonthNoOverflow()->toDateString(),
                'amount' => 10000.00,
                'currency' => 'INR',
                'created_date' => $now->toDateString(),
                'created_by' => 'a',
                'created_id' => 1,
                'updated_by' => 'a',
                'updated_id' => 1,
            ]
        );

        $this->command?->info('Basic plan demo user seeded.');
        $this->command?->line('User ID: ' . $user->u_id);
        $this->command?->line('Email: ' . $email);
        $this->command?->line('Password: ' . $password);
        $this->command?->line('Basic expires: ' . $now->copy()->addMonthNoOverflow()->toDateString());
    }
}
