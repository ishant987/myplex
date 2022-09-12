<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundWatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_watch', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('fw_id');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('file', 255)->nullable();
            $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
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
        Schema::dropIfExists('fund_watch');
    }
}
