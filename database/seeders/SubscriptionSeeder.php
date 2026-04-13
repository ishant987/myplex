<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Seed the subscriptions table with a subscription for the test user.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment(['production'])) {
            print "\nOpps! you are in production environment. You are not authorized to run.\n";
            die();
        }

        DB::table('subscriptions')->delete();

        $now = now();

        $dataArr = [
            [
                'u_id'                     => 1,
                'u_code'                   => 'U0000001',
                'subscription_type'        => 'free_subscription',
                'created_date'             => $now->format('Y-m-d'),
                'subscription_expiry_date' => $now->copy()->addYear()->format('Y-m-d'),
                'status'                   => 'a',
                'created_by'               => 'a',
                'created_id'               => 1,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
        ];

        DB::table('subscriptions')->insert($dataArr);
        $this->command->info('subscriptions table seeded!');
    }
}
