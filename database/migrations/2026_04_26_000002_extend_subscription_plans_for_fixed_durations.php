<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_plans', 'duration_months')) {
                $table->unsignedInteger('duration_months')->default(1)->after('price_yearly');
            }

            if (!Schema::hasColumn('subscription_plans', 'allow_trial')) {
                $table->boolean('allow_trial')->default(true)->after('duration_months');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            if (Schema::hasColumn('subscription_plans', 'allow_trial')) {
                $table->dropColumn('allow_trial');
            }

            if (Schema::hasColumn('subscription_plans', 'duration_months')) {
                $table->dropColumn('duration_months');
            }
        });
    }
};
