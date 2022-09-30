<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAskExpertTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ask_expert_topic', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('aet_id');
            $table->string('title', 128);
            $table->string('slug', 128);
            $table->addColumn('integer', 'media_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'parent', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->enum('created_medium', ['', 'w', 'ad'])->nullable()->comment('w=Website,ad=admin');
            $table->enum('created_by', ['', 'a', 'u'])->comment('a=admin,u=user');
            $table->bigInteger('created_id');
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
        Schema::dropIfExists('ask_expert_topic');
    }
}
