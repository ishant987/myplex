<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'trial_ends_at')) {
                $table->timestamp('trial_ends_at')->nullable()->after('subscription_expiry_date');
            }

            if (!Schema::hasColumn('users', 'session_token')) {
                $table->string('session_token', 100)->nullable()->after('trial_ends_at');
            }

            if (!Schema::hasColumn('users', 'is_session_active')) {
                $table->boolean('is_session_active')->default(false)->after('session_token');
            }

            if (!Schema::hasColumn('users', 'subscription_status')) {
                $table->enum('subscription_status', ['trial', 'active', 'expired', 'cancelled'])->default('trial')->after('is_session_active');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'subscription_status')) {
                $table->dropColumn('subscription_status');
            }

            if (Schema::hasColumn('users', 'is_session_active')) {
                $table->dropColumn('is_session_active');
            }

            if (Schema::hasColumn('users', 'session_token')) {
                $table->dropColumn('session_token');
            }

            if (Schema::hasColumn('users', 'trial_ends_at')) {
                $table->dropColumn('trial_ends_at');
            }
        });
    }
};
