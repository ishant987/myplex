<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('category');
            $table->string('heading');
            $table->text('description');
            $table->string('url');
            $table->string('author');
            $table->string('image_banner');
            $table->string('image_thumb');
            $table->integer('cta_type')->default(0);
            $table->string('cta_url')->nullable();
            $table->integer('created_by')->comment('Reference to Admin ID'); //admin name
            $table->integer('published_by')->comment('Reference to Admin ID'); //admin name
            $table->dateTime('published_date');
            $table->tinyInteger('is_active')->default(0);
            $table->string('tags')->nullable();
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
        Schema::dropIfExists('blog');
    }
}
