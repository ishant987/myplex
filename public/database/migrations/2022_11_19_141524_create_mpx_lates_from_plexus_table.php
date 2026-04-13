<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpxLatesFromPlexusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lates_from_plexus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('heading');
            $table->string('sub_heading');
            $table->string('link')->nullable();
            $table->integer('created_by');
            $table->integer('status')->default(2)->comment('1=enabled:2=disabled');
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
        Schema::dropIfExists('mpx_lates_from_plexus');
    }
}
