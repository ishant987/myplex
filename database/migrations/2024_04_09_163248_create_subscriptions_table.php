<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('u_id')->default(0)->comment('User id');
            $table->string('u_code')->nullable()->comment('User code');
            $table->string('subscription_type')->nullable();
         
            $table->date('created_date')->nullable();
            $table->date('subscription_expiry_date')->nullable();
            $table->enum('status', ['', 'a', 'e'])->comment('a=Active,e=Expired');
            $table->enum('created_by', ['', 'a', 'u'])->comment('a=admin,u=user');
            $table->bigInteger('created_id');
            $table->enum('updated_by', ['', 'a', 'u'])->nullable()->comment('a=admin,u=user');
            $table->bigInteger('updated_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
