<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorpusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('corpus_id');
            $table->addColumn('integer', 'fund_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->string('fund', 255);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
        });

        Schema::table('corpus', function (Blueprint $table) {
            $table->unique(['fund_id', 'fund'], 'fund_id_fund_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('corpus')) {
            Schema::table('corpus', function (Blueprint $table) {
                $table->dropUnique('fund_id_fund_unique');
            });
        }
        Schema::dropIfExists('corpus');
    }
}
