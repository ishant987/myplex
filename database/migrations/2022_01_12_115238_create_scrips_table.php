<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrips', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('scrp_id');
            $table->string('scrip_name', 150);
            $table->string('type', 128)->nullable();
            $table->string('industry', 128)->nullable();
            $table->string('actual_scrip', 150);
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });

        Schema::table('scrips', function (Blueprint $table) {
            $table->unique(['scrip_name', 'actual_scrip'], 'name_actual_scrip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scrips');

        if (Schema::hasTable('scrips')) {
            Schema::table('scrips', function (Blueprint $table) {
                $table->dropUnique('name_actual_scrip');
            });
        }
    }
}
