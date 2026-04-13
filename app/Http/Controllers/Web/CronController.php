<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        // dd('reached');
        try {
            $end_year_array = DB::table('corpus_settings')->where('status','1')->first();
            // dd($end_year_array->year);
            $end_year = $end_year_array->year;
            $end_month = $end_year_array->month - 1;
            if ($end_month == 0) {
                $end_month = 12; // If current month is January, set end_month to December of previous year
                $end_year--;
            }
            dd($end_month);
            $end_date = date('Y-m-t', strtotime($end_year . '-' . $end_month . '-01'));
            // dd($end_date);
            $start_year = date('Y-m-t', strtotime('-1 year', strtotime($end_date)));
            $start_date = date('Y-m-d', strtotime('+1 day', strtotime($start_year)));
            // dd('Start Date : '.$start_date." End Date : ".$end_date);
            // Assign values for p_start_date_p1, p_end_date_p1, p_start_date_p2, etc.
            $start_date_p1 = $start_date;
            // dd($start_date_p1);
            $end_date_p1 = date('Y-m-t', strtotime('+2 months', strtotime($start_date_p1)));
            // dd('Start date : '.$start_date_p1.' End date : '.$end_date_p1);
            $start_date_p2 = date('Y-m-t', strtotime('+1 day', strtotime($end_date_p1)));
            // dd($start_date_p2);
            $end_date_p2 = date('Y-m-t', strtotime('+2 months', strtotime($start_date_p2)));
            $start_date_p3 = date('Y-m-t', strtotime('+1 day', strtotime($end_date_p2)));
            $end_date_p3 = date('Y-m-t', strtotime('+2 months', strtotime($start_date_p3)));;
            $start_date_p4 = date('Y-m-t', strtotime('+1 day', strtotime($end_date_p3)));
            $end_date_p4 = $end_date;

            //  dd('Start Date: '.$start_date.' End Date: '.$end_date.' Start date P1: '.$start_date_p1.' End date P1: '.$end_date_p1.' Start date p2: '.$start_date_p2.' End date P2: '.$end_date_p2.' Start date p3: '.$start_date_p3.' End date P3: '.$end_date_p3.' Start date P4: '.$start_date_p4.' End date P4: '.$end_date_p4);

            //getting all the fund type
            $all_fund_types = FundType::get();
            foreach($all_fund_types as $fund_type){
                $ft_id = $fund_type['ft_id'];
                //fund codes for this fund type ID....
                $fundCodes = DB::select("SELECT `fund_code` FROM `mpx_fund_master` WHERE `fund_type_id` = '$ft_id'");
                // dd($fundCodes);
                $fund_code_array = [];
                foreach($fundCodes as $fundcode){
                    // dd($fundcode->fund_code);
                    array_push($fund_code_array, $fundcode->fund_code);
                }
                // dd($fund_code_array);
                DB::table('monthly_ratio_calculations')
                    ->whereIn('fund_code', $fund_code_array)
                    ->delete();
                // Call the stored procedure with the calculated dates
                    DB::statement("
                    CALL sp_monthly_ranking(
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
            dd($e);
            \Log::error($e->getMessage());
        }
    }
}
