<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyFundHousePerformanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_fund_house_performance', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('mfhp_id');
            $table->date('dated');
            $table->bigInteger('fund_type_id');
            $table->string('timespan', 20);
            $table->string('fund_code', 50);
            $table->decimal('cagr', 10, 2)->nullable();
            $table->integer('cagr_rank')->nullable();
            $table->integer('cagr_rank_improvement')->nullable();
            $table->decimal('ret_less_idx', 38, 2)->nullable();
            $table->integer('ret_less_idx_rank')->nullable();
            $table->integer('ret_less_idx_rank_improvement')->nullable();
            $table->decimal('jensen', 38, 2)->nullable();
            $table->integer('jensen_rank')->nullable();
            $table->integer('jensen_rank_improvement')->nullable();
            $table->decimal('beta', 38, 2)->nullable();
            $table->integer('beta_rank')->nullable();
            $table->integer('beta_rank_improvement')->nullable();
            $table->decimal('co_var', 38, 2)->nullable();
            $table->integer('co_var_rank')->nullable();
            $table->integer('co_var_rank_improvement')->nullable();
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });

        Schema::table('monthly_fund_house_performance', function (Blueprint $table) {
            $table->unique(['dated', 'fund_type_id', 'timespan', 'fund_code'], 'dtd_fti_tmspn_fc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_fund_house_performance');

        if (Schema::hasTable('monthly_fund_house_performance')) {
            Schema::table('monthly_fund_house_performance', function (Blueprint $table) {
                $table->dropUnique('dtd_fti_tmspn_fc');
            });
        }
    }
}
