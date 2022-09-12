<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowTheRatioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('know_the_ratio', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('ktr_id');
            $table->string('title', 128);
            $table->text('description')->nullable();
            $table->addColumn('integer', 'media_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
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
        Schema::dropIfExists('know_the_ratio');
    }
}
