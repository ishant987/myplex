<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoPagesTable extends Migration
{
    public function up()
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_title');
            $table->string('url_slug')->unique();
            $table->string('page_type', 50)->default('blog');
            $table->string('category', 100)->nullable();
            $table->string('author', 100)->nullable();
            $table->date('publish_date')->nullable();
            $table->string('status', 20)->default('draft');
            $table->text('short_description')->nullable();
            $table->longText('full_content')->nullable();
            $table->text('tags')->nullable();
            $table->text('featured_image_url')->nullable();
            $table->string('image_alt_text')->nullable();
            $table->string('seo_title', 60)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->string('focus_keyword')->nullable();
            $table->text('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_image_url')->nullable();
            $table->string('schema_type', 50)->default('BlogPosting');
            $table->boolean('is_indexed')->default(true);
            $table->unsignedTinyInteger('seo_score')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('seo_page_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_page_id')->constrained('seo_pages')->cascadeOnDelete();
            $table->json('content_snapshot');
            $table->timestamp('saved_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seo_page_versions');
        Schema::dropIfExists('seo_pages');
    }
}
