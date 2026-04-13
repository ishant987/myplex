<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskTolerancePortfolioRegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_tolerance_portfolio_reg', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('portfolio_id');
            $table->string('reg_name', 100);
            $table->string('reg_email', 100);
            $table->tinyInteger('q1_v1')->default(0);
            $table->tinyInteger('q1_v2')->default(0);
            $table->tinyInteger('q1_v3')->default(0);
            $table->tinyInteger('q1_v4')->default(0);
            $table->tinyInteger('q1_v5')->default(0);
            $table->tinyInteger('q1_v6')->default(0);
            $table->tinyInteger('q1_v7')->default(0);
            $table->tinyInteger('q2_v1')->default(0);
            $table->tinyInteger('q2_v2')->default(0);
            $table->tinyInteger('q3_v1')->default(0);
            $table->tinyInteger('q3_v2')->default(0);
            $table->tinyInteger('q3_v3')->default(0);
            $table->tinyInteger('q3_v4')->default(0);
            $table->tinyInteger('q3_v5')->default(0);
            $table->tinyInteger('q3_v6')->default(0);
            $table->tinyInteger('q3_v7')->default(0);
            $table->tinyInteger('q3_v8')->default(0);
            $table->tinyInteger('q3_v9')->default(0);
            $table->tinyInteger('q3_v10')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('created_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_tolerance_portfolio_reg');
    }
}
