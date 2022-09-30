<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorpusEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpus_entry', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('ce_id');
            $table->string('fund_code', 50);
            $table->date('entry_date');
            $table->float('corpus_entry')->nullable();
            $table->float('percentage_change')->nullable();
            $table->float('corpus_change')->nullable();
            $table->enum('publish', ['', 'y', 'n'])->comment('y=Yes,n=No')->default('n');
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });

        Schema::table('corpus_entry', function (Blueprint $table) {
            $table->unique(['fund_code', 'entry_date'], 'fund_code_entry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corpus_entry');

        if (Schema::hasTable('corpus_entry')) {
            Schema::table('corpus_entry', function (Blueprint $table) {
                $table->dropUnique('fund_code_entry_date');
            });
        }
    }
}
