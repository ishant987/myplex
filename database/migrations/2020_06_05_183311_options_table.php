<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('options')) {
            Schema::create('options', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('option_id');
                $table->enum('field_type', ['', 'image', 'text', 'textarea', 'editor', 'radio', 'dropdown']);
                $table->string('field_label', 64)->nullable();
                $table->string('option_key', 64);
                $table->text('option_value')->nullable();
                $table->text('options_label')->nullable()->comment('Must be in JSON format.');
                $table->text('options_value')->nullable()->comment('Must be in JSON format.');
                $table->enum('type', ['', 'subscription', 'general', 'mail_setting', 'options', 'custom', 'social']);
                $table->string('field_info', 255)->nullable();
                $table->enum('is_required', ['', 'n', 'y'])->default('n')->comment('n=no,y=yes');
                $table->addColumn('integer', 'c_order', ['length' => 10, 'default' => '0', 'comment' => '']);
                $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1', 'comment' => '']);
                $table->addColumn('integer', 'updated_id', ['length' => 10, 'default' => '0', 'comment' => '']);
                $table->timestamp('updated_at', 0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}
