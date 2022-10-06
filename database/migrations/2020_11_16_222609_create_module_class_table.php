<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_class', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('class_id');
            $table->string('class_name', 191)->unique();
            $table->string('model_name', 255);
            $table->string('slug', 100)->unique();
            $table->text('info')->nullable();
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
        Schema::dropIfExists('module_class');
    }
}
