<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateActiveAUMsProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Stored procedures are not supported by SQLite; skip in local dev.
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        $procedure = "DROP PROCEDURE IF EXISTS active_aums;
            CREATE PROCEDURE active_aums() 
            BEGIN
            SELECT t1.fund_id, t1.fund_name, t1.fund_code, t2.corpus_entry FROM mpx_fund_master AS t1 LEFT OUTER JOIN mpx_corpus_entry AS t2 ON t1.fund_code = t2.fund_code WHERE t1.fund_opened <= CURDATE() AND ( t2.corpus_entry IS NULL OR t2.entry_date = (SELECT option_value FROM mpx_options WHERE option_key='aum') ) ORDER BY t1.fund_name ASC;
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
        DB::unprepared('DROP PROCEDURE IF EXISTS active_aums');
    }
}
