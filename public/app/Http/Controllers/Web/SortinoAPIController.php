<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IndicesMaster;
use App\Models\FundMaster;
use App\Models\FundDetail;
use App\Models\IndicesDetail;
use Carbon\Carbon;
use DB;

use DateTime;


class SortinoAPIController extends BaseController
{
    public $className;
    public $class_id;

    public function __construct()
    {
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
        $this->class_id = self::getClassIdByname($this->className);
        $this->page_path =env('PAGE_PATHS','web.pages');
        $this->defDataArr = self::getDefData();
    }
   
    public function sortino_calculator(Request $request){

        $input = $request->all();
            // $data['search_mar'] = 10;
            if(isset($input['search']) && $input['search'] == 'Search')

            {
    
                $this->validate($request, [
                    'search_fund_name' => 'required',
                    // 'search_indices_name' => 'required',
                    // 'search_mar' => 'required',
                    'search_from_date' => 'required',
                    'search_to_date' => 'required',
                ],[
                    'search_fund_name.required' => 'The fund name field is required',
                    // 'search_indices_name.required' => 'The indices name field is required',
                    // 'search_mar.required' => 'The MAR field is required',
                    'search_from_date.required' => 'The from date field is required',
                    'search_to_date.required' => 'The to date field is required',
                ]);
                $search_mar= $input['mar_return'];
                $data['search_fund_name'] = $input['search_fund_name'];
                $data['search_mar'] = $input['mar_return'];
                $data['search_from_date'] = $input['search_from_date'];
                $data['search_to_date'] = $input['search_to_date'];
    
                $fund_opening = FundMaster::where('fund_code',$input['search_fund_name'])->first();
                // dd($fund_opening);
                $fund_opening_date = $fund_opening->fund_opened;
                // dd($fund_opening_date);
                if(date('Y-m-d H:i:s', strtotime($fund_opening_date)) > date('Y-m-d H:i:s', strtotime($data['search_from_date']))){
                    $data['daily_mar'] = 'N/A';
                    // dd($data['fund_return_absolute']);
                    $data['daily_risk_free'] = 'N/A';
                    $data['downside_risk'] = 'N/A';
                    $data['upside_potential'] = 'N/A';
                    $data['sortino'] = 'N/A';
    
                    return $data;
                    exit;
                }
    
                $from_date_fund_data = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date', date("Y-m-d", strtotime($input["search_from_date"])))->first();
                if(empty($from_date_fund_data)){
                    $data['daily_mar'] = 'N/A';
                    // dd($data['fund_return_absolute']);
                    $data['daily_risk_free'] = 'N/A';
                    $data['downside_risk'] = 'N/A';
                    $data['upside_potential'] = 'N/A';
                    $data['sortino'] = 'N/A';
    
                    // dd($data);
                    return $data;
                    exit;
                }

            

            $monthly_mar = floatval($search_mar)/12; 



            $start_date = strtotime($input["search_from_date"]);
            $end_date = strtotime($input['search_to_date']);

            $months_year = [];

            while ($start_date <= $end_date) {
                $month = date('Y-m', $start_date);
                $months_year[] = $month;

                // Move to the next month
                $start_date = strtotime("+1 month", $start_date);
            }

            // dd($months_year);

            $sum_of_total_return_mar = 0;

            $sum_possitive_month_return_mar = 0;

            $sum_negetive_monthly_return = 0;

            $count_month = 0;

            // echo $monthly_mar."<br>";

            foreach($months_year as $value){

                $count_month++;

                $fund_monthly_returns = DB::table('view_fund_nav_monthly_return')->where('fund_code',$input['search_fund_name'])->where('month_year',$value)->first();

                // echo ( floatval($fund_monthly_returns->nav_change_percentage) - floatval($monthly_mar) )."<br>";

                if(isset($fund_monthly_returns)){

                    if(isset($fund_monthly_returns->nav_change_percentage) && ($fund_monthly_returns->nav_change_percentage !='')){

                        $return_total = (floatval($fund_monthly_returns->nav_change_percentage) - floatval($monthly_mar));

                        $sum_of_total_return_mar += $return_total;


                    }

                    if(isset($fund_monthly_returns->nav_change_percentage) && ($fund_monthly_returns->nav_change_percentage !='') &&($fund_monthly_returns->nav_change_percentage > $monthly_mar)){

                        $return = (floatval($fund_monthly_returns->nav_change_percentage) - floatval($monthly_mar));

                        // echo $sum_possitive_month_return_mar."+".$return."<br>";

                        $sum_possitive_month_return_mar += $return;

                        // echo "+ve".$return."<br>";

                    }                  

                    else if(isset($fund_monthly_returns->nav_change_percentage) && ($fund_monthly_returns->nav_change_percentage !='') && ($fund_monthly_returns->nav_change_percentage < $monthly_mar) ){

                        $negetive_r = pow(($fund_monthly_returns->nav_change_percentage - $monthly_mar), 2);    

                        // echo $sum_negetive_monthly_return."+".$negetive_r."<br>";

                        $sum_negetive_monthly_return+= $negetive_r;
                        

                        // echo "-ve".$negetive_r."<br>";


                    }

                }

            }
            // echo $sum_possitive_month_return_mar." ----".$sum_negetive_monthly_return;
            // die;
            // echo $count_month;die;

            $data['avg_of_possitive_monthly_return'] = $avg_of_possitive_monthly_return = $sum_possitive_month_return_mar/$count_month;

            $data['sum_possitive_month_return_mar'] = $sum_possitive_month_return_mar;
        // dd($avg_of_monthly_return);


            $data['sum_sqt_negetive_return'] = $sum_sqt_negetive_return = $sum_negetive_monthly_return;

            // dd($sum_sqt_negetive_return);

            $data['avg_of_total_mar_return'] = $avg_of_total_mar_return = $sum_of_total_return_mar/$count_month;


            $data['downside_risk'] = $downside_risk = ($sum_sqt_negetive_return/$count_month);

            $data['sortino'] = $sortino = ($avg_of_total_mar_return/$downside_risk);

           $data['squre_root_downside_risk'] =  $squre_root_downside_risk = sqrt($downside_risk);

            // $result2 = $avg_of_possitive_monthly_return/$count_month;

            $data['upside_potential'] = $avg_of_possitive_monthly_return/$squre_root_downside_risk;


            // dd($data);


        }



        return json_encode($data);
        

            
        }


        


    

