<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('n_id');
            $table->string('title', 128);
            $table->string('slug', 128);
            $table->text('description')->nullable();
            $table->enum('media_type', ['', 'i', 'v'])->nullable()->comment('i=image,v=video');
            $table->string('image', 255)->nullable();
            $table->enum('video_from', ['', 'l', 'y'])->nullable()->comment('l=local,y=youtube');
            $table->string('video_data', 255)->nullable();
            $table->string('video_image', 255)->nullable();
            $table->string('news_source', 128)->nullable();
            $table->string('news_source_link', 500)->nullable();
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
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
        Schema::dropIfExists('news');
    }
}
