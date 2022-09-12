<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAskExpertQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ask_expert_question', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('aeq_id');
            $table->addColumn('integer', 'aet_id', ['length' => 10, 'comment' => '']);
            $table->text('question');
            $table->string('image1', 255)->nullable();
            $table->string('image2', 255)->nullable();
            $table->string('image3', 255)->nullable();
            $table->enum('video_from', ['', 'l', 'y'])->nullable()->comment('l=local,y=youtube');
            $table->string('video_data', 255)->nullable();
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->bigInteger('u_id')->default(0)->comment('User ID');
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
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
        Schema::dropIfExists('ask_expert_question');
    }
}
