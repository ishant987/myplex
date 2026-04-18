<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('options')) {
            return;
        }

        $now = now();
        $rows = [
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Key ID',
                'option_key' => 'razorpay_key_id',
                'option_value' => config('razorpay.key_id'),
                'options_label' => null,
                'options_value' => null,
                'type' => 'options',
                'field_info' => 'Public Razorpay key used during checkout.',
                'is_required' => 'y',
                'c_order' => 101,
                'status' => 1,
                'updated_id' => 1,
                'updated_at' => $now,
            ],
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Key Secret',
                'option_key' => 'razorpay_key_secret',
                'option_value' => config('razorpay.key_secret'),
                'options_label' => null,
                'options_value' => null,
                'type' => 'options',
                'field_info' => 'Secret Razorpay key used for server-side requests.',
                'is_required' => 'y',
                'c_order' => 102,
                'status' => 1,
                'updated_id' => 1,
                'updated_at' => $now,
            ],
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Webhook Secret',
                'option_key' => 'razorpay_webhook_secret',
                'option_value' => config('razorpay.webhook_secret'),
                'options_label' => null,
                'options_value' => null,
                'type' => 'options',
                'field_info' => 'Webhook secret for verifying Razorpay callbacks.',
                'is_required' => 'n',
                'c_order' => 103,
                'status' => 1,
                'updated_id' => 1,
                'updated_at' => $now,
            ],
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Currency',
                'option_key' => 'razorpay_currency',
                'option_value' => config('razorpay.currency', 'INR'),
                'options_label' => null,
                'options_value' => null,
                'type' => 'options',
                'field_info' => 'Currency sent while creating Razorpay orders.',
                'is_required' => 'y',
                'c_order' => 104,
                'status' => 1,
                'updated_id' => 1,
                'updated_at' => $now,
            ],
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Company Name',
                'option_key' => 'razorpay_company_name',
                'option_value' => config('razorpay.company_name', 'MyPlexus'),
                'options_label' => null,
                'options_value' => null,
                'type' => 'options',
                'field_info' => 'Company name shown in the Razorpay checkout.',
                'is_required' => 'y',
                'c_order' => 105,
                'status' => 1,
                'updated_id' => 1,
                'updated_at' => $now,
            ],
        ];

        foreach ($rows as $row) {
            $exists = DB::table('options')->where('option_key', $row['option_key'])->exists();

            if (!$exists) {
                DB::table('options')->insert($row);
            }
        }
    }

    public function down()
    {
        if (!Schema::hasTable('options')) {
            return;
        }

        DB::table('options')
            ->whereIn('option_key', [
                'razorpay_key_id',
                'razorpay_key_secret',
                'razorpay_webhook_secret',
                'razorpay_currency',
                'razorpay_company_name',
            ])
            ->delete();
    }
};
