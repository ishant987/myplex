<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldGroupTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_field_group_type', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('cf_group_type_id');
            $table->bigInteger('cf_group_id');
            $table->string('field_name', 50);
            $table->string('field_type', 50);
            $table->enum('field_for', ['', 'a', 'w', 'ap'])->comment('a=All(used for both App/Website,w=Website,ap=App');
            $table->json('field_options')->comment('user customized Json field options');
            $table->bigInteger('c_order')->default(0);
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'comment' => '']);
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
        Schema::dropIfExists('custom_field_group_type');
    }
}
