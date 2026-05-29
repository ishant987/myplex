<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddWelcomeEmailSentAtToUsersTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'welcome_email_sent_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('welcome_email_sent_at')->nullable()->after('email_verified_at');
            });

            DB::table('users')
                ->where('created_at', '<', now()->subMinute())
                ->update(['welcome_email_sent_at' => now()]);
        }
    }

    public function down()
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'welcome_email_sent_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('welcome_email_sent_at');
            });
        }
    }
}
