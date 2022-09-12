<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('role_id');
            $table->string('title', 100)->unique();
            $table->text('info')->nullable();
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
        if (Schema::hasTable('auth_roles')) {
            Schema::table('auth_roles', function (Blueprint $table) {
                $table->dropUnique(['title']);
            });
        }
        Schema::dropIfExists('auth_roles');
    }
}
