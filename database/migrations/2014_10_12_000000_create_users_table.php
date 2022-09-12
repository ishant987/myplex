<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->bigIncrements('u_id');
                $table->string('u_code', 15)->unique()->comment('User Code');
                $table->enum('acc_type', ['', 'a', 's'])->comment('a=Application,s=Social');
                $table->enum('s_acc_medium', ['', 'g', 'f', 'm', 'a'])->nullable()->comment('g=Google,f=Facebook,m=Microsoft,a=Apple');
                $table->string('s_account', 30)->nullable();
                $table->string('f_name', 50);
                $table->string('l_name', 50)->nullable();
                $table->string('email', 50)->unique();
                $table->string('password', 64)->nullable();
                $table->string('forget_code', 50)->nullable();
                $table->string('mobile', 20)->nullable();
                $table->string('birthday', 10)->nullable();
                $table->string('p_picture', 255)->nullable();
                $table->string('pincode', 10)->nullable();
                $table->text('address')->nullable();
                $table->string('about', 128)->nullable();
                $table->string('profile', 255)->nullable();
                $table->string('company', 128)->nullable();
                $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
                $table->enum('is_approved', ['', 'n', 'y'])->default('n')->comment('n=no,y=yes');
                $table->string('remember_token', 100)->nullable();
                $table->string('note', 128)->nullable();
                $table->enum('created_by', ['', 'a', 'u'])->comment('a=admin,u=user');
                $table->bigInteger('created_id');
                $table->enum('updated_by', ['', 'a', 'u'])->comment('a=admin,u=user');
                $table->bigInteger('updated_id')->default(0);
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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['email']);
            });
        }
        Schema::dropIfExists('users');
    }
}
