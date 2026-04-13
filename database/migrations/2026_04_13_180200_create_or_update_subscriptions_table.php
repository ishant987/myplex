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
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('plan_id')->nullable();
                $table->string('razorpay_order_id')->nullable();
                $table->string('razorpay_payment_id')->nullable();
                $table->string('razorpay_subscription_id')->nullable();
                $table->enum('billing_cycle', ['monthly', 'yearly'])->nullable();
                $table->enum('status', ['pending', 'active', 'failed', 'cancelled'])->default('pending');
                $table->timestamp('starts_at')->nullable();
                $table->timestamp('ends_at')->nullable();
                $table->timestamp('trial_ends_at')->nullable();
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('currency', 3)->default('INR');
                $table->timestamps();
            });

            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscriptions', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
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

        if (Schema::hasColumn('subscriptions', 'user_id') && Schema::hasColumn('subscriptions', 'u_id')) {
            DB::table('subscriptions')
                ->whereNull('user_id')
                ->orWhere('user_id', 0)
                ->update(['user_id' => DB::raw('u_id')]);
        }

        if (Schema::hasColumn('subscriptions', 'status') && DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE subscriptions MODIFY status ENUM('', 'a', 'e', 'pending', 'active', 'failed', 'cancelled') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down()
    {
        if (!Schema::hasTable('subscriptions')) {
            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('subscriptions', 'currency')) {
                $table->dropColumn('currency');
            }

            if (Schema::hasColumn('subscriptions', 'amount')) {
                $table->dropColumn('amount');
            }

            if (Schema::hasColumn('subscriptions', 'trial_ends_at')) {
                $table->dropColumn('trial_ends_at');
            }

            if (Schema::hasColumn('subscriptions', 'ends_at')) {
                $table->dropColumn('ends_at');
            }

            if (Schema::hasColumn('subscriptions', 'starts_at')) {
                $table->dropColumn('starts_at');
            }

            if (Schema::hasColumn('subscriptions', 'billing_cycle')) {
                $table->dropColumn('billing_cycle');
            }

            if (Schema::hasColumn('subscriptions', 'razorpay_subscription_id')) {
                $table->dropColumn('razorpay_subscription_id');
            }

            if (Schema::hasColumn('subscriptions', 'razorpay_payment_id')) {
                $table->dropColumn('razorpay_payment_id');
            }

            if (Schema::hasColumn('subscriptions', 'razorpay_order_id')) {
                $table->dropColumn('razorpay_order_id');
            }

            if (Schema::hasColumn('subscriptions', 'plan_id')) {
                $table->dropColumn('plan_id');
            }

            if (Schema::hasColumn('subscriptions', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};
