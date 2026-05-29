<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundMaster;
use App\Models\FundReturnReport;
use Carbon\Carbon;
use App\Http\Controllers\User\QuartileDecileController;

class ReportInsertController extends Controller
{
    public function index()
    {
        $all_funds = FundMaster::where('status', 1)->get();
        $end_date = '2024-01-30';
        
        // Convert end_date to a Carbon instance
        $endDate = Carbon::createFromFormat('Y-m-d', $end_date);
        $i = 0;
        foreach ($all_funds as $fund) {
            $fund_code = $fund['fund_code'];
            
            // Calculate start dates
            // dd($endDate->copy()->subMonths(6)->format('Y-m-d'));
            $start_dates = [
                'six_month' => $endDate->copy()->subMonths(6)->format('Y-m-d'),
                'one_year' => $endDate->copy()->subYear()->format('Y-m-d'),
                'two_year' => $endDate->copy()->subYears(2)->format('Y-m-d'),
                'three_year' => $endDate->copy()->subYears(3)->format('Y-m-d'),
                'five_year' => $endDate->copy()->subYears(5)->format('Y-m-d'),
            ];
            // dd($start_dates);

            foreach ($start_dates as $period => $start_date) {
                $return = QuartileDecileController::jensenalphaApi($fund_code, $start_date, $end_date);
                // You can process the $fund_return as needed here
                $fund_return[$period] = $return['fund_return_absolute'];
            }
            $fund_return['fund_code'] = $fund_code;
            $fund_return['entry_date'] = $end_date;
            // echo "<pre>";print_r($fund_return);
            FundReturnReport::create($fund_return);
            $i++;
            // if($i==2){
            //     die;
            // }
        }
    }
}
