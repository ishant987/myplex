<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('subscriptions')) {
            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscriptions', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('subscription_expiry_date');
            }

            if (!Schema::hasColumn('subscriptions', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('subscriptions', 'razorpay_order_id')) {
                $table->string('razorpay_order_id')->nullable()->after('plan_id');
            }

            if (!Schema::hasColumn('subscriptions', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id')->nullable()->after('razorpay_order_id');
            }

            if (!Schema::hasColumn('subscriptions', 'razorpay_subscription_id')) {
                $table->string('razorpay_subscription_id')->nullable()->after('razorpay_payment_id');
            }

            if (!Schema::hasColumn('subscriptions', 'billing_cycle')) {
                $table->enum('billing_cycle', ['monthly', 'yearly'])->nullable()->after('razorpay_subscription_id');
            }

            if (!Schema::hasColumn('subscriptions', 'starts_at')) {
                $table->timestamp('starts_at')->nullable()->after('billing_cycle');
            }

            if (!Schema::hasColumn('subscriptions', 'ends_at')) {
                $table->timestamp('ends_at')->nullable()->after('starts_at');
            }

            if (!Schema::hasColumn('subscriptions', 'trial_ends_at')) {
                $table->timestamp('trial_ends_at')->nullable()->after('ends_at');
            }

            if (!Schema::hasColumn('subscriptions', 'amount')) {
                $table->decimal('amount', 10, 2)->default(0)->after('trial_ends_at');
            }

            if (!Schema::hasColumn('subscriptions', 'currency')) {
                $table->string('currency', 3)->default('INR')->after('amount');
            }
        });

        if (Schema::hasColumn('subscriptions', 'u_id') && Schema::hasColumn('subscriptions', 'user_id')) {
            DB::table('subscriptions')
                ->whereNull('user_id')
                ->update(['user_id' => DB::raw('u_id')]);
        }

        if (DB::getDriverName() === 'mysql') {
            $tableName = DB::getTablePrefix() . 'subscriptions';
            DB::statement("ALTER TABLE {$tableName} MODIFY status ENUM('', 'a', 'e', 'pending', 'active', 'failed', 'cancelled', 'expired') NOT NULL DEFAULT ''");
        }
    }

    public function down()
    {
        if (!Schema::hasTable('subscriptions')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            $tableName = DB::getTablePrefix() . 'subscriptions';
            DB::statement("ALTER TABLE {$tableName} MODIFY status ENUM('', 'a', 'e') NOT NULL DEFAULT ''");
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            $columns = [
                'currency',
                'amount',
                'trial_ends_at',
                'ends_at',
                'starts_at',
                'billing_cycle',
                'razorpay_subscription_id',
                'razorpay_payment_id',
                'razorpay_order_id',
                'plan_id',
                'user_id',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('subscriptions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
