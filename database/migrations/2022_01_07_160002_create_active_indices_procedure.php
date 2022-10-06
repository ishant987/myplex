<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateActiveIndicesProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "DROP PROCEDURE IF EXISTS active_indices;
            CREATE PROCEDURE active_indices() 
            BEGIN
            SELECT a.idc_id, a.name, a.corelation, b.closing_value FROM mpx_indices_master AS a LEFT OUTER JOIN mpx_indices_detail AS b ON a.corelation = b.name AND b.entry_date = (SELECT option_value FROM mpx_options WHERE option_key='idx') ORDER BY a.corelation ASC;
            END";
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS active_indices');
    }
}
