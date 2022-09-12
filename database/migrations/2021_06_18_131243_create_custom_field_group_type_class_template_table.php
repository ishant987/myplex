<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldGroupTypeClassTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_field_group_type_class_template', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('cf_gt_class_template_id');
            $table->bigInteger('cf_group_type_id');
            $table->bigInteger('class_id');
            $table->addColumn('integer', 'template_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('tinyInteger', 'deleted_flag', ['length' => 1, 'default' => '0', 'comment' => 'Internal use']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
        });

        Schema::table('custom_field_group_type_class_template', function (Blueprint $table) {
            $table->unique(['cf_group_type_id', 'class_id', 'template_id'], 'cf_gtype_class_template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('custom_field_group_type_class_template')) {
            Schema::table('custom_field_group_type_class_template', function (Blueprint $table) {
                $table->dropUnique('cf_gtype_class_template');
            });
        }
        Schema::dropIfExists('custom_field_group_type_class_template');
    }
}
