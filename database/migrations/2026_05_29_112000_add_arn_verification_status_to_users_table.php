<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddArnVerificationStatusToUsersTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'arn_verification_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('arn_verification_status', 20)->default('pending')->after('arn');
            });

            DB::table('users')
                ->where('is_approved', 'y')
                ->update(['arn_verification_status' => 'verified']);
        }
    }

    public function down()
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'arn_verification_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('arn_verification_status');
            });
        }
    }
}
