<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('user_sensitive_details')) {
            return;
        }

        Schema::create('user_sensitive_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('company_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pan')->nullable();
            $table->string('arn')->nullable();
            $table->string('gst')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        if (Schema::hasTable('user_sensitive_details')) {
            Schema::dropIfExists('user_sensitive_details');
        }
    }
};
