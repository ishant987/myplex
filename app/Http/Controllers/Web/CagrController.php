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


class CagrController extends BaseController
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

    public function cagr_calculator(Request $request)
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


            $fundsDatas = FundDetail::where('fund_code',$input['search_fund_name'])->whereBetween('entry_date', [date("Y-m-d", strtotime($input['search_from_date'])),date("Y-m-d", strtotime($data['search_to_date']))])->get();

            $fund_details = FundMaster::select('fund_name','indices_name','risk_free_return')->where('fund_code',$input['search_fund_name'])->first();

            $indices_names = IndicesMaster::where('name',$fund_details->indices_name)->first();
            if($indices_names)
            {
                $indices_name_array = [$indices_names->name,$indices_names->corelation];
            }

            $fundsDatasArray = $fundsDatas->toArray();

            $start = Carbon::parse(date("Y-m-d", strtotime($input['search_from_date'])));
            $end = Carbon::parse(date("Y-m-d", strtotime($input['search_to_date'])));

            $monthsDifference = $start->diffInMonths($end)+1;
            $getYear = $monthsDifference/12;

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

            $data['indices_name'] = $fund_details->indices_name;
            $data['fund_name'] = $fund_details->fund_name;


            $searchedResultArray = [];
            $i = 0;

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

                

                if($foundIndicesRow != false || $foundFundRow != false )
                {

                    if($i == 0)
                    {
                        $fund_return_first_value = $foundFundRow['closing_nav'] ?? 0;
                        $index_return_first_value = $foundIndicesRow['closing_value'] ?? 0;
                    }


                    $res = array(
                        'entry_date' => date("d-m-Y", strtotime($value)),
                        'fund_closing' => $foundFundRow['closing_nav'] ?? 0,
                        'indices_closing' => $foundIndicesRow['closing_value'] ?? 0,
                    );
                    $i++;
                    array_push($searchedResultArray , $res);
                    $fund_return_last_value = $foundFundRow['closing_nav'] ?? 0;
                    $index_return_last_value = $foundIndicesRow['closing_value'] ?? 0;
                }

            }


            if(isset($fund_return_first_value) && $fund_return_first_value != 0)
            {   
                $fund_return_absolute = ((pow($fund_return_last_value / $fund_return_first_value, 1 / $getYear) - 1) * 100);
            }
            else
            {
                $fund_return_absolute = 0;
            }
            if(isset($index_return_first_value) && $index_return_first_value != 0)
            {   
                $index_return_absolute = ((pow($index_return_last_value / $index_return_first_value, 1 / $getYear) - 1) * 100);
            }
            else
            {
                $index_return_absolute = 0;
            }
            $data['searched_result'] = $searchedResultArray;
            $data['fund_return_absolute'] = $fund_return_absolute;
            $data['index_return_absolute'] = $index_return_absolute;
        }

        $data['fundNames'] = FundMaster::select('fund_name','fund_code')->where('status',1)->get();

        return view('web.infosolz-calculator.cagr',$data);
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