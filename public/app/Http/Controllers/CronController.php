<?php

namespace App\Http\Controllers;

use App\Models\FundType;
use DateTime; // Import DateTime class
use Illuminate\Support\Facades\DB; // Import DB facade
use Exception; // Import Exception class

class CronController extends Controller
{
    /**
     * Execute the cron job.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_monthly_ranking()
    {
        dd('reached');
        try {
            // Get the current date
            $currentDate = new DateTime();

            // Calculate the end date as the last day of the previous month
            $end_date = clone $currentDate;
            $end_date->modify('first day of this month')->modify('last day of last month')->format('Y-m-d');

            // Calculate the start date as one year before the end date
            $start_date = clone $end_date;
            $start_date->modify('-1 year')->format('Y-m-d');

            // Assign values for p_start_date_p1, p_end_date_p1, p_start_date_p2, etc.
            $start_date_p1 = $start_date;
            $end_date_p1 = $end_date;
            $start_date_p2 = $start_date;
            $end_date_p2 = $end_date;
            $start_date_p3 = $start_date;
            $end_date_p3 = $end_date;
            $start_date_p4 = $start_date;
            $end_date_p4 = $end_date;

            //getting all the fund type
            $all_fund_types = FundType::get();
            foreach($all_fund_types as $fund_type){
                $ft_id = $fund_type['ft_id'];
                // Call the stored procedure with the calculated dates
                    DB::statement("
                    CALL sp_monthly_ranking_new(
                        '$start_date', 
                        '$end_date',
                        '$start_date_p1', 
                        '$end_date_p1', 
                        '$start_date_p2', 
                        '$end_date_p2', 
                        '$start_date_p3', 
                        '$end_date_p3', 
                        '$start_date_p4', 
                        '$end_date_p4',
                        '$ft_id'
                    )
                ");
            }

            // Log or handle successful execution
        } catch (Exception $e) {
            // Log or handle any exceptions
            // For example:
            // Log::error($e->getMessage());
        }
    }
}
