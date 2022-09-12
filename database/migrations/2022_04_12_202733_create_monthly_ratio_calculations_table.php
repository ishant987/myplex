<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyRatioCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_ratio_calculations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->date('start_date');
            $table->date('end_date');
            $table->string('fund_code', 100)->nullable();
            $table->string('fund_name', 255)->nullable();
            $table->float('per_change_aaum')->nullable();
            $table->float('aaum')->nullable();
            $table->float('one_year_return')->nullable();
            $table->float('p1_volatality')->nullable();
            $table->float('p2_volatality')->nullable();
            $table->float('p3_volatality')->nullable();
            $table->float('p4_volatality')->nullable();
            $table->float('p1_beta')->nullable();
            $table->float('p2_beta')->nullable();
            $table->float('p3_beta')->nullable();
            $table->float('p4_beta')->nullable();
            $table->float('p1_jensen_alpha')->nullable();
            $table->float('p2_jensen_alpha')->nullable();
            $table->float('p3_jensen_alpha')->nullable();
            $table->float('p4_jensen_alpha')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_ratio_calculations');
    }
}
