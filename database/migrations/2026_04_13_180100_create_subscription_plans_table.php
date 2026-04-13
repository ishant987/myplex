<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('subscription_plans')) {
            return;
        }

        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price_monthly', 10, 2);
            $table->decimal('price_yearly', 10, 2);
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('razorpay_plan_id_monthly')->nullable();
            $table->string('razorpay_plan_id_yearly')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        if (Schema::hasTable('subscription_plans')) {
            Schema::dropIfExists('subscription_plans');
        }
    }
};
