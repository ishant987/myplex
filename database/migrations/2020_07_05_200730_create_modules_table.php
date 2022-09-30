<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('module_id');
            $table->addColumn('integer', 'class_id', ['length' => 10, 'comment' => '']);
            $table->enum('has_templates', ['', 'n', 'y'])->comment('y=Yes,n=No');
            $table->enum('set_user_rights', ['', 'n', 'y'])->comment('y=Yes,n=No');
            $table->string('title', 128);
            $table->string('label', 255)->nullable();
            $table->text('info')->nullable();
            $table->string('class_name', 191)->unique();
            $table->addColumn('tinyInteger', 'is_menu', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'parent_module_id', ['length' => 10, 'default' => '0', 'comment' => 'Parent Module ID']);
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('modules')) {
            Schema::table('modules', function (Blueprint $table) {
                $table->dropUnique(['title']);
                $table->dropUnique(['class_name']);
            });
        }
        Schema::dropIfExists('modules');
    }
}
