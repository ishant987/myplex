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


class BetaController extends BaseController
{
    public function beta_calculator(Request $request)
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

            $fund_details = FundMaster::select('indices_name')->where('fund_code',$input['search_fund_name'])->first();

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

            $total_indices = 0;
            $total_index = 0;
            $k = 0;

            foreach($allDates as $value)
            {
                $filteredIndicesRowsData = [];

                $filteredIndicesRowsData = array_filter($indicesDatasArray, function ($row) use ($value) {
                    return $row['entry_date'] === $value && $row['holiday'] != 1;
                });

                $foundIndicesRowData = reset($filteredIndicesRowsData);

                if($foundIndicesRowData ==  false)
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
                            $maxIndicesAttempts = 29; 

                            $reset_indices_date = '';
                            for ($attemptIndeces = 1; $attemptIndeces <= $maxIndicesAttempts; $attemptIndeces++) 
                            {
                                if($attemptIndeces == 1)
                                {
                                    $oneDayAgoDateIndices = Carbon::parse($value)->subDay('1')->toDateString();

                                    $reset_indices_date = $oneDayAgoDateIndices;
                                }
                                else
                                {
                                    $oneDayAgoDateIndices = Carbon::parse($reset_indices_date)->subDay('1')->toDateString();
                                    $reset_indices_date = $oneDayAgoDateIndices;
                                }
                                

                                $filteredIndicesRowsData = array_filter($indicesDatasArray, function ($row) use ($oneDayAgoDateIndices) {
                                    return $row['entry_date'] === $oneDayAgoDateIndices && $row['holiday'] != 1;
                                });

                                $foundIndicesRowData = reset($filteredIndicesRowsData);

                                if ($foundIndicesRowData) {
                                    $reset_indices_date = '';
                                    break;
                                }
                            }

                        }
                    }
                    
                }

                if($foundIndicesRowData != false)
                {
                    if($k == 0)
                    {
                        if(isset($oneDayBeforeEntryDateIndicesDatas->closing_value) && $oneDayBeforeEntryDateIndicesDatas->closing_value != 0)
                        {
                            $total_index += (($foundIndicesRowData['closing_value']-$oneDayBeforeEntryDateIndicesDatas->closing_value)/$oneDayBeforeEntryDateIndicesDatas->closing_value)*100;
                        }
                        else
                        {
                            $total_index += 0;
                        }
                        
                        $old_store_index_value = $foundIndicesRowData['closing_value'];
                    }
                    else
                    {
                        if(isset($old_store_index_value))
                        {
                            $total_index += (($foundIndicesRowData['closing_value']-$old_store_index_value)/$old_store_index_value)*100;
                            $old_store_index_value = $foundIndicesRowData['closing_value'];
                        }
                    }
                    $total_indices += 1;
                    $k++;
                }

            }

            if($total_indices != 0)
            {
                $average_of_index = ($total_index/$total_indices);
            }
            else
            {
                $average_of_index = 0;
            }



            $searchedResultArray = [];
            $i = 0;
            $f_g_sum = 0;
            $h_sum = 0;
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

                $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($value) {
                    return $row['entry_date'] === $value && $row['holiday'] != 1;
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
                                

                                $filteredIndicesRows = array_filter($indicesDatasArray, function ($row) use ($oneDayAgoDateIndices) {
                                    return $row['entry_date'] === $oneDayAgoDateIndices && $row['holiday'] != 1;
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



                $fund_return_average_of_return = 0;
                $index_ret_average_of_index = 0;
                
                

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
                        // $fund_return = $foundFundRow['percentage_change'] ?? 0;
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

                    $fund_return_average_of_return = $fund_return-$average_of_nav;
                    
                    if(isset($index_return)){
                        $index_ret_average_of_index = $index_return - $average_of_index;
                    }else{
                        $index_ret_average_of_index = 0-$average_of_index;
                    }

                    $index_rate_average_of_index_squere = $index_ret_average_of_index*$index_ret_average_of_index;
                    $f_g = $fund_return_average_of_return*$index_ret_average_of_index;

                    $res = array(
                        'entry_date' => date("d-m-Y", strtotime($value)),
                        'fund_closing' => $foundFundRow['closing_nav'] ?? 0,
                        'indices_closing' => $foundIndicesRow['closing_value'] ?? 0,
                        'fund_return' => $fund_return ?? 0,
                        'index_return' => $index_return ?? 0,
                        'fund_return_average_of_return' => ($fund_return_average_of_return == -0) ? 0 : $fund_return_average_of_return,
                        'index_ret_average_of_index' =>  ($index_ret_average_of_index == -0) ? 0 : $index_ret_average_of_index,
                        'index_rate_average_of_index_squere' => ($index_rate_average_of_index_squere == -0) ? 0 : $index_rate_average_of_index_squere,
                        'f_g' => ($f_g == -0) ? 0 : $f_g,
                    );
                    $f_g_sum += $fund_return_average_of_return*$index_ret_average_of_index;
                    $h_sum +=$index_ret_average_of_index*$index_ret_average_of_index;
                    $i++;
                    array_push($searchedResultArray , $res);
                    
                }
            }
            $data['searched_result'] = $searchedResultArray;
            $data['average_of_nav'] = $average_of_nav ?? 0;
            $data['average_of_index'] = $average_of_index ?? 0;
            $data['sum_of_fg'] = $f_g_sum ?? 0;
            if($i != 0)
            {
                //$data['covariance'] = $covariance = $f_g_sum??0/($i-1);
                if($f_g_sum > 0){
                    $covariance = $f_g_sum / ($i-1);
                }else{
                    $covariance = 0;
                }
                $data['covariance'] = $covariance;
                //$data['variance'] = $variance = $h_sum??0/$i;

                if($h_sum > 0){
                    $variance = $h_sum / $i;
                }else{
                    $variance = 0;
                }

                $data['variance'] = $variance;
            }
            else
            {
                $data['covariance'] = $covariance = 0;
                $data['variance'] = $variance = 0;
            }
            
            
            $data['sum_of_h'] = $h_sum ?? 0;
            $data['total_number_of_result'] = $i;
            if($variance != 0)
            {
                $data['beta'] = $covariance/$variance;
            }
            else
            {
                $data['beta'] = 0;
            }            
        }
        
        $data['fundNames'] = FundMaster::select('fund_name','fund_code')->where('status',1)->get();

        return view('web.infosolz-calculator.beta',$data);
    }

    public function get_indices_name(Request $request)
    {
        $fund_code = $request->fund_code;
        $fund_details = FundMaster::select('indices_name')->where('fund_code',$fund_code)->first();
        if($fund_details)
        {
            echo $fund_details->indices_name;
        }
        else
        {
            echo 'not_found';
        }
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
