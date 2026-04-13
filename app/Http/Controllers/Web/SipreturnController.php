<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundDetail;
use App\Models\FundMaster;
use Carbon\Carbon;
use DateTime;
use DateInterval;

class SipreturnController extends BaseController
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

    public function sipreturn_calculator(Request $request)
    {
        $input = $request->all();
        if(isset($input['search']) && $input['search'] == 'Search')
        {

            $this->validate($request, [
                'search_fund_name' => 'required',
                'search_sip_amount' => 'required',
                'search_term' => 'required_without:search_term_month',
                'search_term_month' => 'required_without:search_term',
                'search_entry_date' => 'required',
                'search_report_date' => 'required',
            ],[
                'search_fund_name.required' => 'The fund name field is required',
                'search_sip_amount.required' => 'The SIP amount field is required',
                'search_term.required_without' => 'Either the term (year)field or the term (month) field is required',
                'search_term_month.required_without' => 'Either the term (year)field or the term (month) field is required',
                'search_entry_date.required' => 'The entry date field is required',
                'search_report_date.required' => 'The report date field is required',
            ]);
            
            $data['search_fund_name'] = $input['search_fund_name'];
            $data['search_sip_amount'] = $input['search_sip_amount'];
            $data['search_term'] = $search_term =  $input['search_term'];
            $data['search_term_month'] = $search_term_month =  $input['search_term_month'];
            $data['search_entry_date'] = $input['search_entry_date'];
            $data['search_report_date'] = $input['search_report_date'];



            $entryDate = DateTime::createFromFormat('d-m-Y', $input['search_entry_date']);

            if($search_term != ''){
                $entryDate->modify('+'.$search_term.' year');
            }

            if($search_term_month != ''){

                $entryDate->modify(($search_term_month-1).' month');
            }
            else{
                
                $entryDate->modify('-1 month');
            }
            
            

            $sip_final_date = $entryDate->format('Y-m-d');
            $sip_day = $entryDate->format('d');

            $redemptionDate = strtotime($input['search_report_date'] . ' -1 day');

            $fundsDatas = FundDetail::where('fund_code',$input['search_fund_name'])->whereBetween('entry_date', [date("Y-m-d", strtotime($input['search_entry_date'])),date("Y-m-d", strtotime($input['search_report_date']))])->where('entry_date','like','%-'.$sip_day)->get();
            
            $particularDayFundNav = FundDetail::where('fund_code',$input['search_fund_name'])->where('entry_date',date("Y-m-d", $redemptionDate))->first();


            $fundsDatasArray = $fundsDatas->toArray();

            $start = Carbon::parse(date("Y-m-d", strtotime($input['search_entry_date'])));
            $end = Carbon::parse(date("Y-m-d", strtotime($input['search_report_date'])));

            $allDates = [];

            while ($start->lte($end)) {
                $allDates[] = $start->toDateString();
                $start->addDay(); 
            }

            $searchedResultArray = [];
            $i = 0;
            $unit_array = [];
            $sip_dates_array = [];
            $sip_cashflow_array = [];

            foreach($allDates as $value)
            {
                if($value <= $sip_final_date)
                {
                    $filteredFundRows = [];

                    $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($value) {
                        return $row['entry_date'] === $value;
                    });

                    $foundFundRow = reset($filteredFundRows);
                    

                    if($foundFundRow != false )
                    {
                        if($foundFundRow['closing_nav'] != 0)
                        {
                            $units = $input['search_sip_amount']/$foundFundRow['closing_nav'];
                        }
                        else
                        {
                            $units = 0;
                        }
                        
                    
                        $res = array(
                            'entry_date' => date("d-m-Y", strtotime($value)),
                            'sip_amount' => -$input['search_sip_amount'],
                            'fund_closing' => $foundFundRow['closing_nav'] ?? 0,
                            'units' => $units
                        );
                        $i++;
                        array_push($sip_cashflow_array,-$input['search_sip_amount']);
                        array_push($sip_dates_array,$value);
                        array_push($unit_array,$units);
                        array_push($searchedResultArray , $res);
                    }
                }
                
            }

            $sum_of_units = array_sum($unit_array);
            $total_sip_amount = $particularDayFundNav['closing_nav']*$sum_of_units;

            array_push($sip_cashflow_array,$total_sip_amount);
            array_push($sip_dates_array,date("Y-m-d",$redemptionDate));

            $data['searched_result'] = $searchedResultArray;

            $dateSerials = array_map(function ($date) {
                return strtotime($date) / 86400 + 25569; // 25569 is the number of days between 1900-01-01 and 1970-01-01
            }, $sip_dates_array);
            $xirr = $this->xirr($dateSerials, $sip_cashflow_array);

            if ($xirr != null) 
            {
                $data['xirr'] =  number_format($xirr * 100, 2);
            } 
            else 
            {
                $data['xirr'] = 0;
            }

           

            $data['redemption_date'] = date("d-m-Y",$redemptionDate);
            $data['total_sip_amount'] = $total_sip_amount;
            $data['final_nav'] = $particularDayFundNav['closing_nav'];
            $data['sum_of_units'] = $sum_of_units;
           
            
        }
        
        $data['fundNames'] = FundMaster::select('fund_name','fund_code')->where('status',1)->get();

        return view('web.infosolz-calculator.sip',$data);
    }


    function xirr($dates, $cashflows, $guess = 0.1)
    {
        $maxIterations = 100;
        $precision = 1.0e-8;

        $x0 = $guess;
        $i = 0;

        do {
            $fValue = $this->xirrFunction($x0, $dates, $cashflows);
            $fDerivative = $this->xirrDerivative($x0, $dates, $cashflows);

            $x1 = $x0 - $fValue / $fDerivative;
            $i++;

            if (abs($x1 - $x0) < $precision) {
                return $x1;
            }

            $x0 = $x1;
        } while ($i < $maxIterations);

        return false; // Failed to converge
    }
    function xirrFunction($rate, $dates, $cashflows)
    {
        $result = 0;
        $n = count($dates);

        for ($i = 0; $i < $n; $i++) {
            $result += $cashflows[$i] / pow(1 + $rate, ($dates[$i] - $dates[0]) / 365);
        }

        return $result;
    }

    function xirrDerivative($rate, $dates, $cashflows)
    {
        $result = 0;
        $n = count($dates);

        for ($i = 0; $i < $n; $i++) {
            $result -= ($dates[$i] - $dates[0]) / 365 * $cashflows[$i] / pow(1 + $rate, ($dates[$i] - $dates[0]) / 365 + 1);
        }

        return $result;
    }
}