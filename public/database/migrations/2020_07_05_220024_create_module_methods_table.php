<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_methods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('method_id');
            $table->addColumn('integer', 'module_id', ['length' => 10, 'comment' => 'Module ID']);
            $table->string('title', 255);
            $table->string('method_name', 255)->nullable();
            $table->addColumn('tinyInteger', 'default_present', ['length' => 1, 'default' => '0', 'comment' => '']);
            $table->integer('access_role_id')->default(0)->comment('0=access to all');
            $table->string('route_link', 255);
            $table->string('affected_route_link', 255)->nullable();
            $table->addColumn('tinyInteger', 'is_left_nav', ['length' => 1, 'default' => '1', 'comment' => '']);
            $table->addColumn('tinyInteger', 'is_external_link', ['length' => 1, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
        });

        /*Schema::table('module_methods', function(Blueprint $table)        
        {
            $table->unique(['module_id', 'method_name', 'route_link']); 
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*if(Schema::hasTable('module_methods')) 
        {
            Schema::table('module_methods', function(Blueprint $table)        
            {
                $table->dropUnique('ezs_module_methods_module_id_method_name_route_link_unique');
            });
        }*/
        Schema::dropIfExists('module_methods');
    }
}
