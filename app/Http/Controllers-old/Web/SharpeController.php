<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundDetail;
use App\Models\FundMaster;
use App\Models\IndicesMaster;
use App\Models\IndicesDetail;
use Carbon\Carbon;
use DateTime;


class SharpeController extends BaseController
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

    public function sharpe_calculator(Request $request)
    {
        $input = $request->all();
        if(isset($input['search']) && $input['search'] == 'Search')
        {

            $this->validate($request, [
                'search_fund_name' => 'required',
                'search_indices_name' => 'required',
                'search_from_date' => 'required',
                'search_to_date' => 'required',
            ],[
                'search_fund_name.required' => 'The fund name field is required',
                'search_indices_name.required' => 'The indices name field is required',
                'search_from_date.required' => 'The from date field is required',
                'search_to_date.required' => 'The to date field is required',
            ]);
            
            $data['search_fund_name'] = $input['search_fund_name'];
            $data['search_from_date'] = $input['search_from_date'];
            $data['search_to_date'] = $input['search_to_date'];

            $fundsDatas = FundDetail::where('fund_code',$input['search_fund_name'])->whereBetween('entry_date', [date("Y-m-d", strtotime($input['search_from_date'])),date("Y-m-d", strtotime($input['search_to_date']))])->get();

            $firstFundData = $fundsDatas->first();

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
            if($oneDayBeforeEntryDateFundData != null)
            {
                if(isset($indices_name_array))
                {
                    $oneDayBeforeEntryDateIndicesDatas = IndicesDetail::whereIn('name',$indices_name_array)->where('entry_date',$oneDayBeforeEntryDateFundData->entry_date)->first();
                }
                else
                {
                    $oneDayBeforeEntryDateIndicesDatas = IndicesDetail::where('name',$fund_details->indices_name)->where('entry_date',$oneDayBeforeEntryDateFundData->entry_date)->first();
                }
            }
            elseif($firstFundData)
            {
                $oneDayBeforeEntryDateIndicesDatas = IndicesDetail::whereIn('name',$indices_name_array)->where('entry_date',date("Y-m-d", strtotime($firstFundData->entry_date . " -1 day")))->first();
            }

            $fundsDatasArray = $fundsDatas->toArray();

            $start = Carbon::parse(date("Y-m-d", strtotime($input['search_from_date'])));
            $end = Carbon::parse(date("Y-m-d", strtotime($input['search_to_date'])));

            $allDates = [];

            $risk_free = $fund_details->risk_free_return;
            $data['daily_risk_free'] = $daily_risk_free = $risk_free/365;

            while ($start->lte($end)) {
                $allDates[] = $start->toDateString();
                $start->addDay(); 
            }

            $total_fund = 0;
            $total_nav = 0;
            $j = 0;
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
                    if($j == 0)
                    {
                        if(isset($oneDayBeforeEntryDateFundData->closing_nav) && $oneDayBeforeEntryDateFundData->closing_nav != 0)
                        {
                            $total_nav += (($foundFundRowData['closing_nav']-$oneDayBeforeEntryDateFundData->closing_nav)/$oneDayBeforeEntryDateFundData->closing_nav)*100;
                        }
                        else
                        {
                            $total_nav += 0;
                        }
                        $old_store_fund_value = $foundFundRowData['closing_nav'];
                        array_push($fund_entry_date_array,$value);
                    }
                    else
                    {
                        if(isset($old_store_fund_value))
                        {
                            $total_nav += (($foundFundRowData['closing_nav']-$old_store_fund_value)/$old_store_fund_value)*100;
                            $old_store_fund_value = $foundFundRowData['closing_nav'];
                            array_push($fund_entry_date_array,$value);
                        }
                    }
                    $total_fund += 1;
                    $j++;
                }
            }


            if($total_fund != 0)
            {
                $average_of_nav = ($total_nav/$total_fund);
            }
            else
            {
                $average_of_nav = 0;
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
            $sum_of_g = 0;
            $sum_of_fund_return_daily_risk_free = 0;

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

                        if(isset($oneDayBeforeEntryDateIndicesDatas->closing_value) && $oneDayBeforeEntryDateIndicesDatas->closing_value != 0)
                        {
                            if(isset($foundIndicesRow['closing_value']))
                            {
                                $index_return = (($foundIndicesRow['closing_value']-$oneDayBeforeEntryDateIndicesDatas->closing_value)/$oneDayBeforeEntryDateIndicesDatas->closing_value)*100;
                            }
                            else
                            {
                                $index_return = 0;
                            }
                            
                        }
                        else
                        {
                            $index_return = 0;
                        }
                        $index_closing_store_value = isset($foundIndicesRow['closing_value']) ? $foundIndicesRow['closing_value'] : 0;
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

                        if(isset($index_closing_store_value))
                        {
                            if($index_closing_store_value != 0)
                            {
                                if(isset($foundIndicesRow['closing_value']))
                                {
                                    $index_return = (($foundIndicesRow['closing_value']-$index_closing_store_value)/$index_closing_store_value)*100;
                                }
                                else
                                {
                                    $index_return = 0;
                                }
                                
                            }
                            else
                            {
                                $index_return = 0;
                            }
                            
                            $index_closing_store_value = isset($foundIndicesRow['closing_value']) ? $foundIndicesRow['closing_value'] : 0;
                        }
                    }
                    
                    $fund_ret_avg_of_nav = ($fund_return-$average_of_nav);
                    
                    $fund_return_daily_risk_free = ($fund_return-$daily_risk_free);

                    $res = array(
                        'entry_date' => date("d-m-Y", strtotime($value)),
                        'fund_closing' => $foundFundRow['closing_nav'] ?? 0,
                        'indices_closing' => $foundIndicesRow['closing_value'] ?? 0,
                        'fund_return' => $fund_return ?? 0,
                        'index_return' => $index_return ?? 0,
                        'fund_return_daily_risk_free' => $fund_return_daily_risk_free,
                    );
                    $sum_of_g +=$fund_ret_avg_of_nav*$fund_ret_avg_of_nav;
                    $sum_of_fund_return_daily_risk_free += $fund_return_daily_risk_free;
                    $i++;
                    array_push($searchedResultArray , $res);
                }
            }

            $data['searched_result'] = $searchedResultArray;
            $data['average_of_nav'] = $average_of_nav ?? 0;
            $data['sum_of_g'] = $sum_of_g ?? 0;
            $data['total_number_of_result'] = $i;
            if($i != 0)
            {
                $data['sum_of_g_n'] = $sum_of_g/$i;
                $data['average_of_fund_return_daily_risk_free'] = $average_of_fund_return_daily_risk_free = $sum_of_fund_return_daily_risk_free/$i;
            }
            else
            {
                $data['sum_of_g_n'] = 0;
                $data['average_of_fund_return_daily_risk_free'] = $average_of_fund_return_daily_risk_free = 0;
            }
            $volatility = sqrt($data['sum_of_g_n']);
            $data['volatility'] = is_nan($volatility) ? 0 : $volatility;
            if($volatility != 0 || !is_nan($volatility))
            {
                $sharpe = $average_of_fund_return_daily_risk_free/$volatility;
            }
            else
            {
                $sharpe = 0;
            }

            $data['sharpe'] = $sharpe;
            
        }
        
        $data['fundNames'] = FundMaster::select('fund_name','fund_code')->where('status',1)->get();

        return view('web.infosolz-calculator.sharpe',$data);
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