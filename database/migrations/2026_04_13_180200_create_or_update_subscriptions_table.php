<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add new columns to existing mpx_user_subscription table
        Schema::table('mpx_user_subscription', function (Blueprint $table) {
            if (!Schema::hasColumn('mpx_user_subscription', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('mpx_user_subscription', 'razorpay_order_id')) {
                $table->string('razorpay_order_id')->nullable();
            }
            if (!Schema::hasColumn('mpx_user_subscription', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id')->nullable();
            }
            if (!Schema::hasColumn('mpx_user_subscription', 'razorpay_subscription_id')) {
                $table->string('razorpay_subscription_id')->nullable();
            }
            if (!Schema::hasColumn('mpx_user_subscription', 'billing_cycle')) {
                $table->enum('billing_cycle', ['monthly', 'yearly'])->nullable();
            }
            if (!Schema::hasColumn('mpx_user_subscription', 'starts_at')) {
                $table->timestamp('starts_at')->nullable();
            }
            if (!Schema::hasColumn('mpx_user_subscription', 'ends_at')) {
                $table->timestamp('ends_at')->nullable();
            }
            if (!Schema::hasColumn('mpx_user_subscription', 'trial_ends_at')) {
                $table->timestamp('trial_ends_at')->nullable();
            }
            if (!Schema::hasColumn('mpx_user_subscription', 'amount')) {
                $table->decimal('amount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('mpx_user_subscription', 'currency')) {
                $table->string('currency', 3)->default('INR');
            }
        });

        // Modify status column to include new enum values
        if (Schema::hasColumn('mpx_user_subscription', 'status') && DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE mpx_user_subscription MODIFY status ENUM('', 'a', 'e', 'pending', 'active', 'failed', 'cancelled') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down()
    {
        Schema::table('mpx_user_subscription', function (Blueprint $table) {
            $columns = [
                'currency', 'amount', 'trial_ends_at', 'ends_at',
                'starts_at', 'billing_cycle', 'razorpay_subscription_id',
                'razorpay_payment_id', 'razorpay_order_id', 'plan_id'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('mpx_user_subscription', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};