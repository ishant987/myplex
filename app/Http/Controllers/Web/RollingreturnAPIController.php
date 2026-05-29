<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundDetail;
use App\Models\FundMaster;
use App\Models\IndicesDetail;
use Carbon\Carbon;


class RollingreturnAPIController extends BaseController
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

    public function rolling_return_calculator(Request $request)
    {
        $input = $request->all();
        if(isset($input['search']) && $input['search'] == 'Search')
        {

            $this->validate($request, [
                'search_fund_name' => 'required',
                'search_from_date' => 'required',
                'search_to_date' => 'required',
            ],[
                'search_fund_name.required' => 'The fund name field is required',
                'search_from_date.required' => 'The from date field is required',
                'search_to_date.required' => 'The to date field is required',
            ]);
            
            $data['search_fund_name'] = $input['search_fund_name'];
            $data['search_from_date'] = $input['search_from_date'];
            $data['search_to_date'] = $input['search_to_date'];


            $fund_opening = FundMaster::where('fund_code',$input['search_fund_name'])->first();
            // dd($fund_opening);
            $fund_opening_date = $fund_opening->fund_opened;
            // dd($fund_opening_date);
            if(date('Y-m-d H:i:s', strtotime($fund_opening_date)) > date('Y-m-d H:i:s', strtotime($data['search_from_date']))){
                $data['searched_result'][0] = 'N/A';
                $data['one_month_interval_percentage_change'] = 'N/A';

                return $data;
                exit;
            }

            $from_date_fund_data = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date', date("Y-m-d", strtotime($input["search_from_date"])))->first();
            if(empty($from_date_fund_data)){
                $data['searched_result'][0] = 'N/A';
                $data['one_month_interval_percentage_change'] = 'N/A';
                // dd($data);
                return $data;
                exit;
            }
            

            $fundsDatas = FundDetail::where('fund_code',$input['search_fund_name'])->whereBetween('entry_date', [date("Y-m-d", strtotime($input['search_from_date'])),date("Y-m-d", strtotime($input['search_to_date']))])->get();

            $fundsDatasArray = $fundsDatas->toArray();

            $start = Carbon::parse(date("Y-m-d", strtotime($input['search_from_date'])));
            $end = Carbon::parse(date("Y-m-d", strtotime($input['search_to_date'])));

            $no_of_months = 1;

            $allDates = [];
            // dd($start."-".$end);
            while ($start->lte($end)) {
                $allDates[] = $start->toDateString();
                $start->addDay(); 
            }
            $data['allDates'] =  $allDates = array_reverse($allDates);
            // dd($allDates);
            $data['oneYearAgoDate'] = $oneYearAgoDate = Carbon::parse($allDates[0])->subDay('365')->toDateString();
            $data['oneMonthAgoDate'] = $oneMonthAgoDate = Carbon::parse($allDates[0])->subMonth('1')->toDateString();

            $data['latestDate'] =   $latestDate = Carbon::createFromFormat('Y-m-d', $allDates[0]);

            $data['threeMonthsBefore'] = $threeMonthsBefore = $latestDate->subDays(89);

            $three_month_before_date = $threeMonthsBefore->format('Y-m-d');

            $data['oneMonthBefore'] =  $oneMonthBefore = Carbon::parse($allDates[0])->subMonth('1')->toDateString();
            // dd($oneMonthBefore);
            $one_month_before_date = $oneMonthBefore;
            // dd($one_month_before_date);

            $data['latestDateForSixMonth'] =   $latestDateForSixMonth = Carbon::createFromFormat('Y-m-d', $allDates[0]);
            
            $data['sixMonthsBefore'] = $sixMonthsBefore = $latestDateForSixMonth->subDays(179);
            $six_month_before_date = $sixMonthsBefore->format('Y-m-d');

            $data['latestDateForTwelveMonth'] =  $latestDateForTwelveMonth = Carbon::createFromFormat('Y-m-d', $allDates[0]);

            $data['twelveMonthsBefore'] =$twelveMonthsBefore = $latestDateForTwelveMonth->subDays(364);
            $twelve_month_before_date = $twelveMonthsBefore->format('Y-m-d');

            $searchedResultArray = [];
            $three_month_intervel_percentage_array = [];
            $one_month_intervel_percentage_array = [];
            $six_month_intervel_percentage_array = [];
            $twelve_month_intervel_percentage_array = [];
            $i = 0;

            $found_fund_row_array = [];
            $found_one_month_bcak_row_array = [];
            


            foreach($allDates as $value)
            {   
                $filteredFundRows = [];
                $filteredFundOneMonthBackRows = [];
                $oneMonthAgoDate = '';

                $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($value) {
                    return $row['entry_date'] === $value;
                });

                $foundFundRow = reset($filteredFundRows);

                if($value > $oneMonthAgoDate)
                {
                    if($foundFundRow == false)
                    {
                        $maxAttempts = 29; 

                        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
                            $oneDayAgoDate = Carbon::parse($value)->subDay('1')->toDateString();
                            $value = $oneDayAgoDate;

                            $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($value) {
                                return $row['entry_date'] === $value;
                            });

                            $foundFundRow = reset($filteredFundRows);

                            if ($foundFundRow) {
                                break;
                            }
                        }
                    }
                }
                
                if( $foundFundRow != false )
                {
                    
                    // $oneMonthAgoDate = Carbon::parse($value)->subMonth('1')->toDateString();
                    // // dd($oneMonthAgoDate);
                    // $filteredFundOneMonthBackRows = array_filter($fundsDatasArray, function ($row1) use ($oneMonthAgoDate) {
                    //     return $row1['entry_date'] === $oneMonthAgoDate;
                    // });
                    // $FundOneMonthBackRows = reset($filteredFundOneMonthBackRows);

                    $oneMonthAgoDate = date('Y-m-d', strtotime('-31 days', strtotime($value)));

                    // array_push($my_one_month_ago,$oneMonthAgoDate);

                    
                    // $oneMonthAgoDate = self::getPreviousMonthDate($value);
                   
                    $FundOneMonthBackRows = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date', $oneMonthAgoDate)->first();
                    
                    // if($value > $oneYearAgoDate)
                    // {
                    //     if($FundOneMonthBackRows == false)
                    //     {
                    //         $maxk = 29;
                    //         for ($k = 1; $k <= $maxk; $k++) {
                    //             $subDay = 30-$k;
                    //             $oneMonthAgoDate = Carbon::parse($value)->subDay($subDay)->toDateString();
                    //             $filteredFundOneMonthBackRows = array_filter($fundsDatasArray, function ($row1) use ($oneMonthAgoDate) {
                    //                 return $row1['entry_date'] === $oneMonthAgoDate;
                    //             });
                    //             $FundOneMonthBackRows = reset($filteredFundOneMonthBackRows);
                    //             if($FundOneMonthBackRows){
                    //                 break;
                    //             }

                    //         }
                    //     }
                    // }
                    // else
                    // {
                    //     $FundOneMonthBackRows = false;
                    // }
                   
                    
                    if(isset($FundOneMonthBackRows))
                    {
                        // dd($foundFundRow['closing_nav']." -------------- ".$FundOneMonthBackRows['closing_nav']);
                        $one_month_interval_percentage_change = (($foundFundRow['closing_nav']-$FundOneMonthBackRows->closing_nav)/$FundOneMonthBackRows->closing_nav)*100;

                        array_push($found_fund_row_array,$foundFundRow);
                        array_push($found_one_month_bcak_row_array,$FundOneMonthBackRows);


                    }
                    else
                    {
                        $one_month_interval_percentage_change = 'N/A';
                    }

                    $res = array(
                        'entry_date' => date("d-m-Y", strtotime($value)),
                        'fund_closing' => $foundFundRow['closing_nav'] ?? 0,
                        'one_month_interval_percentage_change' => $one_month_interval_percentage_change
                    );
                    // dd($res);
                    // dd($one_month_interval_percentage_change);
                    if($value >= $one_month_before_date)
                    {
                        if($one_month_interval_percentage_change != 'N/A')
                        {
                            array_push($one_month_intervel_percentage_array,$one_month_interval_percentage_change);
                        }
                    }

                    // if($value >= $three_month_before_date)
                    // {
                    //     if($one_month_interval_percentage_change != 'N/A')
                    //     {
                    //         array_push($three_month_intervel_percentage_array,$one_month_interval_percentage_change);
                    //     }
                    // }
                    // if($value >= $six_month_before_date)
                    // {
                    //     if($one_month_interval_percentage_change != 'N/A')
                    //     {
                    //         array_push($six_month_intervel_percentage_array,$one_month_interval_percentage_change);
                    //     }
                    // }
                    // if($value >= $twelve_month_before_date)
                    // {
                    //     if($one_month_interval_percentage_change != 'N/A')
                    //     {
                    //         array_push($twelve_month_intervel_percentage_array,$one_month_interval_percentage_change);
                    //     }
                    // }

                    $i++;
                    array_push($searchedResultArray , $res);
                }
            }

            // dd($one_month_intervel_percentage_array);
            $data['searched_result'] = $searchedResultArray;
            $sum_of_one_month_data = array_sum($one_month_intervel_percentage_array);
            // dd($sum_of_one_month_data);
            $count_one_month_array = count($one_month_intervel_percentage_array);
            // dd($count_one_month_array);
            $data['average_of_one_month_rolling_return'] = $count_one_month_array != 0 ? ($sum_of_one_month_data / $count_one_month_array) : 'N/A';
            // $sum_of_three_month_data = array_sum($three_month_intervel_percentage_array);
            // // dd($three_month_intervel_percentage_array);
            // $count_three_month_array = count($three_month_intervel_percentage_array);
            // // dd($count_three_month_array);
            // if($count_three_month_array == 90)
            // {   
            //     $data['avg_of_three_month_rolling_return'] = $sum_of_three_month_data/$count_three_month_array;
            // }

            // $sum_of_six_month_data = array_sum($six_month_intervel_percentage_array);
            // $count_six_month_array = count($six_month_intervel_percentage_array);
            // if($count_six_month_array == 180)
            // {   
            //     $data['avg_of_six_month_rolling_return'] = $sum_of_six_month_data/$count_six_month_array;
            // }
           
            // $sum_of_twelve_month_data = array_sum($twelve_month_intervel_percentage_array);
            // $count_twelve_month_array = count($twelve_month_intervel_percentage_array);

            // if($count_twelve_month_array >= 365)
            // {   
            //     $data['avg_of_twelve_month_rolling_return'] = $sum_of_twelve_month_data/$count_twelve_month_array;
            // }
            

            // dd($data['avg_of_three_month_rolling_return']);
        }
        // $data['fundNames'] = FundMaster::select('fund_name','fund_code')->where('status',1)->get();
        // dd($data['searched_result'][0]);
        // dd($data['average_of_one_month_rolling_return']);

        $data['fund_found_row'] = $found_fund_row_array;
        $data['fund_found_one_month_back_row'] = $found_one_month_bcak_row_array;

        if(!empty($data['searched_result'])){
            $data['searched_result'][0]['one_month_interval_percentage_change'] = $data['average_of_one_month_rolling_return'];
            // return json_encode($data);
            return json_encode($data['searched_result'][0]);

        }else{
            return [];
        }
        // return view('web.infosolz-calculator.rolling_return',$data);
    }

    // public function rolling_return_calculator_mar(Request $request)
    // {
    //     $input = $request->all();
    //     if(isset($input['search']) && $input['search'] == 'Search')
    //     {

    //         $this->validate($request, [
    //             'search_fund_name' => 'required',
    //             'search_from_date' => 'required',
    //             'search_to_date' => 'required',
    //         ],[
    //             'search_fund_name.required' => 'The fund name field is required',
    //             'search_from_date.required' => 'The from date field is required',
    //             'search_to_date.required' => 'The to date field is required',
    //         ]);
            
    //         $data['search_fund_name'] = $input['search_fund_name'];
    //         $data['search_from_date'] = $input['search_from_date'];
    //         $data['search_to_date'] = $input['search_to_date'];
    //         $data['search_index'] = $search_index = $input['search_index'];

    //         $indices_names = IndicesMaster::where('idc_id',$search_index)->first();

    //         $fund_opening = FundMaster::where('fund_code',$input['search_fund_name'])->where('indices_name',$indices_names->name)->first();
    //         // dd($fund_opening);
    //         $fund_opening_date = $fund_opening->fund_opened;
    //         // dd($fund_opening_date);
    //         if(date('Y-m-d H:i:s', strtotime($fund_opening_date)) > date('Y-m-d H:i:s', strtotime($data['search_from_date']))){
    //             $data['searched_result'][0] = 'N/A';
    //             $data['one_month_interval_percentage_change'] = 'N/A';

    //             return $data;
    //             exit;
    //         }

    //         $from_date_fund_data = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date', date("Y-m-d", strtotime($input["search_from_date"])))->first();
    //         if(empty($from_date_fund_data)){
    //             $data['searched_result'][0] = 'N/A';
    //             $data['one_month_interval_percentage_change'] = 'N/A';
    //             // dd($data);
    //             return $data;
    //             exit;
    //         }
            

    //         $fundsDatas = FundDetail::where('fund_code',$input['search_fund_name'])->whereBetween('entry_date', [date("Y-m-d", strtotime($input['search_from_date'])),date("Y-m-d", strtotime($input['search_to_date']))])->get();

    //         $fundsDatasArray = $fundsDatas->toArray();

    //         $start = Carbon::parse(date("Y-m-d", strtotime($input['search_from_date'])));
    //         $end = Carbon::parse(date("Y-m-d", strtotime($input['search_to_date'])));

    //         $no_of_months = 1;

    //         $allDates = [];
    //         // dd($start."-".$end);
    //         while ($start->lte($end)) {
    //             $allDates[] = $start->toDateString();
    //             $start->addDay(); 
    //         }
    //         $allDates = array_reverse($allDates);
    //         // dd($allDates);
    //         $oneYearAgoDate = Carbon::parse($allDates[0])->subDay('365')->toDateString();
    //         $oneMonthAgoDate = Carbon::parse($allDates[0])->subMonth('1')->toDateString();

    //         $latestDate = Carbon::createFromFormat('Y-m-d', $allDates[0]);
    //         $threeMonthsBefore = $latestDate->subDays(89);
    //         $three_month_before_date = $threeMonthsBefore->format('Y-m-d');

    //         $oneMonthBefore = Carbon::parse($allDates[0])->subMonth('1')->toDateString();
    //         // dd($oneMonthBefore);
    //         $one_month_before_date = $oneMonthBefore;
    //         // dd($one_month_before_date);

    //         $latestDateForSixMonth = Carbon::createFromFormat('Y-m-d', $allDates[0]);
    //         $sixMonthsBefore = $latestDateForSixMonth->subDays(179);
    //         $six_month_before_date = $sixMonthsBefore->format('Y-m-d');

    //         $latestDateForTwelveMonth = Carbon::createFromFormat('Y-m-d', $allDates[0]);
    //         $twelveMonthsBefore = $latestDateForTwelveMonth->subDays(364);
    //         $twelve_month_before_date = $twelveMonthsBefore->format('Y-m-d');

    //         $searchedResultArray = [];
    //         $three_month_intervel_percentage_array = [];
    //         $one_month_intervel_percentage_array = [];
    //         $six_month_intervel_percentage_array = [];
    //         $twelve_month_intervel_percentage_array = [];
    //         $i = 0;

    //         foreach($allDates as $value)
    //         {   
    //             $filteredFundRows = [];
    //             $filteredFundOneMonthBackRows = [];
    //             $oneMonthAgoDate = '';

    //             $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($value) {
    //                 return $row['entry_date'] === $value;
    //             });

    //             $foundFundRow = reset($filteredFundRows);

    //             if($value > $oneMonthAgoDate)
    //             {
    //                 if($foundFundRow == false)
    //                 {
    //                     $maxAttempts = 29; 

    //                     for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
    //                         $oneDayAgoDate = Carbon::parse($value)->subDay('1')->toDateString();
    //                         $value = $oneDayAgoDate;

    //                         $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($value) {
    //                             return $row['entry_date'] === $value;
    //                         });

    //                         $foundFundRow = reset($filteredFundRows);

    //                         if ($foundFundRow) {
    //                             break;
    //                         }
    //                     }
    //                 }
    //             }
                
    //             if( $foundFundRow != false )
    //             {
                    
    //                 $oneMonthAgoDate = Carbon::parse($value)->subMonth('1')->toDateString();
    //                 // dd($oneMonthAgoDate);
    //                 $filteredFundOneMonthBackRows = array_filter($fundsDatasArray, function ($row1) use ($oneMonthAgoDate) {
    //                     return $row1['entry_date'] === $oneMonthAgoDate;
    //                 });
    //                 $FundOneMonthBackRows = reset($filteredFundOneMonthBackRows);
                    
    //                 if($value > $oneYearAgoDate)
    //                 {
    //                     if($FundOneMonthBackRows == false)
    //                     {
    //                         $maxk = 29;
    //                         for ($k = 1; $k <= $maxk; $k++) {
    //                             $subDay = 30-$k;
    //                             $oneMonthAgoDate = Carbon::parse($value)->subDay($subDay)->toDateString();
    //                             $filteredFundOneMonthBackRows = array_filter($fundsDatasArray, function ($row1) use ($oneMonthAgoDate) {
    //                                 return $row1['entry_date'] === $oneMonthAgoDate;
    //                             });
    //                             $FundOneMonthBackRows = reset($filteredFundOneMonthBackRows);
    //                             if($FundOneMonthBackRows){
    //                                 break;
    //                             }

    //                         }
    //                     }
    //                 }
    //                 else
    //                 {
    //                     $FundOneMonthBackRows = false;
    //                 }
                   
                    
    //                 if($FundOneMonthBackRows != false)
    //                 {
    //                     // dd($foundFundRow['closing_nav']." -------------- ".$FundOneMonthBackRows['closing_nav']);
    //                     $one_month_interval_percentage_change = (($foundFundRow['closing_nav']-$FundOneMonthBackRows['closing_nav'])/$FundOneMonthBackRows['closing_nav'])*100;
    //                 }
    //                 else
    //                 {
    //                     $one_month_interval_percentage_change = 'N/A';
    //                 }

    //                 $res = array(
    //                     'entry_date' => date("d-m-Y", strtotime($value)),
    //                     'fund_closing' => $foundFundRow['closing_nav'] ?? 0,
    //                     'one_month_interval_percentage_change' => $one_month_interval_percentage_change
    //                 );
    //                 // dd($res);
    //                 // dd($one_month_interval_percentage_change);
    //                 if($value >= $one_month_before_date)
    //                 {
    //                     if($one_month_interval_percentage_change != 'N/A')
    //                     {
    //                         array_push($one_month_intervel_percentage_array,$one_month_interval_percentage_change);
    //                     }
    //                 }

    //                 // if($value >= $three_month_before_date)
    //                 // {
    //                 //     if($one_month_interval_percentage_change != 'N/A')
    //                 //     {
    //                 //         array_push($three_month_intervel_percentage_array,$one_month_interval_percentage_change);
    //                 //     }
    //                 // }
    //                 // if($value >= $six_month_before_date)
    //                 // {
    //                 //     if($one_month_interval_percentage_change != 'N/A')
    //                 //     {
    //                 //         array_push($six_month_intervel_percentage_array,$one_month_interval_percentage_change);
    //                 //     }
    //                 // }
    //                 // if($value >= $twelve_month_before_date)
    //                 // {
    //                 //     if($one_month_interval_percentage_change != 'N/A')
    //                 //     {
    //                 //         array_push($twelve_month_intervel_percentage_array,$one_month_interval_percentage_change);
    //                 //     }
    //                 // }
    //                 $i++;
    //                 array_push($searchedResultArray , $res);
    //             }
    //         }

    //         // dd($one_month_intervel_percentage_array);
    //         $data['searched_result'] = $searchedResultArray;
    //         $sum_of_one_month_data = array_sum($one_month_intervel_percentage_array);
    //         // dd($sum_of_one_month_data);
    //         $count_one_month_array = count($one_month_intervel_percentage_array);
    //         // dd($count_one_month_array);
    //         $data['average_of_one_month_rolling_return'] = $count_one_month_array != 0 ? ($sum_of_one_month_data / $count_one_month_array) : 'N/A';
    //         // $sum_of_three_month_data = array_sum($three_month_intervel_percentage_array);
    //         // // dd($three_month_intervel_percentage_array);
    //         // $count_three_month_array = count($three_month_intervel_percentage_array);
    //         // // dd($count_three_month_array);
    //         // if($count_three_month_array == 90)
    //         // {   
    //         //     $data['avg_of_three_month_rolling_return'] = $sum_of_three_month_data/$count_three_month_array;
    //         // }

    //         // $sum_of_six_month_data = array_sum($six_month_intervel_percentage_array);
    //         // $count_six_month_array = count($six_month_intervel_percentage_array);
    //         // if($count_six_month_array == 180)
    //         // {   
    //         //     $data['avg_of_six_month_rolling_return'] = $sum_of_six_month_data/$count_six_month_array;
    //         // }
           
    //         // $sum_of_twelve_month_data = array_sum($twelve_month_intervel_percentage_array);
    //         // $count_twelve_month_array = count($twelve_month_intervel_percentage_array);

    //         // if($count_twelve_month_array >= 365)
    //         // {   
    //         //     $data['avg_of_twelve_month_rolling_return'] = $sum_of_twelve_month_data/$count_twelve_month_array;
    //         // }
            

    //         // dd($data['avg_of_three_month_rolling_return']);
    //     }
    //     // $data['fundNames'] = FundMaster::select('fund_name','fund_code')->where('status',1)->get();
    //     // dd($data['searched_result'][0]);
    //     // dd($data['average_of_one_month_rolling_return']);
    //     if(!empty($data['searched_result'])){
    //         $data['searched_result'][0]['one_month_interval_percentage_change'] = $data['average_of_one_month_rolling_return'];
    //         return json_encode($data['searched_result'][0]);
    //     }else{
    //         return [];
    //     }
    //     // return view('web.infosolz-calculator.rolling_return',$data);
    // }

}