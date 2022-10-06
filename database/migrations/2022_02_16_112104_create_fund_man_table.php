<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundManTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_man', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('fm_id');
            $table->string('name', 128);
            $table->string('slug', 128);
            $table->string('profile_picture', 255)->nullable();
            $table->string('designation', 128)->nullable();
            $table->string('company_name', 128)->nullable();
            $table->string('synopsis', 512)->nullable();
            $table->text('description')->nullable();
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_man');
    }
}
