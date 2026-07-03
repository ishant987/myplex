<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewFromMyplexusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('new_from_myplexus')) {
            Schema::create('new_from_myplexus', function (Blueprint $table) {
                $table->id();
                $table->integer('type_id')->nullable();
                $table->string('title')->nullable();
                $table->string('link')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_from_myplexus');
    }
}
