<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundCompositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_composition', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('fc_id');
            $table->date('entry_date');
            $table->string('fund_code', 50);
            $table->string('scrip_name', 150);
            $table->string('industry', 128)->nullable();
            $table->string('category', 128)->nullable();
            $table->float('content_per')->nullable();
            $table->float('amount')->nullable();
            $table->float('no_of_shares')->nullable();
            $table->float('indices_per')->nullable();
            $table->enum('publish', ['', 'y', 'n'])->comment('y=Yes,n=No')->default('n');
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });

        Schema::table('fund_composition', function (Blueprint $table) {
            $table->unique(['entry_date', 'fund_code', 'scrip_name'], 'ed_fc_sn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_composition');

        if (Schema::hasTable('fund_composition')) {
            Schema::table('fund_composition', function (Blueprint $table) {
                $table->dropUnique('ed_fc_sn');
            });
        }
    }
}
