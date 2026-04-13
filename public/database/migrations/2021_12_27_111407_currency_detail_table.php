<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CurrencyDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('cd_id');
            $table->addColumn('integer', 'cm_id', ['length' => 10, 'default' => '0', 'comment' => 'currency master id']);
            $table->date('entry_date');
            $table->float('entry_value')->nullable();
            $table->enum('publish', ['', 'y', 'n'])->comment('y=Yes,n=No')->default('n');
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });

        Schema::table('currency_detail', function (Blueprint $table) {
            $table->unique(['cm_id', 'entry_date'], 'cm_id_entry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('currency_detail')) {
            Schema::table('currency_detail', function (Blueprint $table) {
                $table->dropUnique('cm_id_entry_date');
            });
        }
        Schema::dropIfExists('currency_detail');
    }
}