    // public function sortino_calculator(Request $request)
    // {
    //     $input = $request->all();
    //     // $data['search_mar'] = 10;
    //     if(isset($input['search']) && $input['search'] == 'Search')
    //     {

    //         $this->validate($request, [
    //             'search_fund_name' => 'required',
    //             // 'search_indices_name' => 'required',
    //             // 'search_mar' => 'required',
    //             'search_from_date' => 'required',
    //             'search_to_date' => 'required',
    //         ],[
    //             'search_fund_name.required' => 'The fund name field is required',
    //             // 'search_indices_name.required' => 'The indices name field is required',
    //             // 'search_mar.required' => 'The MAR field is required',
    //             'search_from_date.required' => 'The from date field is required',
    //             'search_to_date.required' => 'The to date field is required',
    //         ]);
    //         $search_mar= $input['mar_return'];
    //         $data['search_fund_name'] = $input['search_fund_name'];
    //         $data['search_mar'] = $input['mar_return'];
    //         $data['search_from_date'] = $input['search_from_date'];
    //         $data['search_to_date'] = $input['search_to_date'];

    //         $fund_opening = FundMaster::where('fund_code',$input['search_fund_name'])->first();
    //         // dd($fund_opening);
    //         $fund_opening_date = $fund_opening->fund_opened;
    //         // dd($fund_opening_date);
    //         if(date('Y-m-d H:i:s', strtotime($fund_opening_date)) > date('Y-m-d H:i:s', strtotime($data['search_from_date']))){
    //             $data['daily_mar'] = 'N/A';
    //             // dd($data['fund_return_absolute']);
    //             $data['daily_risk_free'] = 'N/A';
    //             $data['downside_risk'] = 'N/A';
    //             $data['upside_potential'] = 'N/A';
    //             $data['sortino'] = 'N/A';

    //             return $data;
    //             exit;
    //         }

    //         $from_date_fund_data = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date', date("Y-m-d", strtotime($input["search_from_date"])))->first();
    //         if(empty($from_date_fund_data)){
    //             $data['daily_mar'] = 'N/A';
    //             // dd($data['fund_return_absolute']);
    //             $data['daily_risk_free'] = 'N/A';
    //             $data['downside_risk'] = 'N/A';
    //             $data['upside_potential'] = 'N/A';
    //             $data['sortino'] = 'N/A';

