<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundCorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_core', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('ftm_id');
            $table->addColumn('integer', 'fund_id', ['length' => 10, 'default' => '0', 'comment' => '', 'unique' => true]);
            $table->text('cor')->nullable();
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
        Schema::dropIfExists('fund_core');
    }
}
