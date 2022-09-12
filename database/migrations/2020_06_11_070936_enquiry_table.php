<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiry', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('enq_id');
            $table->bigInteger('u_id')->default(0)->comment('User ID');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('mobile', 20)->nullable();
            $table->text('message')->nullable();
            $table->timestamp('created_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enquiry');
    }
}
