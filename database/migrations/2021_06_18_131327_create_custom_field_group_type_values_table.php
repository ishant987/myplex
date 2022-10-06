<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldGroupTypeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_field_group_type_values', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('cf_group_type_value_id');
            $table->bigInteger('cf_group_type_id');
            $table->bigInteger('cf_gt_class_template_id');
            $table->bigInteger('data_id')->comment('Unique Universal identifier for each module class');
            $table->longText('field_value');
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
        Schema::dropIfExists('custom_field_group_type_values');
    }
}
