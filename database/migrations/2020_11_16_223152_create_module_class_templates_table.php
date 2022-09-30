<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleClassTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_class_templates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('module_template_id');
            $table->addColumn('integer', 'class_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'template_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
        });

        Schema::table('module_class_templates', function (Blueprint $table) {
            $table->unique(['class_id', 'template_id'], 'cls_tmp_unq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('module_class_templates')) {
            Schema::table('module_class_templates', function (Blueprint $table) {
                $table->dropUnique('cls_tmp_unq');
            });
        }
        Schema::dropIfExists('module_class_templates');
    }
}
