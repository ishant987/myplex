<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class PendingArnDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment(['production'])) {
            $this->command?->error('PendingArnDemoSeeder cannot run in production.');
            return;
        }

        $users = [
            [
                'u_id' => 9011,
                'u_code' => 'UPEND001',
                'email' => 'pending.arn.one@myplexus.com',
                'password' => 'Pending@123',
                'f_name' => 'Pending',
                'l_name' => 'One',
                'contact_person' => 'Pending One',
                'company' => 'Pending One Advisors',
                'arn' => '1234501',
                'pan' => 'ABCDE1234F',
                'gst' => '22ABCDE1234F1Z5',
            ],
            [
                'u_id' => 9012,
                'u_code' => 'UPEND002',
                'email' => 'pending.arn.two@myplexus.com',
                'password' => 'Pending@123',
                'f_name' => 'Pending',
                'l_name' => 'Two',
                'contact_person' => 'Pending Two',
                'company' => 'Pending Two Wealth',
                'arn' => '1234502',
                'pan' => 'PQRST1234Z',
                'gst' => '27PQRST1234Z1Z5',
            ],
        ];

        foreach ($users as $demoUser) {
            $password = $demoUser['password'];

            $payload = [
                'u_id' => $demoUser['u_id'],
                'u_code' => $demoUser['u_code'],
                'acc_type' => 'a',
                's_acc_medium' => '',
                's_account' => null,
                'f_name' => $demoUser['f_name'],
                'l_name' => $demoUser['l_name'],
                'password' => Hash::make($password),
                'mobile' => '9999999999',
                'company' => $demoUser['company'],
                'status' => 1,
                'is_approved' => 'n',
                'created_by' => 'u',
                'created_id' => 0,
                'updated_by' => 'u',
                'updated_id' => 0,
                'contact_person' => $demoUser['contact_person'],
                'city' => 'Kolkata',
                'state' => 'West Bengal',
                'gst' => $demoUser['gst'],
                'arn' => $demoUser['arn'],
                'pan' => $demoUser['pan'],
                'subscription_status' => 'trial',
                'subscription_expiry_date' => now()->addDays(14)->toDateString(),
                'trial_ends_at' => now()->addDays(14),
                'email_verified_at' => now(),
            ];

            if (Schema::hasColumn('users', 'arn_verification_status')) {
                $payload['arn_verification_status'] = 'pending';
            }

            $user = User::updateOrCreate(['email' => $demoUser['email']], $payload);

            Subscription::updateOrCreate(
                [
                    'u_id' => $user->u_id,
                    'subscription_type' => 'free_subscription',
                ],
                [
                    'user_id' => $user->u_id,
                    'u_code' => $user->u_code,
                    'created_date' => now()->toDateString(),
                    'subscription_expiry_date' => now()->addDays(14)->toDateString(),
                    'status' => Subscription::databaseStatusFor('active'),
                    'created_by' => 'u',
                    'created_id' => $user->u_id,
                    'updated_by' => 'u',
                    'updated_id' => 0,
                ]
            );

            $this->command?->line("Pending ARN user: {$demoUser['email']} / {$password}");
        }
    }
}
