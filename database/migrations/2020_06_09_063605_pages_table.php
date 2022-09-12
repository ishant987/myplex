<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('page_id');
            $table->string('title', 128);
            $table->string('slug', 128);
            $table->text('descp')->nullable();
            $table->addColumn('integer', 'media_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'parent', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'template_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('tinyInteger', 'is_private', ['length' => 1, 'default' => '1', 'comment' => '1=private access(set access in usergroup),0=public page']);
            $table->string('note', 256)->nullable();
            $table->string('meta_title', 128)->nullable();
            $table->string('meta_key', 128)->nullable();
            $table->text('meta_descp')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
