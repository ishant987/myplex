<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleUserRelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_user_rel', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('mur_id');
            $table->bigInteger('u_id')->comment('User ID');
            $table->enum('type', ['', 'aet'])->comment('aet=Ask Expert Topic');
            $table->addColumn('integer', 'data_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'comment' => '']);
            $table->timestamp('updated_at', 0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_user_rel');
    }
}
