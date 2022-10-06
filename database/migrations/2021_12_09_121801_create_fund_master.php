<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_master', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('fund_id');
            $table->string('fund_name', 255)->nullable();
            $table->string('fund_code', 50)->unique();
            $table->string('fund_manager', 255)->nullable();
            $table->addColumn('integer', 'fund_type_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'fund_term_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->float('face_value', 10, 4)->default(0.0000);
            $table->float('risk_free_return', 10, 4)->default(0.0000);
            $table->date('fund_opened')->nullable();
            $table->string('period', 255)->nullable();
            $table->string('remarks', 255)->nullable();
            $table->float('cost', 10, 4)->default(0.0000);
            $table->string('indices_name', 100)->nullable();
            $table->string('fund_house', 255)->nullable();
            $table->string('classification', 255)->nullable();
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_master');
    }
}
