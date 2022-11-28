<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundWatchNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_watch_new', function (Blueprint $table) {
            $table->id();
            $table->string('fund_code')->comment('fund master table fund code column');
            $table->text('preamble');
            $table->text('team');
            $table->text('philosophy');
            $table->text('investment_style');
            $table->text('composition_analysis_top');
            $table->text('composition_analysis_bottom');
            $table->text('feedback');
            $table->integer('status')->defalut(2);
            $table->integer('updated_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_watch_new');
    }
}
