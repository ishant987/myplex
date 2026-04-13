<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('menu_id');
            $table->addColumn('integer', 'menu_type_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'class_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'data_id', ['length' => 10, 'default' => '0', 'comment' => 'universal id']);
            $table->string('label', 100)->nullable();
            $table->string('hint', 255)->nullable();
            $table->addColumn('tinyInteger', 'is_link', ['length' => 1, 'default' => '0', 'comment' => '']);
            $table->string('external_link', 255)->nullable();
            $table->enum('link_target', ['', '_blank', '_self'])->nullable();
            $table->string('menu_class', 60)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->addColumn('integer', 'parent_menu_id', ['length' => 10, 'default' => '0', 'comment' => 'Parent Menu ID']);
            $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
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
        Schema::dropIfExists('menu');
    }
}
