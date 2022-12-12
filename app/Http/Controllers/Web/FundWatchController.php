<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FundComposition;
use App\Lib\Core\Core;
use App\Lib\Core\Useful;
use App\Models\FundDetail;
use App\Models\CorpusEntry;
use App\Models\PageModel;
use App\Models\FundWatch;
use App\Models\FundWatchNew;
use App\Models\FundMaster;
use App\Models\IndicesDetail;
use App\Modles\SettingsModel;
use DB;

class FundWatchController extends BaseController
{
    public function __construct()
    {
        $this->defDataArr = self::getDefData();
        $this->page_path = env('PAGE_PATHS', 'web.pages');
        $this->Useful = new Useful;
    }

    public function watch(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
            $dtMdl = new FundWatch();
            $commonconstants = Config('commonconstants');
            $archiveListModel = $dtMdl->archiveGroupList();
            // if ($archiveListModel && $reqYear == 0) {
            //     $reqYear = $archiveListModel[0]->year;
            // }

            // $dataListModel = $dtMdl->frontList(['year' => $reqYear]);

            $rcntDataListModel = $dtMdl->frontList([], '', '', '', 10);
            $defDataArr = $this->defDataArr;
            $dateFormat = $commonconstants['d_m_y_frmt2'];
            $media_folder = Core::getUploadedURL($commonconstants['pdf_dir_name']);
        }
        return view($this->page_path . '.fund-watch', compact('dataArr', 'rcntDataListModel', 'archiveListModel', 'media_folder'));
    }
    public function index(Request $request, $reqYear = 0)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $dataListModel = $archiveListModel = $rcntDataListModel = [];
            $reqId = 0;

            $commonconstants = Config('commonconstants');

            $dtMdl = new FundWatch();

            $archiveListModel = $dtMdl->archiveGroupList();
            if ($archiveListModel && $reqYear == 0) {
                $reqYear = $archiveListModel[0]->year;
            }

            $dataListModel = $dtMdl->frontList(['year' => $reqYear]);

            $rcntDataListModel = $dtMdl->frontList([], '', '', '', 3);

            $defDataArr = $this->defDataArr;
            $dateFormat = $commonconstants['d_m_y_frmt2'];

            return view('themes.frontend.pages.fund-watch-list', compact('defDataArr', 'dataArr', 'dataListModel', 'rcntDataListModel', 'archiveListModel', 'dateFormat', 'reqYear', 'reqId'));
        }
        return abort(404);
    }

    public function show(Request $request, $reqId)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 45);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $dataMdl = $dataListModel = $archiveListModel = $rcntDataListModel = [];
            $reqYear = 0;

            $dtMdl = new FundWatch();

            $dataMdl = $dtMdl->getData(['fw_id' => $reqId, 'status' => $commonconstants['status_val'][1]]);

            if (!$dataMdl) {
                return abort(404);
            }

            $archiveListModel = $dtMdl->archiveGroupList();
            if ($archiveListModel) {
                $year = $archiveListModel[0]->year;
                $dataListModel = $dtMdl->frontList(['year' => $year]);
            }

            $rcntDataListModel = $dtMdl->frontList([], '', '', '', 3);

            $dataArr['item'] = $dataMdl;
            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name'])));

            return view('themes.frontend.pages.fund-watch', compact('defDataArr', 'dataArr', 'dataListModel', 'rcntDataListModel', 'archiveListModel', 'reqYear', 'reqId'));
        }
        return abort(404);
    }

    public function newIndex(Request $request, $fund_code)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        $dataArr['full_url'] = $request->fullUrl();

        $meta_title = $dataArr['meta_title'];
        $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
        $meta_descp = $dataArr['meta_descp'];
        $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

        $fundMaster = FundMaster::where("fund_code", $fund_code)->first();
        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
        $AAUMValue = SELF::AAUMValue($fund_code);
        $fund_code = $fundMaster->fund_code;
		$returnLessIndex =SELF::returnLessIndex($fund_code,$fundMaster->classification);//'returnLessIndex'=>$returnLessIndex,
        // $sip = SELF::getSIPData($fund_code);
       return view($this->page_path . '.fund_watch.details',compact('fundMaster','fundWatch','AAUMValue','dataArr','returnLessIndex'));
         //return response()->json(['fund_code' => $fund_code,'RiskAdjustedAlpha'=>$RiskAdjustedAlpha, 'breakup' => $PortFoliBreakup, 'AAUM' => $AAUMValue, 'lumsum' => $lumbsum, 'sip' => $sip, 'fund_comp_analysis' => $fundCompAnalysis], 200); //
    }
	public function returnLessIndex($fund_code,$indices_name){
		$last_date = FundDetail::getLastPublishedDate($fund_code);
        $return_scheme = DB::select('CALL sp_fund_search_scheme_ret("'.$last_date.'","'.$fund_code.'")');
		$return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret("'.$last_date.'","'.$indices_name.'","'.$fund_code.'")');
		$defaultTimePeriod =['6 months'=>'SIXMONTHS','1 Year'=>'ONEYEAR','2 Year'=>'TWOYEAR','3 Year'=>'THREEYEAR','5 Year'=>'FIVEYEAR'];
		$return_schemer =(array) $return_scheme[0];
		$return_benchmarkr = (array)$return_benchmark[0];
        $result[]=['Time frame','Value'];
		foreach($defaultTimePeriod as $key=>$val)
		{
			$result[]=[$key,round($return_schemer[$val]-$return_benchmarkr[$val],2)];
		}
		return json_encode($result);
	}
	public function getreturnLessRank($fund_code,$classification,$indices){
		$last_date =$this->Useful->get_yesterday();// IndicesDetail::getLastPublishedDate($indices);
		$defaultMonths=['sixmonths'=>[6,'6 M'],'oneyear'=>[12,'1 Y'],'twoyear'=>[24,'2 Y'],'threeyear'=>[36,'3 Y'],'fiveyear'=>[60,'5 Y']];//,12,24,36,60
		$type_id=$classification;
		foreach($defaultMonths as $key=>$val){
			$date[] = SELF::get_last_month($val[0],$last_date);
			//$data = DB::select('CALL sp_monthly_return_less_index_rank("'.$date.'","'.$type_id.'")');
			//$sortedData =collect($data)->sortBy([[$key, 'desc']]);
			//$rank = $sortedData->search(function($user) use($fund_code) {
							//return $user->fund_code == $fund_code;
					//});
			//$result[] = [
				//'period'=>$val[1],
				//'active_funds'=>count($data),
				//'rank'=>$rank,
                //'date'=>date('d-M-Y',strtotime($date)),
				
			//];
		}
		$data['sixmonths'] = DB::select('CALL sp_monthly_return_less_index_rank_six("'.$date[0].'","'.$type_id.'")');
		$data['oneyear'] = DB::select('CALL sp_monthly_return_less_index_rank_one_year("'.$date[1].'","'.$type_id.'")');
		$data['twoyear'] = DB::select('CALL sp_monthly_return_less_index_rank_two_year("'.$date[2].'","'.$type_id.'")');
		$data['threeyear'] = DB::select('CALL sp_monthly_return_less_index_rank_three_year("'.$date[3].'","'.$type_id.'")');
		$data['fiveyear'] = DB::select('CALL sp_monthly_return_less_index_rank_five_year("'.$date[4].'","'.$type_id.'")');
		$i=0;
		//return ['status'=>'success','html'=>$data];
		foreach($defaultMonths as $key=>$val){
			$sortedData =collect($data[$key])->sortBy([[$key, 'desc']]);
			$rank = $sortedData->search(function($user) use($fund_code) {
							return $user->fund_code == $fund_code;
					});
			$result[] = [
				'period'=>$val[1],
				'active_funds'=>count($data[$key]),
				'rank'=>$rank,
                'date'=>date('d-M-Y',strtotime($date[$i])),
				
			];
			$i++;
		}
		
		$html = view('web.pages.fund_watch.return_less_rank',['result'=>$result])->render();
        return ['status'=>'success','html'=>$html];
	}
	 public function get_last_month($month,$last_date)
    {
        $last_month_sd =  date('Y-m-d', strtotime("-".$month." months",strtotime($last_date)));

        return $last_month_sd;
    }
    public function getReturnContinous($fund_code){
        $benchMarkResponse =Http::get(url('api/v1/fund-return-benchmark?fund_code='.$fund_code))->json();
        $CategoryAverageResponse =Http::get(url('api/v1/fund-performance-compare-category?fund_code='.$fund_code))->json();
        $schemeResponse =Http::get(url('/api/v1/fund-return-scheme?fund_code='.$fund_code))->json();
        $scheme =$schemeResponse['data']['return_scheme'];
		$CategoryAverage =$CategoryAverageResponse['data']['category_compare_data'];
		$benchMark =$benchMarkResponse['data']['return_benchmark'];
		$html = view('web.pages.fund_watch.retun_continus',['scheme'=>$scheme,'category_average'=>$CategoryAverage,'bench_mark'=>$benchMark])->render();
        return ['status'=>'success','html'=>$html];
		
    }
    public function getRiskAplha($fund_code){
        $response =Http::get(url('api/v1/fund-performance-jensenalpha-beta-volatility?fund_code='.$fund_code))->json();
		$defaultYears = ['ONEYEAR', 'TWOYEAR', 'THREEYEAR'];
		$result =[];
		if($response['success']){
			$data =$response['data']['jensenalpha_beta_volatility_data'];
			foreach($defaultYears as $val){
				$finacialYearStart1 =date("y",strtotime($data[$val]['end_date']));
				$finacialYearStart2 =date("y",strtotime($data[$val]['start_date']));
					$result ['H1 FY’'.$finacialYearStart1.'-'.$finacialYearStart2]=$data[$val];
									 
			}
		}
        $html = view('web.pages.fund_watch.risk_adjusted_alpha',['RiskAdjustedAlpha'=>$result])->render();
        return ['status'=>'success','html'=>$html];
    }
    public function breakUP($fund_code)
    {
        $lastMonthDate = $lastSavedDate =  FundComposition::getPublishReadyDate();
        $filterArray = ['Equity' => 0, 'Cash' => 0, 'Corporate Debt' => 0, 'SOV' => 0, 'Others' => 0];
        $AllBreakUP = FundComposition::where(['fund_code' => $fund_code, 'entry_date' => $lastMonthDate])->get()->toArray();

        foreach ($AllBreakUP as $key => $value) {
            if (in_array($value['category'], array_keys($filterArray))) {
                $filterArray[$value['category']] = $filterArray[$value['category']]+$value['content_per'];
            } else {
                $filterArray['Others'] = $filterArray['Others'] + $value['content_per'];
            }
        }

        $html = view('web.pages.fund_watch.portfolio_break_up',['PortFoliBreakup'=>$filterArray])->render();
        return ['status'=>'success','html'=>$html];
        return $filterArray;
    }
    public function getSIPData($fund_code)
    {
        $deatultSIPAmount = 10000;
        $defaultYears = ['ONEYEAR' => 1, 'TWOYEAR' => 2, 'THREEYEAR' => 3];
        $dataArr['1 year'] = DB::select('CALL sp_SIP_calc(12,"' . $fund_code . '",10000)');
        $dataArr['2 year'] = DB::select('CALL sp_SIP_calc(24,"' . $fund_code . '",10000)');
        $dataArr['3 year'] = DB::select('CALL sp_SIP_calc(36,"' . $fund_code . '",10000)');
        // $response =Http::get('api/v1/fund-performance-scheme-sip?fund_code='.$fund_code)->json();
        $finalArr = [];
        foreach ($dataArr as $key => $data) {
            if (count($data)) {
                $finalArr[$key] = $data[0];
            } else {
                $finalArr[$key] = [];
            }
        }
        $responseArr = [
            'success' => true,
            'message' => 'success',
        ];

        
        $responseArr['scheme_sip_data'] = $finalArr;
        return response()->json($responseArr);
    }
    private function AAUMValue($fund_code)
    {
        $numberOfGrapBar = 6;
        $mothsGap = 3;
        $flastMonthDate = $this->Useful->get_last_month();
       $result[]=['Entry Date','Value'];
        for ($i = 0; $i <= $numberOfGrapBar; $i++) {
            $s_date = $flastMonthDate[0];
            $dates = $this->Useful->get_last_month_quatery($s_date, $i * $mothsGap);
            $FUnddata = CorpusEntry::where("fund_code", $fund_code)->where('entry_date', $dates[1])->get(['corpus_entry', 'entry_date'])->toArray();
			if(!empty($FUnddata))
			{
					 $result[]=[$FUnddata[0]['entry_date'],$FUnddata[0]['corpus_entry']];
			}
			
         
        }
        return json_encode($result);
    }
    public function getLumnsubData($fund_code)
    {
        $deatultLumsumAmount = 100000;
        $defaultYears = ['ONEYEAR' => 1, 'TWOYEAR' => 2, 'THREEYEAR' => 3];
        $yesterday = $this->Useful->get_yesterday();
        //$yesterday='2022-11-01';
        $fundDetails = FundDetail::where("fund_code", $fund_code);
        $presentClosingNav = $fundDetails->where('entry_date', $yesterday)->first('closing_nav');
        $PreviewYearNavs = [];
        if ($presentClosingNav) {
            $response = Http::get(url('api/v1/fund-return-scheme?fund_code=' . $fund_code))->json();
            $percentege = $response['data']['return_scheme'];
            foreach ($defaultYears as $key => $val) {
                $LastYeardate = $this->Useful->getYears($val, $yesterday);
                $data = FundDetail::where("fund_code", $fund_code)->where('entry_date', $LastYeardate)->first('closing_nav');

                if ($data) {
                    $numberofUnits = round($deatultLumsumAmount / $data->closing_nav, 3);
                    $PreviewYearNavs[$val . ' Year'] = [
                        'amount' => $this->Useful->currencyFormat(round($numberofUnits * $presentClosingNav->closing_nav)),
                        'last_date' => $LastYeardate,
                        'last_date_nav_val' => $data->closing_nav,
                        'start_date' => $yesterday,
                        'start_date_nav_val' => $presentClosingNav['closing_nav'],
                        'numer_of_units' => $numberofUnits,
                        'percentage' => round($percentege[$key], 2),
                    ];
                } else {
                    $PreviewYearNavs[$val . ' Year' . $LastYeardate . $yesterday] = [];
                }
            }
            
        }
        $html = view('web.pages.fund_watch.lumsum',['lumbsum'=>$PreviewYearNavs])->render();
        return ['status'=>'success','html'=>$html];
    }
    public function fundCompAnalysis($fund_code)
    {
        $lastMonthDate = $lastSavedDate =  FundComposition::getPublishReadyDate();
        $topScripts = FundComposition::where(['fund_code' => $fund_code, 'category' => 'Equity', 'entry_date' => $lastMonthDate])
                                        ->orderBy('content_per', 'desc')
                                        ->latest()
                                        ->take(10)
                                        ->pluck('scrip_name')
                                        ->toArray();
        $numberOfRecords = 5;
        $mothsGap = 3;
        $Headertemp = array();
        for ($i = 0; $i < $numberOfRecords; $i++) {
            $s_date = $lastMonthDate;
            $dates = $this->Useful->get_last_month_quatery($s_date, $i * $mothsGap);
            array_push($Headertemp, date("M'y", strtotime($dates[1])));
            $top_10[$dates[1]] = FundComposition::where(['fund_code' => $fund_code, 'category' => 'Equity', 'entry_date' => $dates[1]])
                                                    ->orderBy('content_per', 'desc')
                                                    ->latest()
                                                    ->take(10)
                                                    ->pluck('content_per', 'scrip_name')
                                                    ->toArray();
        }
        $headers = array_merge(['script'],$Headertemp);
        $result = [];
        foreach ($topScripts as $key => $script) {
            $temp = [];
            foreach ($top_10 as $date => $values) {
                $temp[] = isset($values[$script]) ? $values[$script] : 'NA';
            }
            $result[$script] = $temp;
        }
         $fundCompAnalysis=['headers'=>$headers,'result'=>$result];
        $html = view('web.pages.fund_watch.fund_composition',['fundCompAnalysis'=>$fundCompAnalysis])->render();
        return ['status'=>'success','html'=>$html];
    }
}
