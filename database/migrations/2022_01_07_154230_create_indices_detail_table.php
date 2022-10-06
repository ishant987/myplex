<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indices_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idcd_id');
            $table->string('name', 255)->comment('It\'s a corelation');
            $table->date('entry_date');
            $table->float('closing_value')->nullable(0.0000);
            $table->addColumn('tinyInteger', 'holiday', ['length' => 1, 'default' => '0', 'comment' => '']);
            $table->float('percentage_change')->nullable(0.0000);
            $table->enum('publish', ['', 'y', 'n'])->comment('y=Yes,n=No')->default('n');
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });

        Schema::table('indices_detail', function (Blueprint $table) {
            $table->unique(['name', 'entry_date'], 'indices_name_entry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('indices_detail')) {
            Schema::table('indices_detail', function (Blueprint $table) {
                $table->dropUnique('indices_name_entry_date');
            });
        }

        Schema::dropIfExists('indices_detail');
    }
}
