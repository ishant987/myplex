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
use Exception;
use NumberFormatter;


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
		// dd('index');
		if($reqYear){
			//$createdAt = DB::table("fund_watch")->where("fund_code",'<>',"")->get("created_at");
			$createdAt = DB::table('fund_watch')
						->where("fund_code",'<>',"")
    					 ->where(DB::raw('YEAR(created_at)'), '=', $reqYear)
   	 					->get();
			
			//dd($createdAt);
			
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

				$dtMdl = new FundWatchNew();



				$WatchDataListModel = $dtMdl->list()->toArray();
				// dd($WatchDataListModel);
				$defDataArr = $this->defDataArr;
				$dateFormat = $commonconstants['d_m_y_frmt2'];

				$fundWatchData = DB::table("fund_watch")->get();

				$fundWatchDescription = DB::table("fund_watch")->get('description');

				$fundWatchTitle = DB::table("fund_watch")->get('title');

				//$fundWatchFileLink = DB::table("fund_watch")->get("file");

				return view($this->page_path . '.fund_watch.index', compact('defDataArr', 'dataArr', 'dataListModel', 'WatchDataListModel', 'archiveListModel', 'dateFormat', 'reqYear', 'reqId', 'fundWatchTitle', 'fundWatchDescription', 'fundWatchData','createdAt'));
			}
			return abort(404);
		
		}
		else {
			// dd('else');
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

				$dtMdl = new FundWatchNew();



				$WatchDataListModel = $dtMdl->list()->toArray();
				// dd($WatchDataListModel);
				$defDataArr = $this->defDataArr;
				$dateFormat = $commonconstants['d_m_y_frmt2'];

				$fundWatchData = DB::table("fund_watch")->get();

				$fundWatchDescription = DB::table("fund_watch")->get('description');
				// dd($fundWatchDescription);

				$fundWatchTitle = DB::table("fund_watch")->get('title');

				//$fundWatchFileLink = DB::table("fund_watch")->get("file");

				return view($this->page_path . '.fund_watch.index', compact('defDataArr', 'dataArr', 'dataListModel', 'WatchDataListModel', 'archiveListModel', 'dateFormat', 'reqYear', 'reqId', 'fundWatchTitle', 'fundWatchDescription', 'fundWatchData'));
			}
			return abort(404);
		}
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
		// dd($request->all());
		// dd($fund_code);
        $fund_code =base64_decode($fund_code);
		// dd($fund_code);
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        $dataArr['full_url'] = $request->fullUrl();
		// dd($dataArr);

        $meta_title = $dataArr['meta_title'];
        $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
        $meta_descp = $dataArr['meta_descp'];
        $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
		// dd($dataArr);
        $fundMaster = FundMaster::where("fund_code", $fund_code)->first();
		// dd($fundWatch);
		// $query = DB::getQueryLog();
		// $lastQuery = end($query);

		// Print the last query
		// echo $lastQuery['query'];die;
        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
		// dd($fund_code);
		for($i=0;$i<4;$i++){
			$fundnames[] = $fundMaster->fund_name;
			$schemenamei = date("jS F Y", strtotime($fundMaster->fund_opened));
		}
		$i = 0;
		$fundmanager = $fundMaster->fund_manager;
		
		//dd($fundmanager);
		if( strpos($fundmanager, ",") !== false ) {
     		//dd($fundmanager);
			$efm = explode(',',$fundmanager);
			for($t=0;$t<count($efm);$t++){
				//print_r("SELECT fund_name FROM mpx_fund_master WHERE fund_manager = '".$efm[$t]."'");
				$rth = trim($efm[$t], " ");
				$scheme = FundMaster::where("fund_manager", $rth)->get();
				foreach ($scheme as $tow){
					if($i <= 3){
						$schemename[] = $tow->fund_name;
					}
					$i++;
				}
			}
		}else{
			$scheme = FundMaster::where("fund_manager", $fundmanager)->get();
			foreach ($scheme as $tow){
				if($i <= 3){
					$schemename[] = $tow->fund_name;
				}
				$i++;
			}
		}
		//dd($fnm);
		$fund_typeid = $fundMaster->fund_type_id;
		$fundname = FundMaster::where("fund_type_id", $fund_typeid)->get();
		$nfm = count($fundname);
		$snm = implode(',',$schemename);
		$fmbfm=implode(',',$fundnames);
        $AAUMValue = SELF::AAUMValue($fund_code);
		// dd($AAUMValue);
        $fund_code = $fundMaster->fund_code;
		$returnLessIndex =SELF::returnLessIndex($fund_code,$fundMaster->classification);//'returnLessIndex'=>$returnLessIndex,	
		//dd($returnLessIndex);
		DB::select('SET SESSION group_concat_max_len = 100');
		$scrips = DB::select("SELECT count(*) as total FROM `mpx_fund_composition` WHERE `fund_code`='".$fund_code."'");
		$scripts_count=DB::select("SELECT scrip_name as scrip_names FROM `mpx_fund_composition` WHERE `fund_code`='".$fund_code."'LIMIT 5");
		foreach($scripts_count as $sc){
			$scarr[]=$sc->scrip_names;
		}
		$scarrimo=implode(',',$scarr);
		$total_asset = DB::select("select corpus_entry from mpx_corpus_entry where fund_code='".$fund_code."' order by entry_date desc limit 1");
		$crore = round($total_asset[0]->corpus_entry * 0.01,2);
		$date = DB::table("fund_composition")->latest('entry_date')->first();
		$dateall = DB::table("fund_composition")->select('entry_date')->where("fund_code",$fund_code)->orderByRaw("entry_date  DESC")->groupBy('entry_date')->limit(12)->get();
		$date1 = "";
		$date2 = "";
		$date3 = "";
		$date4 = "";
		foreach($dateall as $new => $value){
			if($new = 1)$date1=$dateall[$new]->entry_date;
			if($new = 4)$date2=$dateall[$new]->entry_date;
			if($new = 7)$date3=$dateall[$new]->entry_date;
			if($new = 10)$date4=$dateall[$new]->entry_date;
		}
		$dayn = date('F, y', strtotime($date->entry_date));
		$day1n = date('F, y', strtotime($date1));
		$day2n = date('F, y', strtotime($date2));
		$day3n = date('F, y', strtotime($date3));
		$day4n = date('F, y', strtotime($date4));
		$fund_scrips = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
			->WHERE("fund_code",$fund_code)
			->WHERE('entry_date', $date->entry_date)
			->WHERE('category','Equity')
			->orderByRaw("qty  DESC")
			->limit(10)
			->get();
		$fund_scrips1 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
			->WHERE("fund_code",$fund_code)
			->WHERE('entry_date', $date1)
			->WHERE('category','Equity')
			->orderByRaw("qty  DESC")
			->limit(10)
			->get();
		$fund_scrips2 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
			->WHERE("fund_code",$fund_code)
			->WHERE('entry_date', $date2)
			->WHERE('category','Equity')
			->orderByRaw("qty  DESC")
			->limit(10)
			->get();
		$fund_scrips3 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
			->WHERE("fund_code",$fund_code)
			->WHERE('entry_date', $date3)
			->WHERE('category','Equity')
			->orderByRaw("qty  DESC")
			->limit(10)
			->get();
		$fund_scrips4 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
			->WHERE("fund_code",$fund_code)
			->WHERE('entry_date', $date4)
			->WHERE('category','Equity')
			->orderByRaw("qty  DESC")
			->limit(10)
			->get();
		
       return view($this->page_path . '.fund_watch.details',compact('fundMaster','fundWatch','AAUMValue','dataArr','returnLessIndex', 'scrips','total_asset', 'fund_scrips','fund_scrips1','fund_scrips2','fund_scrips3','fund_scrips4','dayn','day1n','day2n','day3n','day4n','scarrimo','crore','snm','nfm','schemenamei'));
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
			$s = $return_schemer[$val] != "9999" ? $return_schemer[$val] : 0;
			$b = $return_benchmarkr[$val] != "9999" ? $return_benchmarkr[$val] : 0;
			$result[]=[$key,$s-$b];
		}
		return json_encode($result);
	}
	public function getreturnLessRank($fund_code,$classification,$indices){ //cod rank
		try{
			$last_date =$this->Useful->get_yesterday();// IndicesDetail::getLastPublishedDate($indices);
			//print_r($last_date);
			$defaultMonths=['sixmonths'=>[6,'6 M'],'oneyear'=>[12,'1 Y'],'twoyear'=>[24,'2 Y'],'threeyear'=>[36,'3 Y'],'fiveyear'=>[60,'5 Y']];//,12,24,36,60
			$type_id=$classification;
			foreach($defaultMonths as $key=>$val){
				$date[] = SELF::get_last_month($val[0],$last_date);
			}
			//print_r($last_date);
			$data['sixmonths'] = DB::select('CALL sp_monthly_return_less_index_rank_six_new("'.$last_date.'","'.$type_id.'")');
			//dd($data['sixmonths']);
			$data['oneyear'] = DB::select('CALL sp_monthly_return_less_index_rank_one_year_new("'.$last_date.'","'.$type_id.'")');
			$data['twoyear'] = DB::select('CALL sp_monthly_return_less_index_rank_two_year_new("'.$last_date.'","'.$type_id.'")');
			$data['threeyear'] = DB::select('CALL sp_monthly_return_less_index_rank_three_year_new("'.$last_date.'","'.$type_id.'")');
			$data['fiveyear'] = DB::select('CALL sp_monthly_return_less_index_rank_five_year_new("'.$last_date.'","'.$type_id.'")');
			$i=0;
				$dataArr['sixmonths'] = DB::select('CALL sp_get_cagr_quartile_decile_new("' . date('Y-m-d', strtotime($last_date . ' - 6 months')) . '","' . $last_date . '","' . $fund_code . '","' . $type_id . '")');
				$dataArr['oneyear'] = DB::select('CALL sp_get_cagr_quartile_decile_new("'.date('Y-m-d', strtotime($last_date. ' - 1 year')).'","'.$last_date.'","'.$fund_code.'","'.$type_id.'")');
				$dataArr['twoyear'] = DB::select('CALL sp_get_cagr_quartile_decile_new("'.date('Y-m-d', strtotime($last_date. ' - 2 year')).'","'.$last_date.'","'.$fund_code.'","'.$type_id.'")');
				$dataArr['threeyear'] = DB::select('CALL sp_get_cagr_quartile_decile_new("'.date('Y-m-d', strtotime($last_date. ' - 3 year')).'","'.$last_date.'","'.$fund_code.'","'.$type_id.'")');
				$dataArr['fiveyear'] = DB::select('CALL sp_get_cagr_quartile_decile_new("'.date('Y-m-d', strtotime($last_date. ' - 5 year')).'","'.$last_date.'","'.$fund_code.'","'.$type_id.'")');
				$finalArr = [];
			//dd($data['fiveyear']);
			//die();
		}
		catch(Exception $e)
		{
		   dd($e->getMessage());
		}
		
		//return ['status'=>'success','html'=>$data];
		foreach($defaultMonths as $key=>$val){
			$sortedData =collect($data[$key])->sortBy([[$key, 'desc']]);
			//dd($sortedData);
			$rank = $sortedData->search(function($user) use($fund_code) {
							return $user->fund_code == $fund_code;
					});
			foreach($dataArr as $keyq=>$valq){
				if($key == $keyq){
					if(!empty($valq)){
						$quartile = $valq[0]->quartile;
						$decile = $valq[0]->decile;
					}else{
						$quartile = 0;
						$decile = 0;
					}
				}
			}
			
			$result[] = [
				'period'=>$val[1],
				'active_funds'=>count($data[$key]),
				'rank'=>$rank,
				'quartile'=>$quartile,
				'decile'=>$decile,
                'date'=>date('d-M-Y',strtotime($date[$i])),
				
			];
			$i++;
		}
		//dd($result);
		$html = view('web.pages.fund_watch.return_less_rank',['result'=>$result])->render();
        return ['status'=>'success','html'=>$html];
	}
	 public function get_last_month($month,$last_date)
    {
        $last_month_sd =  date('Y-m-d', strtotime("-".$month." months",strtotime($last_date)));

        return $last_month_sd;
    }
    public function getReturnContinous($fund_code){ ///cod new
		try{
		// return $fund_code;die;
        $benchMarkResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-return-benchmark?fund_code='.$fund_code))->json();
		// dd($benchMarkResponse);
        $CategoryAverageResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-performance-compare-category?fund_code='.$fund_code))->json();
		//dd($CategoryAverageResponse);
		
        $schemeResponse =Http::get(url('/api/v1/fund-return-scheme?fund_code='.$fund_code))->json();
		//dd($schemeResponse);
        $scheme =$schemeResponse['data']['return_scheme'];
		$CategoryAverage =$CategoryAverageResponse['data']['category_compare_data'];
			//dd($CategoryAverage);
		$benchMark =$benchMarkResponse['data']['return_benchmark'];	
		
		
		// dd($CategoryAverage);
		$html = view('web.pages.fund_watch.retun_continus',['scheme'=>$scheme,'category_average'=>$CategoryAverage,'category_avg'=>$CategoryAverage,'bench_mark'=>$benchMark])->render();
        return ['status'=>'success','html'=>$html];
		}
		catch(Exception $e)
		{
		   dd($e->getMessage());
		}
		
    }
	public function getReturndisContinous($fund_code){ ///cod new
		try{
        $benchMarkResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-return-benchmark?fund_code='.$fund_code))->json();
		
        $CategoryAverageResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-performance-compare-category-dis?fund_code='.$fund_code))->json();
		$CategoryAverage =$CategoryAverageResponse['data']['category_compare_data'];
		$benchMark =$benchMarkResponse['data']['return_benchmark'];	
		
		$html = view('web.pages.fund_watch.retun_discontinus',['category_average'=>$CategoryAverage,'bench_mark'=>$benchMark])->render();
        return ['status'=>'success','html'=>$html];
		}
		catch(Exception $e)
		{
		   dd($e->getMessage());
		}
		
    }
    public function getRiskAplha($fund_code){
		// dd('risk-alpha');
        $response =Http::get(url('api/v1/fund-performance-jensenalpha-beta-volatility?fund_code='.$fund_code))->json();
		// dd($response);
		$defaultYears = ['ONEYEAR', 'TWOYEAR', 'THREEYEAR'];
		$result =[];
		if($response['success']){
			$data =$response['data']['jensenalpha_beta_volatility_data'];
			//dd($data);
			foreach($defaultYears as $val){
				if($data[$val]) {
					$finacialYearStart1 =date("y",strtotime($data[$val]['end_date']));
					$finacialYearStart2 =date("y",strtotime($data[$val]['start_date']));
					$result ['H1 FY’'.$finacialYearStart2.'-'.$finacialYearStart1]=$data[$val];
				}			
									 
			}
		}
		
		//dd($result);
        $html = view('web.pages.fund_watch.risk_adjusted_alpha',['RiskAdjustedAlpha'=>$result])->render();
        return ['status'=>'success','html'=>$html];
    }
    public function breakUP($fund_code)
    {
        $lastMonthDate = $lastSavedDate =  FundComposition::getPublishReadyDate();
        $filterArray = ['Equity' => 0, 'Cash' => 0, 'Corporate Debt' => 0, 'SOV' => 0, 'Others' => 0];
        $AllBreakUP = FundComposition::where(['fund_code' => $fund_code, 'entry_date' => $lastMonthDate])->get()->toArray();
		
		//dd($AllBreakUP);

        foreach ($AllBreakUP as $key => $value) {
            if (in_array($value['category'], array_keys($filterArray))) {
                $filterArray[$value['category']] = $filterArray[$value['category']]+$value['content_per'];
            } else {
                $filterArray['Others'] = $filterArray['Others'] + $value['content_per'];
            }
        }
		
		//dd($filterArray);

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
					 $result[]=[date('m-d-Y', strtotime($FUnddata[0]['entry_date'])),$FUnddata[0]['corpus_entry']*0.01];
			}
			
         
        }
		
        return json_encode($result);
    }
    public function getLumnsubData($fund_code)
    {
        $deatultLumsumAmount = 100000;
        $defaultYears = ['ONEYEAR' => 1, 'TWOYEAR' => 2, 'THREEYEAR' => 3];
        $yesterday = $this->Useful->get_yesterday();
        //$yesterday='2022-12-16';
        $presentClosingNav =SELF::lumsumClosingNav($fund_code,$yesterday);
        $PreviewYearNavs = [];
        if (!empty($presentClosingNav)) {
            //$response = Http::get(url('api/v1/fund-return-scheme?fund_code=' . $fund_code))->json();
            //$percentege = $response['data']['return_scheme'];
            foreach ($defaultYears as $key => $val) {
                $LastYeardate = $this->Useful->getYears($val, $yesterday);
                $data = FundDetail::where("fund_code", $fund_code)->where('entry_date', $LastYeardate)->first('closing_nav');
				//dd(round($percentege[$key], 2));
				switch($val){
					case 1:
						$perc = (($presentClosingNav['closing_nav'] - $data->closing_nav)/$data->closing_nav)*100;
						break;
					default:
						if(!empty($data)){
							$perc = (pow(($presentClosingNav['closing_nav']/$data->closing_nav),(1/$val)) - 1)*100;
						}
						else{
							$perc =0;
						}
				}

                if ($data) {
                    $numberofUnits = round($deatultLumsumAmount / $data->closing_nav, 3);
					$finalamount =  $deatultLumsumAmount*pow((1+($perc/100)),$val);
					
					//dd($this->Useful->currencyFormat(round($numberofUnits * $presentClosingNav->closing_nav)));
					
                    $PreviewYearNavs[$val . ' Year'] = [
                        /*'amount' => $this->Useful->currencyFormat(round($numberofUnits * $presentClosingNav->closing_nav)),*/			
						'amount' => round($finalamount) ? round($finalamount) : "NA" ,
                        'last_date' => $LastYeardate,
                        'last_date_nav_val' => $data->closing_nav,
                        'start_date' => $yesterday,
                        'start_date_nav_val' => $presentClosingNav['closing_nav'],
                        'numer_of_units' => $numberofUnits,
                        //'percentage' => round($percentege[$key], 2),
						'percentage' =>round($perc,2) ? round($perc,2) : "NA",
                    ];
                } else {
                    $PreviewYearNavs[$val . ' Year' . $LastYeardate . $yesterday] = [];
                }
            }
            
        }
		
		//dd($PreviewYearNavs);
		
		
        $html = view('web.pages.fund_watch.lumsum',['lumbsum'=>$PreviewYearNavs])->render();
        return ['status'=>'success','html'=>$html];
    }
	  private function lumsumClosingNav($fund_code,$yesterday){
        $fundDetails = FundDetail::where("fund_code", $fund_code);
        $presentClosingNav = $fundDetails->where('entry_date', $yesterday)->first('closing_nav');
        if($presentClosingNav==null){
            $newDate =date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $yesterday) ) ));
           return  SELF::lumsumClosingNav($fund_code,$newDate);
        }
        else{
            return $presentClosingNav;
        }

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
