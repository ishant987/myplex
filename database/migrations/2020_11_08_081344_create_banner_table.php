<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('bnr_id');
            $table->string('bnr_group', 128);
            $table->addColumn('integer', 'media_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->string('title', 128)->nullable();
            $table->text('descp')->nullable();
            $table->string('link', 128)->nullable();
            $table->string('link_text', 60)->nullable();
            $table->string('link_target', 20)->nullable();
            $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
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
        Schema::dropIfExists('banner');
    }
}
