<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleModuleMethodRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_module_method_rights', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('role_module_method_right_id');
            $table->addColumn('integer', 'role_id', ['length' => 10, 'comment' => 'User Role ID']);
            $table->addColumn('integer', 'module_id', ['length' => 10, 'comment' => 'Module ID']);
            $table->addColumn('integer', 'method_id', ['length' => 10, 'comment' => 'Method ID']);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('role_module_method_rights', function (Blueprint $table) {
            $table->unique(['role_id', 'module_id', 'method_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('role_module_method_rights')) {
            Schema::table('role_module_method_rights', function (Blueprint $table) {
                $table->dropUnique('ezs_role_module_method_rights_role_id_module_id_method_id_unique');
            });
        }
        Schema::dropIfExists('role_module_method_rights');
    }
}
