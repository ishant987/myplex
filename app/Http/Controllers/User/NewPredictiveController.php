<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CorpusEntry;
use App\Models\User;
use App\Models\FundMaster;
use App\Models\FundType;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use DB;
use App\Lib\Core\Useful;
use App\Models\FundComposition;

class NewPredictiveController extends Controller
{

    public function __construct()
    {
        $this->Useful = new Useful;
    }

    public function new_jensen_alpha(Request $request)
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'By Volatility';
        $data['active_menu'] = 'filters_list';

        $data['fundMasterData'] = FundMaster::where('status',1)->get();

        $getdata = $request->all();

        // $time_frame = $getdata['time_frame'];
        $time_frame = 6;


        if(isset($getdata) && count($getdata)>0){



            $currentDate = date('Y-m-d');          

            $date_array = [date('Y-m-d')];

            for($i=1;$i<= 4;$i++){

                if($time_frame == 6){
                    
                    $one_half_date = date('Y-m-d', strtotime('-45 days', strtotime($currentDate)));

                    array_push($date_array,$one_half_date);

                    $currentDate = $one_half_date;
    
                }else if($time_frame == 1){    
                   
                    $three_month_ago =  date('Y-m-d', strtotime('-3 months', strtotime($currentDate)));

                    array_push($date_array,$three_month_ago);

                    $currentDate = $three_month_ago;
    
                } 


            }

      
        }

        return view('web.new_predictive.new_jensen_alpha', $data);
    }

    public function fund_details(Request $request){
        if(isset($request['id'])){
            $currentDate = date('Y-m-d');

            $fund_detail = DB::table('fund_master')
            ->select(DB::raw("DATE_FORMAT(mpx_indices_detail.entry_date, '%d-%m-%Y') as entry_date"),'indices_detail.closing_value', 'indices_detail.name')
            ->leftJoin('indices_detail', 'fund_master.indices_name', '=', 'indices_detail.name')
            ->where('fund_master.fund_id', $request['id'])
            ->where('indices_detail.entry_date', '<=', $currentDate)
            ->where('indices_detail.holiday', 0)
            ->orderBy('indices_detail.entry_date', 'desc')
            ->limit(1)
            ->first();

            return response()->json($fund_detail, 200);
        }
    }

}
