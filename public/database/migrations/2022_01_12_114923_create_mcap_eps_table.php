<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcapEpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcap_eps', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('me_id');
            $table->string('scrip_name', 150);
            $table->date('entry_date');
            $table->float('market_cap')->nullable();
            $table->float('eps')->nullable();
            $table->float('pe')->nullable();
            $table->enum('publish', ['', 'y', 'n'])->comment('y=Yes,n=No')->default('n');
            $table->addColumn('integer', 'created_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->timestamps();
            $table->timestamp('migration_at', 0)->nullable();
        });

        Schema::table('mcap_eps', function (Blueprint $table) {
            $table->unique(['scrip_name', 'entry_date'], 'scrip_name_entry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcap_eps');

        if (Schema::hasTable('mcap_eps')) {
            Schema::table('mcap_eps', function (Blueprint $table) {
                $table->dropUnique('scrip_name_entry_date');
            });
        }
    }
}
