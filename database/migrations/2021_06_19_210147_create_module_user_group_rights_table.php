<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleUserGroupRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_user_group_rights', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('m_u_g_a_id');
            $table->addColumn('integer', 'module_id', ['length' => 10, 'comment' => '', 'unique' => true]);
            $table->addColumn('integer', 'u_g_id', ['length' => 10, 'comment' => '', 'unique' => true]);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_user_group_rights');
    }
}
