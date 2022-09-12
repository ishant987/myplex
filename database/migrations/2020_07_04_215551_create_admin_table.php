<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('admin_id');
            $table->addColumn('integer', 'role_id', ['length' => 10, 'comment' => 'User Role ID']);
            $table->string('username', 30)->unique();
            $table->string('password', 64);
            $table->string('display_name', 60);
            $table->string('first_name', 30);
            $table->string('last_name', 30)->nullable();
            $table->string('email', 60)->unique();
            $table->string('website', 100)->nullable();
            $table->string('secret', 64)->nullable();
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        if (Schema::hasTable('admin')) {
            Schema::table('admin', function (Blueprint $table) {
                $table->dropUnique(['username']);
                $table->dropUnique(['email']);
            });
        }
        Schema::dropIfExists('admin');
    }
}
