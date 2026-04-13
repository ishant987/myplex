<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('fd_id');
            $table->string('fund_code', 50);
            $table->date('entry_date');
            $table->float('closing_nav')->nullable();
            $table->addColumn('tinyInteger', 'holiday', ['length' => 1, 'default' => '0', 'comment' => '']);
            $table->float('percentage_change')->nullable();
            $table->enum('publish', ['', 'y', 'n'])->comment('y=Yes,n=No')->default('n');
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });

        Schema::table('fund_detail', function (Blueprint $table) {
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
        Schema::dropIfExists('fund_detail');

        if (Schema::hasTable('fund_detail')) {
            Schema::table('fund_detail', function (Blueprint $table) {
                $table->dropUnique('fund_code_entry_date');
            });
        }
    }
}
