<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocalDemoColumnsToFundManTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fund_man', function (Blueprint $table) {
            if (! Schema::hasColumn('fund_man', 'media_id')) {
                $table->integer('media_id')->default(0)->after('slug');
            }

            if (! Schema::hasColumn('fund_man', 'disclaimer')) {
                $table->text('disclaimer')->nullable()->after('description');
            }

            if (! Schema::hasColumn('fund_man', 'disclaimer_note')) {
                $table->text('disclaimer_note')->nullable()->after('disclaimer');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fund_man', function (Blueprint $table) {
            if (Schema::hasColumn('fund_man', 'disclaimer_note')) {
                $table->dropColumn('disclaimer_note');
            }

            if (Schema::hasColumn('fund_man', 'disclaimer')) {
                $table->dropColumn('disclaimer');
            }

            if (Schema::hasColumn('fund_man', 'media_id')) {
                $table->dropColumn('media_id');
            }
        });
    }
}
