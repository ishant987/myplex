<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscription', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('us_id');
            $table->bigInteger('u_id')->default(0)->comment('User id');
            $table->addColumn('integer', 'p_id', ['length' => 10, 'default' => '0', 'comment' => 'Plan id']);
            $table->enum('plan_type', ['', 'ff', 'lp'])->default('lp')->comment('ff=Free Forever,lp=Limited Period');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('user_subscription');
    }
}
