<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_master', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('cm_id');
            $table->string('name', 50)->nullable();
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
        Schema::dropIfExists('currency_master');
    }
}
