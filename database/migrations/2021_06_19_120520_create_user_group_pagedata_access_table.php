<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGroupPagedataAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group_pagedata_access', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('u_g_pd_a_id');
            $table->addColumn('integer', 'module_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'u_g_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'data_id', ['length' => 10, 'comment' => 'Individual modules page id']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('user_group_pagedata_access', function (Blueprint $table) {
            $table->unique(['module_id', 'u_g_id', 'data_id'], 'module_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_group_pagedata_access');

        if (Schema::hasTable('user_group_pagedata_access')) {
            Schema::table('user_group_pagedata_access', function (Blueprint $table) {
                $table->dropUnique('module_id');
            });
        }
    }
}
