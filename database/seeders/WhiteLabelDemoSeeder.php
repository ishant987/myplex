<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class WhiteLabelDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment(['production'])) {
            $this->command?->error('WhiteLabelDemoSeeder cannot run in production.');
            return;
        }

        $now = now();
        $password = 'WhiteLabel@123';
        $email = 'whitelabel.demo@myplexus.com';
        $logoRelativePath = 'uploads/whitelabel/demo-white-label-logo.png';
        $logoPublicPath = public_path($logoRelativePath);

        if (!File::isDirectory(dirname($logoPublicPath))) {
            File::makeDirectory(dirname($logoPublicPath), 0755, true);
        }

        $sourceLogo = public_path('themes/frontend/assets/infosolz/images/small_logo.png');
        if (File::exists($sourceLogo)) {
            File::copy($sourceLogo, $logoPublicPath);
        }

        $plans = [
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'price_monthly' => 10000.00,
                'price_yearly' => 10000.00,
                'duration_months' => 1,
                'allow_trial' => true,
                'features' => ['Core research tools', 'Ratio and composition reports'],
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'price_monthly' => 15000.00,
                'price_yearly' => 15000.00,
                'duration_months' => 12,
                'allow_trial' => true,
                'features' => ['Everything in Basic', 'Extended access and best value'],
                'is_active' => true,
            ],
            [
                'name' => 'White Label',
                'slug' => 'white-label',
                'price_monthly' => 5000.00,
                'price_yearly' => 5000.00,
                'duration_months' => 1,
                'allow_trial' => false,
                'features' => ['Custom PDF branding', 'Your logo and company name'],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            $payload = $plan;

            if (!Schema::hasColumn('subscription_plans', 'duration_months')) {
                unset($payload['duration_months']);
            }

            if (!Schema::hasColumn('subscription_plans', 'allow_trial')) {
                unset($payload['allow_trial']);
            }

            SubscriptionPlan::updateOrCreate(['slug' => $plan['slug']], $payload);
        }

        $userPayload = [
            'u_id' => 9001,
            'u_code' => 'UWL00001',
            'acc_type' => 'a',
            's_acc_medium' => '',
            's_account' => null,
            'f_name' => 'White Label',
            'l_name' => 'Demo',
            'password' => Hash::make($password),
            'forget_code' => null,
            'mobile' => '9999999999',
            'birthday' => '1990-01-01',
            'p_picture' => null,
            'pincode' => '400001',
            'address' => 'Local demo address',
            'about' => 'White Label demo user',
            'profile' => null,
            'company' => 'Demo Capital Advisors',
            'status' => 1,
            'is_approved' => 'y',
            'note' => 'Seeded by WhiteLabelDemoSeeder',
            'created_by' => 'a',
            'created_id' => 1,
            'updated_by' => 'a',
            'updated_id' => 1,
            'contact_person' => 'White Label Demo',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'gst' => '27ABCDE1234F1Z5',
            'arn' => 'ARN-123456',
            'pan' => 'ABCDE1234F',
            'subscription_status' => 'active',
            'subscription_expiry_date' => $now->copy()->addYear()->toDateString(),
            'trial_ends_at' => null,
            'wl_company_name' => 'Demo Capital Advisors',
            'wl_logo' => $logoRelativePath,
        ];

        foreach (['subscription_status', 'trial_ends_at', 'wl_company_name', 'wl_logo'] as $column) {
            if (!Schema::hasColumn('users', $column)) {
                unset($userPayload[$column]);
            }
        }

        $user = User::updateOrCreate(['email' => $email], $userPayload);

        $settingsDirectory = dirname($user->whiteLabelSettingsPath());
        if (!File::isDirectory($settingsDirectory)) {
            File::makeDirectory($settingsDirectory, 0755, true);
        }

        File::put($user->whiteLabelSettingsPath(), json_encode([
            'company_name' => 'Demo Capital Advisors',
            'logo' => $logoRelativePath,
            'updated_at' => $now->toDateTimeString(),
        ], JSON_PRETTY_PRINT));

        $premiumPlan = SubscriptionPlan::where('slug', 'premium')->first();
        $whiteLabelPlan = SubscriptionPlan::where('slug', 'white-label')->first();

        $this->upsertSubscription($user, $premiumPlan, 'premium', $now, $now->copy()->addYear(), 15000.00);
        $this->upsertSubscription($user, $whiteLabelPlan, 'white-label', $now, $now->copy()->addMonthNoOverflow(), 5000.00);

        $this->command?->info('White Label demo user seeded.');
        $this->command?->line('User ID: ' . $user->u_id);
        $this->command?->line('Email: ' . $email);
        $this->command?->line('Password: ' . $password);
        $this->command?->line('White Label expires: ' . $now->copy()->addMonthNoOverflow()->toDateString());
    }

    protected function upsertSubscription(User $user, ?SubscriptionPlan $plan, string $slug, $startsAt, $endsAt, float $amount): void
    {
        if (!$plan) {
            return;
        }

        Subscription::updateOrCreate(
            [
                'user_id' => $user->u_id,
                'plan_id' => $plan->id,
                'subscription_type' => $slug,
            ],
            [
                'u_id' => $user->u_id,
                'u_code' => $user->u_code,
                'billing_cycle' => 'monthly',
                'status' => Subscription::databaseStatusFor('active'),
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'subscription_expiry_date' => $endsAt->toDateString(),
                'amount' => $amount,
                'currency' => 'INR',
                'created_date' => $startsAt->toDateString(),
                'created_by' => 'a',
                'created_id' => 1,
                'updated_by' => 'a',
                'updated_id' => 1,
            ]
        );
    }
}
