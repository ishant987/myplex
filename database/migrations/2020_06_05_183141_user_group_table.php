<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_group')) {
            Schema::create('user_group', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('u_g_id');
                $table->string('group_name', 60);
                $table->text('descp')->nullable();
                $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
                $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
                $table->timestamps();
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
        Schema::dropIfExists('user_group');
    }
}