    //             // dd($data);
    //             return $data;
    //             exit;
    //         }

    //         $fundsDatas = FundDetail::where('fund_code',$input['search_fund_name'])->whereBetween('entry_date', [date("Y-m-d", strtotime($input['search_from_date'])),date("Y-m-d", strtotime($input['search_to_date']))])->get();

    //         $fund_details = FundMaster::select('indices_name','risk_free_return')->where('fund_code',$input['search_fund_name'])->first();

    //         $indices_names = IndicesMaster::where('name',$fund_details->indices_name)->first();
    //         if($indices_names)
    //         {
    //             $indices_name_array = [$indices_names->name,$indices_names->corelation];
    //         }

    //         $oneDayBeforeEntryDateFundData = null;

    //         for ($i = 1; $i <= 10; $i++) {

    //             $entryDate = date("Y-m-d", strtotime($input['search_from_date'] . " -$i day"));
                
    //             $oneDayBeforeEntryDateFundData = FundDetail::where('fund_code', $input['search_fund_name'])
    //                 ->where('holiday', '<>', 1)
    //                 ->where('entry_date', '=', $entryDate)
    //                 ->first();

    //             if ($oneDayBeforeEntryDateFundData) {
    //                 break;
    //             }
    //         }

    //         $fundsDatasArray = $fundsDatas->toArray();

    //         $start = Carbon::parse(date("Y-m-d", strtotime($input['search_from_date'])));
    //         $end = Carbon::parse(date("Y-m-d", strtotime($input['search_to_date'])));

    //         $data['daily_mar'] = $daily_mar = $search_mar/12;
    //         $risk_free = $fund_details->risk_free_return;
    //         $data['daily_risk_free'] = $daily_risk_free = $risk_free/12;

    //         $allDates = [];

    //         while ($start->lte($end)) {
    //             $allDates[] = $start->toDateString();
    //             $start->addDay(); 
    //         }

    //         $fund_entry_date_array = [];
            
    //         foreach($allDates as $value)
    //         {
    //             $filteredFundRowsData = [];

    //             $filteredFundRowsData = array_filter($fundsDatasArray, function ($row) use ($value) {
    //                 return $row['entry_date'] === $value && $row['holiday'] != 1;
    //             });

    //             $foundFundRowData = reset($filteredFundRowsData);

    //             if($foundFundRowData == false)
    //             {
                    
    //                 $fundsSingleDatas = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date',date("Y-m-d", strtotime($value)))->first();
    //                 if(!$fundsSingleDatas)
    //                 {
    //                     $check_weekdeys  = $this->check_weekdeys($value);
    //                     if($check_weekdeys)
    //                     {
    //                         $maxAttempts = 29; 

    //                         $reset_date = '';
    //                         for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) 
    //                         {
    //                             if($attempt == 1)
    //                             {
    //                                 $oneDayAgoDate = Carbon::parse($value)->subDay('1')->toDateString();

    //                                 $reset_date = $oneDayAgoDate;
    //                             }
    //                             else
    //                             {
    //                                 $oneDayAgoDate = Carbon::parse($reset_date)->subDay('1')->toDateString();
    //                                 $reset_date = $oneDayAgoDate;
    //                             }
                                

    //                             $filteredFundRowsData = array_filter($fundsDatasArray, function ($row) use ($oneDayAgoDate) {
    //                                 return $row['entry_date'] === $oneDayAgoDate && $row['holiday'] != 1;
    //                             });

    //                             $foundFundRowData = reset($filteredFundRowsData);

    //                             if ($foundFundRowData) {
    //                                 $reset_date = '';
    //                                 break;
    //                             }
    //                         }
    //                     }
    //                 }
    //             }

    //             if($foundFundRowData != false)
    //             {
    //                 array_push($fund_entry_date_array,$value);
    //             }
    //         }

            
    //         if(isset($indices_name_array))
    //         {   
    //             $indicesDatas = IndicesDetail::whereIn('correlation_new',$indices_name_array)->whereIn('entry_date', $fund_entry_date_array)->get();
    //         }
    //         else
    //         {
    //             $indicesDatas = IndicesDetail::where('correlation_new',$fund_details->indices_name)->whereIn('entry_date',$fund_entry_date_array)->get();
    //         }

