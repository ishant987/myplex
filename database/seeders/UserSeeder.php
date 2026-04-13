<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the users table with a test user for local development.
     *
     * Credentials:
     *   Email:    testuser@myplexus.com
     *   Password: User@1234
     *
     * @return void
     */
    public function run()
    {
        if (App::environment(['production'])) {
            print "\nOpps! you are in production environment. You are not authorized to run.\n";
            die();
        }

        // Clear existing users
        DB::table('users')->delete();

        $now = now();

        $dataArr = [
            [
                'u_id'       => 1,
                'u_code'     => 'U0000001',
                'acc_type'   => 'a',
                's_acc_medium' => '',
                's_account'  => null,
                'f_name'     => 'Test',
                'l_name'     => 'User',
                'email'      => 'testuser@myplexus.com',
                'password'   => Hash::make('User@1234'),
                'forget_code' => null,
                'mobile'     => '9876543210',
                'birthday'   => '1990-01-01',
                'p_picture'  => null,
                'pincode'    => '560001',
                'address'    => 'Bangalore, India',
                'about'      => 'Test user for local development',
                'profile'    => null,
                'company'    => 'MyPlexus Dev',
                'status'     => 1,
                'is_approved' => 'y',
                'remember_token' => null,
                'note'       => null,
                'created_by' => 'a',
                'created_id' => 1,
                'updated_by' => 'a',
                'updated_id' => 1,
                'contact_person' => 'Test User',
                'city'       => 'Bangalore',
                'state'      => 'Karnataka',
                'gst'        => '29ABCDE1234F1Z5',
                'arn'        => '12345',
                'pan'        => 'ABCDE1234F',
                'subscription_expiry_date' => $now->copy()->addYear()->format('Y-m-d H:i:s'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('users')->insert($dataArr);
        $this->command->info('users table seeded! (testuser@myplexus.com / User@1234)');
    }
}
