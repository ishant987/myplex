<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IndicesMaster;
use App\Models\FundMaster;
use App\Models\FundDetail;
use App\Models\IndicesDetail;
use Carbon\Carbon;
use DateTime;


class SortinoController extends BaseController
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
   

    public function sortino_calculator(Request $request)
    {
        $input = $request->all();
        $data['search_mar'] = 10;
        if(isset($input['search']) && $input['search'] == 'Search')
        {

            $this->validate($request, [
                'search_fund_name' => 'required',
                'search_indices_name' => 'required',
                'search_mar' => 'required',
                'search_from_date' => 'required',
                'search_to_date' => 'required',
            ],[
                'search_fund_name.required' => 'The fund name field is required',
                'search_indices_name.required' => 'The indices name field is required',
                'search_mar.required' => 'The MAR field is required',
                'search_from_date.required' => 'The from date field is required',
                'search_to_date.required' => 'The to date field is required',
            ]);
            
            $data['search_fund_name'] = $input['search_fund_name'];
            $data['search_mar'] = $search_mar =  $input['search_mar'];
            $data['search_from_date'] = $input['search_from_date'];
            $data['search_to_date'] = $input['search_to_date'];

            $fundsDatas = FundDetail::where('fund_code',$input['search_fund_name'])->whereBetween('entry_date', [date("Y-m-d", strtotime($input['search_from_date'])),date("Y-m-d", strtotime($input['search_to_date']))])->get();

            $fund_details = FundMaster::select('indices_name','risk_free_return')->where('fund_code',$input['search_fund_name'])->first();

            $indices_names = IndicesMaster::where('name',$fund_details->indices_name)->first();
            if($indices_names)
            {
                $indices_name_array = [$indices_names->name,$indices_names->corelation];
            }

            $oneDayBeforeEntryDateFundData = null;

            for ($i = 1; $i <= 10; $i++) {
                $entryDate = date("Y-m-d", strtotime($input['search_from_date'] . " -$i day"));
                
                $oneDayBeforeEntryDateFundData = FundDetail::where('fund_code', $input['search_fund_name'])
                    ->where('holiday', '<>', 1)
                    ->where('entry_date', '=', $entryDate)
                    ->first();

                if ($oneDayBeforeEntryDateFundData) {
                    break;
                }
            }

            $fundsDatasArray = $fundsDatas->toArray();

            $start = Carbon::parse(date("Y-m-d", strtotime($input['search_from_date'])));
            $end = Carbon::parse(date("Y-m-d", strtotime($input['search_to_date'])));

            $data['daily_mar'] = $daily_mar = $search_mar/365;
            $risk_free = $fund_details->risk_free_return;
            $data['daily_risk_free'] = $daily_risk_free = $risk_free/365;

            $allDates = [];

            while ($start->lte($end)) {
                $allDates[] = $start->toDateString();
                $start->addDay(); 
            }

            $fund_entry_date_array = [];
            
            foreach($allDates as $value)
            {
                $filteredFundRowsData = [];

                $filteredFundRowsData = array_filter($fundsDatasArray, function ($row) use ($value) {
                    return $row['entry_date'] === $value && $row['holiday'] != 1;
                });

                $foundFundRowData = reset($filteredFundRowsData);

                if($foundFundRowData == false)
                {
                    
                    $fundsSingleDatas = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date',date("Y-m-d", strtotime($value)))->first();
                    if(!$fundsSingleDatas)
                    {
                        $check_weekdeys  = $this->check_weekdeys($value);
                        if($check_weekdeys)
                        {
                            $maxAttempts = 29; 

                            $reset_date = '';
                            for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) 
                            {
                                if($attempt == 1)
                                {
                                    $oneDayAgoDate = Carbon::parse($value)->subDay('1')->toDateString();

                                    $reset_date = $oneDayAgoDate;
                                }
                                else
                                {
                                    $oneDayAgoDate = Carbon::parse($reset_date)->subDay('1')->toDateString();
                                    $reset_date = $oneDayAgoDate;
                                }
                                

                                $filteredFundRowsData = array_filter($fundsDatasArray, function ($row) use ($oneDayAgoDate) {
                                    return $row['entry_date'] === $oneDayAgoDate && $row['holiday'] != 1;
                                });

                                $foundFundRowData = reset($filteredFundRowsData);

                                if ($foundFundRowData) {
                                    $reset_date = '';
                                    break;
                                }
                            }
                        }
                    }
                }

                if($foundFundRowData != false)
                {
                    array_push($fund_entry_date_array,$value);
                }
            }

            
            if(isset($indices_name_array))
            {   
                $indicesDatas = IndicesDetail::whereIn('name',$indices_name_array)->whereIn('entry_date', $fund_entry_date_array)->get();
            }
            else
            {
                $indicesDatas = IndicesDetail::where('name',$fund_details->indices_name)->whereIn('entry_date',$fund_entry_date_array)->get();
            }

            $indicesDatasArray = $indicesDatas->toArray();

            $searchedResultArray = [];
            $i = 0;
            $negetive_return_squere_arr = [];
            $fund_return_daily_risk_free_arr = [];
            foreach($allDates as $value)
            {
                $filteredFundRows = [];
                $filteredIndicesRows = [];

                $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($value) {
                    return $row['entry_date'] === $value && $row['holiday'] != 1;
                });

                $foundFundRow = reset($filteredFundRows);
                
                if($foundFundRow == false)
                {
                    $fundsSingleDatas = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date',date("Y-m-d", strtotime($value)))->first();

                    if(!$fundsSingleDatas)
                    {
                        $check_weekdeys  = $this->check_weekdeys($value);
                        if($check_weekdeys)
                        {
                            $maxAttemptsFund = 29; 

                            $reset_date_fund = '';
                            for ($attemptFund = 1; $attemptFund <= $maxAttemptsFund; $attemptFund++) 
                            {
                                if($attemptFund == 1)
                                {
                                    $oneDayAgoDate = Carbon::parse($value)->subDay('1')->toDateString();

                                    $reset_date_fund = $oneDayAgoDate;
                                }
                                else
                                {
                                    $oneDayAgoDate = Carbon::parse($reset_date_fund)->subDay('1')->toDateString();
                                    $reset_date_fund = $oneDayAgoDate;
                                }
                                

                                $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($oneDayAgoDate) {
                                    return $row['entry_date'] === $oneDayAgoDate && $row['holiday'] != 1;
                                });

                                $foundFundRow = reset($filteredFundRows);

                                if ($foundFundRow) {
                                    $reset_date_fund = '';
                                    break;
                                }
                            }
                        }
                        else
                        {
                            $reset_date_fund = '';
                            $foundFundRow = false;
                        }
                    }
                }
                
                // $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($value) {
                //     return $row['entry_date'] === $value && $row['holiday'] != 1;
                // });

                $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($value) {
                    return $row['entry_date'] === $value;
                });

                $foundIndicesRow = reset($filteredIndicesRows);

                if($foundIndicesRow == false)
                {
                    
                    if(isset($indices_name_array))
                    {   
                        $indicesSingleDatas = IndicesDetail::where('name',$indices_name_array)->where('entry_date',date("Y-m-d", strtotime($value)))->first();
                    }
                    else
                    {
                        $indicesSingleDatas = IndicesDetail::where('name',$fund_details->indices_name)->where('entry_date',date("Y-m-d", strtotime($value)))->first();
                    }
                    
                    
                    if(!$indicesSingleDatas)
                    {

                        $check_weekdeys  = $this->check_weekdeys($value);
                        if($check_weekdeys)
                        {
                            $maxIndicesAttemptsDays = 29; 

                            $reset_indices_date_day = '';
                            for ($attemptIndecesDays = 1; $attemptIndecesDays <= $maxIndicesAttemptsDays; $attemptIndecesDays++) 
                            {
                                if($attemptIndecesDays == 1)
                                {
                                    $oneDayAgoDateIndices = Carbon::parse($value)->subDay('1')->toDateString();

                                    $reset_indices_date_day = $oneDayAgoDateIndices;
                                }
                                else
                                {
                                    $oneDayAgoDateIndices = Carbon::parse($reset_indices_date_day)->subDay('1')->toDateString();
                                    $reset_indices_date_day = $oneDayAgoDateIndices;
                                }
                                

                                // $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($oneDayAgoDateIndices) {
                                //     return $row['entry_date'] === $oneDayAgoDateIndices && $row['holiday'] != 1;
                                // });

                                $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($oneDayAgoDateIndices) {
                                    return $row['entry_date'] === $oneDayAgoDateIndices;
                                });

                                $foundIndicesRow = reset($filteredIndicesRows);

                                if ($foundIndicesRow) {
                                    $reset_indices_date_day = '';
                                    break;
                                }
                            }
                        }
                        else
                        {
                            $reset_indices_date_day = '';
                            $foundIndicesRow = false;
                        }
                    }
                }

                
                if($foundFundRow != false )
                {
                    if($i == 0)
                    {
                        if(isset($oneDayBeforeEntryDateFundData->closing_nav) && $oneDayBeforeEntryDateFundData->closing_nav != 0)
                        {
                            $fund_return = (($foundFundRow['closing_nav']-$oneDayBeforeEntryDateFundData->closing_nav)/$oneDayBeforeEntryDateFundData->closing_nav)*100;
                        }
                        else
                        {
                            $fund_return = 0;
                        }
                        
                        $fund_closing_store_value = $foundFundRow['closing_nav'];
                    }
                    else
                    {
                        if(isset($fund_closing_store_value))
                        {
                            if($fund_closing_store_value != 0)
                            {
                                $fund_return = (($foundFundRow['closing_nav']-$fund_closing_store_value)/$fund_closing_store_value)*100;
                            }
                            else
                            {
                                $fund_return = 0;
                            }
                            
                            $fund_closing_store_value = $foundFundRow['closing_nav'];
                        } 
                    }

                    $fund_return_mar = $fund_return - $daily_mar ;
                    $negetive_return = ($fund_return_mar < 0) ? $fund_return_mar : 0;
                    $negetive_return_squere = $negetive_return*$negetive_return;
                    $fund_return_daily_risk_free = $fund_return - $daily_risk_free;


                    $res = array(
                        'entry_date' => date("d-m-Y", strtotime($value)),
                        'fund_closing' => $foundFundRow['closing_nav'] ?? 0,
                        'indices_closing' => $foundIndicesRow['closing_value'] ?? 0,
                        'fund_return' => $fund_return ?? 0,
                        'fund_return_mar' => $fund_return_mar,
                        'negetive_return' => $negetive_return,
                        'negetive_return_squere' =>  $negetive_return_squere,
                        'fund_return_daily_risk_free' => $fund_return_daily_risk_free,
                    );
                    $i++;
                    array_push($searchedResultArray , $res);
                    array_push($negetive_return_squere_arr,$negetive_return_squere);
                    array_push($fund_return_daily_risk_free_arr,$fund_return_daily_risk_free);
                    
                }
            }

            if(count($negetive_return_squere_arr) > 0)
            {
                $negetive_return_squere_average = array_sum($negetive_return_squere_arr)/count($negetive_return_squere_arr);
            }
            else
            {
                $negetive_return_squere_average = 0;
            }

            $data['downside_risk'] = $downside_risk =  ($negetive_return_squere_average > 0) ? sqrt($negetive_return_squere_average) : 0;

            if(count($fund_return_daily_risk_free_arr) > 0)
            {
                $fund_return_daily_risk_free_average = array_sum($fund_return_daily_risk_free_arr)/count($fund_return_daily_risk_free_arr);
            }
            else
            {
                $fund_return_daily_risk_free_average = 0;
            }

            $data['fund_return_daily_risk_free_average'] = $fund_return_daily_risk_free_average;

            if($downside_risk != 0)
            {
                $data['sortino'] = $fund_return_daily_risk_free_average/$downside_risk;
            }
            else
            {
                $data['sortino'] = 0;
            }

            $data['searched_result'] = $searchedResultArray;
        }
        
        $data['fundNames'] = FundMaster::select('fund_name','fund_code')->where('status',1)->get();

        return view('web.infosolz-calculator.sortino',$data);
    }

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