    //         $indicesDatasArray = $indicesDatas->toArray();

    //         $searchedResultArray = [];
    //         $i = 0;
    //         $negetive_return_squere_arr = [];
    //         $fund_return_daily_risk_free_arr = [];
    //         foreach($allDates as $value)
    //         {
    //             $filteredFundRows = [];
    //             $filteredIndicesRows = [];

    //             $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($value) {
    //                 return $row['entry_date'] === $value && $row['holiday'] != 1;
    //             });

    //             $foundFundRow = reset($filteredFundRows);
                
    //             if($foundFundRow == false)
    //             {
    //                 $fundsSingleDatas = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date',date("Y-m-d", strtotime($value)))->first();

    //                 if(!$fundsSingleDatas)
    //                 {
    //                     $check_weekdeys  = $this->check_weekdeys($value);
    //                     if($check_weekdeys)
    //                     {
    //                         $maxAttemptsFund = 29; 

    //                         $reset_date_fund = '';
    //                         for ($attemptFund = 1; $attemptFund <= $maxAttemptsFund; $attemptFund++) 
    //                         {
    //                             if($attemptFund == 1)
    //                             {
    //                                 $oneDayAgoDate = Carbon::parse($value)->subDay('1')->toDateString();

    //                                 $reset_date_fund = $oneDayAgoDate;
    //                             }
    //                             else
    //                             {
    //                                 $oneDayAgoDate = Carbon::parse($reset_date_fund)->subDay('1')->toDateString();
    //                                 $reset_date_fund = $oneDayAgoDate;
    //                             }
                                

    //                             $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($oneDayAgoDate) {
    //                                 return $row['entry_date'] === $oneDayAgoDate && $row['holiday'] != 1;
    //                             });

    //                             $foundFundRow = reset($filteredFundRows);

    //                             if ($foundFundRow) {
    //                                 $reset_date_fund = '';
    //                                 break;
    //                             }
    //                         }
    //                     }
    //                     else
    //                     {
    //                         $reset_date_fund = '';
    //                         $foundFundRow = false;
    //                     }
    //                 }
    //             }
                
    //             // $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($value) {
    //             //     return $row['entry_date'] === $value && $row['holiday'] != 1;
    //             // });

    //             $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($value) {
    //                 return $row['entry_date'] === $value;
    //             });

    //             $foundIndicesRow = reset($filteredIndicesRows);

    //             if($foundIndicesRow == false)
    //             {
                    
    //                 if(isset($indices_name_array))
    //                 {   
    //                     $indicesSingleDatas = IndicesDetail::where('correlation_new',$indices_name_array)->where('entry_date',date("Y-m-d", strtotime($value)))->first();
    //                 }
    //                 else
    //                 {
    //                     $indicesSingleDatas = IndicesDetail::where('correlation_new',$fund_details->indices_name)->where('entry_date',date("Y-m-d", strtotime($value)))->first();
    //                 }
                    
                    
    //                 if(!$indicesSingleDatas)
    //                 {

    //                     $check_weekdeys  = $this->check_weekdeys($value);
    //                     if($check_weekdeys)
    //                     {
    //                         $maxIndicesAttemptsDays = 29; 

    //                         $reset_indices_date_day = '';
    //                         for ($attemptIndecesDays = 1; $attemptIndecesDays <= $maxIndicesAttemptsDays; $attemptIndecesDays++) 
    //                         {
    //                             if($attemptIndecesDays == 1)
    //                             {
    //                                 $oneDayAgoDateIndices = Carbon::parse($value)->subDay('1')->toDateString();

    //                                 $reset_indices_date_day = $oneDayAgoDateIndices;
    //                             }
    //                             else
    //                             {
    //                                 $oneDayAgoDateIndices = Carbon::parse($reset_indices_date_day)->subDay('1')->toDateString();
    //                                 $reset_indices_date_day = $oneDayAgoDateIndices;
    //                             }
                                

    //                             // $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($oneDayAgoDateIndices) {
    //                             //     return $row['entry_date'] === $oneDayAgoDateIndices && $row['holiday'] != 1;
    //                             // });

    //                             $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($oneDayAgoDateIndices) {
    //                                 return $row['entry_date'] === $oneDayAgoDateIndices;
    //                             });

    //                             $foundIndicesRow = reset($filteredIndicesRows);

