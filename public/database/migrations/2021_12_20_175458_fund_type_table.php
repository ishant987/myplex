<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FundTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_type', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('ft_id');
            $table->string('name', 255)->nullable();
            $table->enum('active_passive', ['', 'A', 'P'])->nullable()->comment('A=Active,P=Passive');
            $table->enum('monthly_performance', ['', 'Y', 'N'])->nullable()->comment('Y=Yes,N=No');
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
        Schema::dropIfExists('fund_type');
    }
}
