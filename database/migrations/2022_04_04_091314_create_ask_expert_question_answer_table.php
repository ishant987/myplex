<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAskExpertQuestionAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ask_expert_question_answer', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('aeqa_id');
            $table->addColumn('integer', 'aeq_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'aet_id', ['length' => 10, 'comment' => '']);
            $table->bigInteger('u_id')->default(0)->comment('User ID (Expert ID)');
            $table->text('answer');
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->enum('updated_by', ['', 'a', 'u'])->nullable()->comment('a=admin,u=user');
            $table->bigInteger('updated_id');
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
        Schema::dropIfExists('ask_expert_question_answer');
    }
}