    //                             if ($foundIndicesRow) {
    //                                 $reset_indices_date_day = '';
    //                                 break;
    //                             }
    //                         }
    //                     }
    //                     else
    //                     {
    //                         $reset_indices_date_day = '';
    //                         $foundIndicesRow = false;
    //                     }
    //                 }
    //             }

                
    //             if($foundFundRow != false )
    //             {
    //                 if($i == 0)
    //                 {
    //                     if(isset($oneDayBeforeEntryDateFundData->closing_nav) && $oneDayBeforeEntryDateFundData->closing_nav != 0)
    //                     {
    //                         $fund_return = (($foundFundRow['closing_nav']-$oneDayBeforeEntryDateFundData->closing_nav)/$oneDayBeforeEntryDateFundData->closing_nav)*100;
    //                     }
    //                     else
    //                     {
    //                         $fund_return = 0;
    //                     }
                        
    //                     $fund_closing_store_value = $foundFundRow['closing_nav'];
    //                 }
    //                 else
    //                 {
    //                     if(isset($fund_closing_store_value))
    //                     {
    //                         if($fund_closing_store_value != 0)
    //                         {
    //                             $fund_return = (($foundFundRow['closing_nav']-$fund_closing_store_value)/$fund_closing_store_value)*100;
    //                         }
    //                         else
    //                         {
    //                             $fund_return = 0;
    //                         }
                            
    //                         $fund_closing_store_value = $foundFundRow['closing_nav'];
    //                     } 
    //                 }

    //                 $fund_return_mar = $fund_return - $daily_mar ;
    //                 $negetive_return = ($fund_return_mar < 0) ? $fund_return_mar : 0;
    //                 $negetive_return_squere = $negetive_return*$negetive_return;
    //                 $fund_return_daily_risk_free = $fund_return - $daily_risk_free;


    //                 $res = array(
    //                     'entry_date' => date("d-m-Y", strtotime($value)),
    //                     'fund_closing' => $foundFundRow['closing_nav'] ?? 0,
    //                     'indices_closing' => $foundIndicesRow['closing_value'] ?? 0,
    //                     'fund_return' => $fund_return ?? 0,
    //                     'fund_return_mar' => $fund_return_mar,
    //                     'negetive_return' => $negetive_return,
    //                     'negetive_return_squere' =>  $negetive_return_squere,
    //                     'fund_return_daily_risk_free' => $fund_return_daily_risk_free,
    //                 );
    //                 $i++;
    //                 array_push($searchedResultArray , $res);
    //                 array_push($negetive_return_squere_arr,$negetive_return_squere);
    //                 array_push($fund_return_daily_risk_free_arr,$fund_return_daily_risk_free);
                    
    //             }
    //         }

    //         if(count($negetive_return_squere_arr) > 0)
    //         {
    //             $negetive_return_squere_average = array_sum($negetive_return_squere_arr)/count($negetive_return_squere_arr);
    //         }
    //         else
    //         {
    //             $negetive_return_squere_average = 0;
    //         }

    //         $data['downside_risk'] = $downside_risk =  ($negetive_return_squere_average > 0) ? sqrt($negetive_return_squere_average) : 0;

    //         if(count($fund_return_daily_risk_free_arr) > 0)
    //         {
    //             $fund_return_daily_risk_free_average = array_sum($fund_return_daily_risk_free_arr)/count($fund_return_daily_risk_free_arr);
    //         }
    //         else
    //         {
    //             $fund_return_daily_risk_free_average = 0;
    //         }

    //         $data['upside_potential'] = $fund_return_daily_risk_free_average;

    //         if($downside_risk != 0)
    //         {
    //             $data['sortino'] = $fund_return_daily_risk_free_average/$downside_risk;
    //         }
    //         else
    //         {
    //             $data['sortino'] = 0;
    //         }

    //         // $data['searched_result'] = $searchedResultArray;
    //     }
        
    //     // $data['fundNames'] = FundMaster::select('fund_name','fund_code')->where('status',1)->get();

    //     // return view('web.infosolz-calculator.sortino',$data);
    //     return json_encode($data);
    // }

    public function check_weekdeys($dateString)
    {
        $date = new DateTime($dateString);

        $dayOfWeek = $date->format('w');
        
        if ($dayOfWeek == 0 || $dayOfWeek == 6) {
            return false;
        } else {
            return true;
        }
    }
}
