<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('team_id');
            $table->string('name', 90);
            $table->addColumn('integer', 'media_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->string('designation', 128)->nullable();
            $table->string('linkedin_link', 128)->nullable();
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
        Schema::dropIfExists('teams');
    }
}
