<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfoOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfo_offer', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('no_id');
            $table->enum('type', ['', 'f', 'l', 't'])->comment('f=File,l=Link,t=Text');
            $table->string('fund_name', 255);
            $table->date('fund_opening');
            $table->date('fund_closing');
            $table->addColumn('integer', 'ft_id', ['length' => 10, 'default' => '0', 'comment' => 'Fund / Scheme Type ID']);
            $table->string('minimum_investment', 128)->nullable();
            $table->string('plan', 128)->nullable();
            $table->string('options', 128)->nullable();
            $table->string('entry_load', 128)->nullable();
            $table->string('exit_load', 128)->nullable();
            $table->string('thereafter', 128)->nullable();
            $table->text('objective')->nullable();
            $table->addColumn('integer', 'idc_id', ['length' => 10, 'default' => '0', 'comment' => 'Indices / Benchmark ID']);
            $table->string('fund_manager', 128)->nullable();
            $table->string('aa_col1_value', 60)->nullable();
            $table->string('aa_col1_text', 60)->nullable();
            $table->string('aa_col2_value', 60)->nullable();
            $table->string('aa_col2_text', 60)->nullable();
            $table->string('ces_row1_col1_text', 255)->nullable();
            $table->string('ces_row1_col2_text', 60)->nullable();
            $table->string('ces_row1_col3_text', 60)->nullable();
            $table->string('ces_row2_col1_text', 255)->nullable();
            $table->string('ces_row2_col2_text', 60)->nullable();
            $table->string('ces_row2_col3_text', 60)->nullable();
            $table->text('idea_distiller')->nullable();
            $table->string('fund_house_aaum', 128)->nullable();
            $table->string('fund_manager_experience', 128)->nullable();
            $table->addColumn('tinyInteger', 'uniqness', ['length' => 1, 'default' => '0', 'comment' => '']);
            $table->addColumn('tinyInteger', 'return', ['length' => 1, 'default' => '0', 'comment' => '']);
            $table->addColumn('tinyInteger', 'risk', ['length' => 1, 'default' => '0', 'comment' => '']);
            $table->addColumn('tinyInteger', 'operability', ['length' => 1, 'default' => '0', 'comment' => '']);
            $table->text('oomph_factor')->nullable();
            $table->addColumn('integer', 'media_id', ['length' => 10, 'default' => '0', 'comment' => '']);
            $table->date('post_date');
            $table->string('file', 255)->nullable();
            $table->string('link', 255)->nullable();
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
        Schema::dropIfExists('nfo_offer');
    }
}
