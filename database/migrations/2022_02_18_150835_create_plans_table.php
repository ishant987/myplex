<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('p_id');
            $table->string('plan_name', 128);
            $table->text('description')->nullable();
            $table->double('amount', 6, 2)->default(0.00);
            $table->enum('plan_type', ['', 'ff', 'lp'])->default('lp')->comment('ff=Free Forever,lp=Limited Period');
            $table->addColumn('tinyInteger', 'duration', ['length' => 1, 'default' => '0', 'comment' => 'Must be in days']);
            $table->string('duration_name', 128)->nullable();
            $table->enum('free_trial', ['', 'n', 'y'])->default('n')->comment('n=no,y=yes');
            $table->enum('show_on_wa', ['', 'n', 'y'])->default('n')->comment('n=no,y=yes');
            $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
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
        Schema::dropIfExists('plans');
    }
}
