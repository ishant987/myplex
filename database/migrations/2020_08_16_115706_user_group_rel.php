<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserGroupRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_group_rel')) {
            Schema::create('user_group_rel', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('u_g_r_id');
                $table->addColumn('integer', 'u_g_id', ['length' => 10, 'comment' => 'User Group ID']);
                $table->bigInteger('u_id')->comment('User ID');
                $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
                $table->timestamp('updated_at', 0);
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_group_rel');
    }
}
