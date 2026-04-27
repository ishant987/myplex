<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'wl_company_name')) {
                $table->string('wl_company_name')->nullable()->after('subscription_status');
            }

            if (!Schema::hasColumn('users', 'wl_logo')) {
                $table->string('wl_logo')->nullable()->after('wl_company_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'wl_logo')) {
                $table->dropColumn('wl_logo');
            }

            if (Schema::hasColumn('users', 'wl_company_name')) {
                $table->dropColumn('wl_company_name');
            }
        });
    }
};
