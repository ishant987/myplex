<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateActiveFundsProcedure extends Migration
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

        $procedure = "DROP PROCEDURE IF EXISTS active_funds;
            CREATE PROCEDURE active_funds() 
            BEGIN
            SELECT *, (SELECT ROUND(closing_nav,2) FROM mpx_fund_detail B WHERE A.fund_code = B.fund_code AND B.entry_date = (SELECT option_value FROM mpx_options WHERE option_key='nav') LIMIT 1) AS last_nav FROM (	
                SELECT mpx_fund_master.fund_id AS fund_id, mpx_fund_master.fund_code AS fund_code,
                mpx_fund_master.fund_name AS fund_name, mpx_fund_core.cor AS cor
                FROM (mpx_fund_master) LEFT OUTER JOIN mpx_fund_core ON mpx_fund_master.fund_id = mpx_fund_core.fund_id
                WHERE mpx_fund_master.fund_opened <= CURDATE() ORDER BY fund_name ASC) A;
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
        DB::unprepared('DROP PROCEDURE IF EXISTS active_funds');
    }
}
