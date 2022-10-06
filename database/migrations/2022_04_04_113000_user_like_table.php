<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_like', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('u_lk_id');
            $table->enum('type', ['', 'ae', 'aea'])->comment('ae=Ask Expert,aea=Ask Expert Answer');
            $table->addColumn('integer', 'data_id', ['length' => 10, 'comment' => '']);
            $table->bigInteger('u_id')->comment('User ID');
            $table->timestamp('created_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_like');
    }
}
