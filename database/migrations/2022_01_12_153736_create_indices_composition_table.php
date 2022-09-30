<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicesCompositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indices_composition', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('ic_id');
            $table->date('entry_date');
            $table->string('indices_name', 150)->comment('It\'s a corelation');
            $table->string('scrip_name', 150);
            $table->string('type', 128)->nullable();
            $table->string('industry', 128)->nullable();
            $table->float('percentage')->nullable();
            $table->enum('publish', ['', 'y', 'n'])->comment('y=Yes,n=No')->default('n');
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });

        Schema::table('indices_composition', function (Blueprint $table) {
            $table->unique(['entry_date', 'indices_name', 'scrip_name'], 'ed_in_sn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indices_composition');

        if (Schema::hasTable('indices_composition')) {
            Schema::table('indices_composition', function (Blueprint $table) {
                $table->dropUnique('ed_in_sn');
            });
        }
    }
}
