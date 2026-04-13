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
use Carbon\Carbon;

class NewfundwatchController extends BaseController
{
    public function __construct()
    {
        $this->defDataArr = self::getDefData();
        $this->page_path = env('PAGE_PATHS', 'web.pages');
        $this->Useful = new Useful;
    }
    public function list(Request $request){
        $query = "
            SELECT YEAR(created_at) AS creation_year, COUNT(*) AS record_count
            FROM mpx_fund_watch_new
            WHERE status = 1
            GROUP BY YEAR(created_at)
            ORDER BY creation_year
        ";


        // Execute the query with the array values bound
        $archiveData = DB::select($query);
        // dd($archiveData);

        $fundWatch = FundWatchNew::where('status','1')->orderBy('id','desc')->with('fundDetails')->get();
        // dd($fundWatch);

        $recentPosts = FundWatchNew::where('status','1')->orderBy('id', 'desc')->with('fundDetails')->limit(5)->get();
        // dd($recentPosts);
        return view('web.pages.new-fundwatch-list', compact('archiveData','fundWatch','recentPosts'));
    }
    public function index(Request $request, $fund_code)
    {
        // Uncomment the lines below to debug
        // dd($request->all());
        // dd($fund_code);

        $fund_code = base64_decode($fund_code);
        // dd($fund_code);
        $indices_name = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();
        $last_indices_date = IndicesDetail::getLastPublishedDate($indices_name->indices_name);
        $last_indices_timestamp = strtotime($last_indices_date);
        $last_indices_date_format = date('M, Y', $last_indices_timestamp);
        // Calculate the timestamps for each interval
        $timestamp_6_months_before = strtotime('-6 months', $last_indices_timestamp);
        $timestamp_odd_1_year_before = strtotime('-1 year', $timestamp_6_months_before);
        $timestamp_odd_2_year_before = strtotime('-2 year', $timestamp_odd_1_year_before);
        $timestamp_1_year_before = strtotime('-1 year', $last_indices_timestamp);
        $timestamp_2_year_before = strtotime('-2 year', $last_indices_timestamp);
        $timestamp_3_years_before = strtotime('-3 years', $last_indices_timestamp);
        $timestamp_5_years_before = strtotime('-5 years', $last_indices_timestamp);

        // Format the timestamps to 'M, Y'
        $date_6_months_before = date('M, Y', $timestamp_6_months_before);
        $date_odd_1_year_before = date('M, Y', $timestamp_odd_1_year_before);
        $date_odd_2_year_before = date('M, Y', $timestamp_odd_2_year_before);
        $date_1_year_before = date('M, Y', $timestamp_1_year_before);
        $date_2_year_before = date('M, Y', $timestamp_2_year_before);
        $date_3_years_before = date('M, Y', $timestamp_3_years_before);
        $date_5_years_before = date('M, Y', $timestamp_5_years_before);

        // Output the formatted dates
        // echo "6 Months Before: " . $date_6_months_before . "\n";
        // echo "1 Year Before: " . $date_1_year_before . "\n";
        // echo "3 Years Before: " . $date_3_years_before . "\n";
        // echo "5 Years Before: " . $date_5_years_before . "\n";
        // die;
        $return_date = $last_indices_date_format;
        $return_date_6_month = $date_6_months_before;
        // dd($return_date_6_month);
        $return_date_1 = $date_1_year_before;
        // dd($return_date_1);
        $return_date_2 = $date_2_year_before;
        $return_date_3 = $date_3_years_before;

        $return_date_5 = $date_5_years_before;

        $return_date_odd_1= $date_odd_1_year_before;
        $return_date_odd_2= $date_odd_2_year_before;

        $dataArr = PageModel::getData(self::getClassIdByModel('PageModel'), '', 31);
        $dataArr['full_url'] = $request->fullUrl();
        // dd($dataArr);

        $meta_title = $dataArr['meta_title'];
        $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
        $meta_descp = $dataArr['meta_descp'];
        $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
        // dd($dataArr);

        $fundMaster = FundMaster::where("fund_code", $fund_code)->first();
        // dd($fundWatch);
        $fund_typeid= $fundMaster->fund_type_id;
        // dd($fund_typeid);
        $allFundCodes = FundMaster::where("fund_type_id", $fund_typeid)->get();
        // dd($allFundCodes);
        $fundCodeArray = [];
        foreach($allFundCodes as $fund){
            array_push($fundCodeArray, $fund->fund_code);
        }
        // dd($fundCodeArray);
        // $archiveData = FundWatchNew::whereIn("fund_code", $fundCodeArray)->groupBy(DB::raw('YEAR(created_at)'))->get();
        $placeholders = implode(',', array_fill(0, count($fundCodeArray), '?'));

        // Build the query with parameter binding
        $query = "
            SELECT YEAR(created_at) AS creation_year, COUNT(*) AS record_count
            FROM mpx_fund_watch_new
            WHERE fund_code IN ($placeholders)
            AND status = 1
            GROUP BY YEAR(created_at)
            ORDER BY creation_year
        ";

        
        // Execute the query with the array values bound    
        $archiveData = DB::select($query, $fundCodeArray);
        // dd($archiveData);

        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
        // dd($fundWatch);

        $recentPosts = FundWatchNew::where('status','1')->orderBy('id', 'desc')->with('fundDetails')->limit(5)->get();
        // dd($recentPosts);

        for ($i = 0; $i < 4; $i++) {
            $fundnames[] = $fundMaster->fund_name;
            $schemenamei = date("jS F Y", strtotime($fundMaster->fund_opened));
        }
        $i = 0;
        $fundmanager = $fundMaster->fund_manager;

        if (strpos($fundmanager, ",") !== false) {
            $efm = explode(',', $fundmanager);
            for ($t = 0; $t < count($efm); $t++) {
                $rth = trim($efm[$t], " ");
                $scheme = FundMaster::where("fund_manager", $rth)->get();
                foreach ($scheme as $tow) {
                    if ($i <= 3) {
                        $schemename[] = $tow->fund_name;
                    }
                    $i++;
                }
            }
        } else {
            $scheme = FundMaster::where("fund_manager", $fundmanager)->get();
            foreach ($scheme as $tow) {
                if ($i <= 3) {
                    $schemename[] = $tow->fund_name;
                }
                $i++;
            }
        }

        $fund_typeid = $fundMaster->fund_type_id;
        $fundname = FundMaster::where("fund_type_id", $fund_typeid)->get();
        // dd($fundname);
        $nfm = count($fundname);
        $snm = implode(',', $schemename);
        $fmbfm = implode(',', $fundnames);
        // dd($fmbfm);
        $AAUMValue = SELF::AAUMValue($fund_code);
        // dd($AAUMValue);
        $fund_code = $fundMaster->fund_code;
        // dd($fundMaster->fund_type_id);
        $returnLessIndex = self::returnLessIndex($fund_code, $fundMaster->indices_name);
        //dd($returnLessIndex);
        $returnLessIndexRank = self::getReturnlessIndexRank($fund_code, $fundMaster->fund_type_id);
        // dd($returnLessIndexRank);

        $getRankQuartileDecile = self::getRankQuartileDecile($fund_code, $fundMaster->fund_type_id);
        // dd($getRankQuartileDecile);

        DB::select('SET SESSION group_concat_max_len = 100');
        $scrips = DB::select("SELECT count(*) as total FROM `mpx_fund_composition` WHERE `fund_code`='" . $fund_code . "'");
        $scripts_count = DB::select("SELECT scrip_name as scrip_names FROM `mpx_fund_composition` WHERE `fund_code`='" . $fund_code . "'LIMIT 5");
        foreach ($scripts_count as $sc) {
            $scarr[] = $sc->scrip_names;
        }
        $scarrimo = implode(',', $scarr);
        $total_asset = DB::select("select corpus_entry from mpx_corpus_entry where fund_code='" . $fund_code . "' order by entry_date desc limit 1");
        $crore = round($total_asset[0]->corpus_entry * 0.01, 2);
        $date = DB::table("fund_composition")->latest('entry_date')->first();
        $dateall = DB::table("fund_composition")->select('entry_date')->where("fund_code", $fund_code)->orderByRaw("entry_date  DESC")->groupBy('entry_date')->limit(12)->get();
        $date1 = "";
        $date2 = "";
        $date3 = "";
        $date4 = "";
        // foreach ($dateall as $new => $value) {
        //     if ($new = 1) $date1 = $dateall[$new]->entry_date;
        //     if ($new = 4) $date2 = $dateall[$new]->entry_date;
        //     if ($new = 7) $date3 = $dateall[$new]->entry_date;
        //     if ($new = 10) $date4 = $dateall[$new]->entry_date;
        // }
        // dd($date1);
        $dayn = date('F, y', strtotime($date->entry_date));
        // dd($dayn);
        // $day1n = date('F, y', strtotime($date1));
        // $day2n = date('F, y', strtotime($date2));
        // $day3n = date('F, y', strtotime($date3));
        // $day4n = date('F, y', strtotime($date4));
        // $dayn = strtotime($dayone);
        // dd($dayn);
        $day1n = date('F, y', strtotime('-6 months', strtotime($date->entry_date)));
        // dd($day1n);
        $date1= date('Y-m-t', strtotime('-6 months', strtotime($date->entry_date)));
        // dd($date1);

        $day2n = date('F, y', strtotime("-10 months", strtotime($date->entry_date)));

        $date2 = date('Y-m-t', strtotime("-10 months", strtotime($date->entry_date)));
        // dd($date2);
        $day3n = date('F, y', strtotime("-16 months", strtotime($date->entry_date)));
        
        $date3 = date('Y-m-t', strtotime("-16 months", strtotime($date->entry_date)));
        // dd($date3);
        $day4n = date('F, y', strtotime("-20 months", strtotime($date->entry_date)));
        // dd($day4n);
        $date4 = date('Y-m-t', strtotime("-20 months", strtotime($date->entry_date)));
        // dd($date4);
        $fund_scrips = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date->entry_date)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();
        // dd($fund_scrips);
        // dd($date1);
        $fund_scrips1 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date1)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();
        // dd($fund_scrips1);
        $fund_scrips2 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date2)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();
        $fund_scrips3 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date3)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();
        $fund_scrips4 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date4)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();

        $disclaimer = DB::select("SELECT * FROM fund_watch_disclaimer WHERE status = 1");
        // dd($disclaimer[0]->disclaimer);
        if(!empty($disclaimer)){
            $disclaimer_text = $disclaimer[0]->disclaimer;
        }else{
            $disclaimer_text = '';
        }

        return view('web.pages.new-fundwatch', compact('disclaimer_text', 'fundMaster', 'fundWatch', 'AAUMValue', 'dataArr', 'returnLessIndex', 'returnLessIndexRank', 'getRankQuartileDecile', 'archiveData', 'scrips', 'total_asset', 'fund_scrips', 'fund_scrips1', 'fund_scrips2', 'fund_scrips3', 'fund_scrips4', 'dayn', 'day1n', 'day2n', 'day3n', 'day4n', 'scarrimo', 'crore', 'snm', 'nfm', 'schemenamei','recentPosts','return_date','return_date_1', 'return_date_2','return_date_3','return_date_6_month','return_date_5', 'return_date_odd_1', 'return_date_odd_2'));
        //return response()->json(['fund_code' => $fund_code,'RiskAdjustedAlpha'=>$RiskAdjustedAlpha, 'breakup' => $PortFoliBreakup, 'AAUM' => $AAUMValue, 'lumsum' => $lumbsum, 'sip' => $sip, 'fund_comp_analysis' => $fundCompAnalysis], 200); //

    }
    public function demoindex(Request $request, $fund_code)
    {
        // Uncomment the lines below to debug
        // dd($request->all());
        // dd($fund_code);

        $fund_code = base64_decode($fund_code);
        // dd($fund_code);

        $dataArr = PageModel::getData(self::getClassIdByModel('PageModel'), '', 31);
        $dataArr['full_url'] = $request->fullUrl();
        // dd($dataArr);

        $meta_title = $dataArr['meta_title'];
        $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
        $meta_descp = $dataArr['meta_descp'];
        $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
        // dd($dataArr);

        $fundMaster = FundMaster::where("fund_code", $fund_code)->first();
        // dd($fundWatch);
        $fund_typeid= $fundMaster->fund_type_id;
        // dd($fund_typeid);
        $allFundCodes = FundMaster::where("fund_type_id", $fund_typeid)->get();
        // dd($allFundCodes);
        $fundCodeArray = [];
        foreach($allFundCodes as $fund){
            array_push($fundCodeArray, $fund->fund_code);
        }
        // dd($fundCodeArray);
        // $archiveData = FundWatchNew::whereIn("fund_code", $fundCodeArray)->groupBy(DB::raw('YEAR(created_at)'))->get();
        $placeholders = implode(',', array_fill(0, count($fundCodeArray), '?'));

        // Build the query with parameter binding
        $query = "
            SELECT YEAR(created_at) AS creation_year, COUNT(*) AS record_count
            FROM mpx_fund_watch_new
            WHERE fund_code IN ($placeholders)
            AND status = 1
            GROUP BY YEAR(created_at)
            ORDER BY creation_year
        ";

        
        // Execute the query with the array values bound    
        $archiveData = DB::select($query, $fundCodeArray);
        // dd($archiveData);

        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
        // dd($fundWatch);

        $recentPosts = FundWatchNew::where('status','1')->orderBy('id', 'desc')->with('fundDetails')->limit(5)->get();
        // dd($recentPosts);

        for ($i = 0; $i < 4; $i++) {
            $fundnames[] = $fundMaster->fund_name;
            $schemenamei = date("jS F Y", strtotime($fundMaster->fund_opened));
        }
        $i = 0;
        $fundmanager = $fundMaster->fund_manager;

        if (strpos($fundmanager, ",") !== false) {
            $efm = explode(',', $fundmanager);
            for ($t = 0; $t < count($efm); $t++) {
                $rth = trim($efm[$t], " ");
                $scheme = FundMaster::where("fund_manager", $rth)->get();
                foreach ($scheme as $tow) {
                    if ($i <= 3) {
                        $schemename[] = $tow->fund_name;
                    }
                    $i++;
                }
            }
        } else {
            $scheme = FundMaster::where("fund_manager", $fundmanager)->get();
            foreach ($scheme as $tow) {
                if ($i <= 3) {
                    $schemename[] = $tow->fund_name;
                }
                $i++;
            }
        }

        $fund_typeid = $fundMaster->fund_type_id;
        $fundname = FundMaster::where("fund_type_id", $fund_typeid)->get();
        // dd($fundname);
        $nfm = count($fundname);
        $snm = implode(',', $schemename);
        $fmbfm = implode(',', $fundnames);
        // dd($fmbfm);
        $AAUMValue = SELF::AAUMValue($fund_code);
        // dd($AAUMValue);
        $fund_code = $fundMaster->fund_code;
        // dd($fundMaster->fund_type_id);
        $returnLessIndex = self::returnLessIndex($fund_code, $fundMaster->classification);
        //dd($returnLessIndex);
        $returnLessIndexRank = self::getReturnlessIndexRank($fund_code, $fundMaster->fund_type_id);
        // dd($returnLessIndexRank);

        $getRankQuartileDecile = self::getRankQuartileDecile($fund_code, $fundMaster->fund_type_id);
        // dd($getRankQuartileDecile);

        DB::select('SET SESSION group_concat_max_len = 100');
        $scrips = DB::select("SELECT count(*) as total FROM `mpx_fund_composition` WHERE `fund_code`='" . $fund_code . "'");
        $scripts_count = DB::select("SELECT scrip_name as scrip_names FROM `mpx_fund_composition` WHERE `fund_code`='" . $fund_code . "'LIMIT 5");
        foreach ($scripts_count as $sc) {
            $scarr[] = $sc->scrip_names;
        }
        $scarrimo = implode(',', $scarr);
        $total_asset = DB::select("select corpus_entry from mpx_corpus_entry where fund_code='" . $fund_code . "' order by entry_date desc limit 1");
        $crore = round($total_asset[0]->corpus_entry * 0.01, 2);
        $date = DB::table("fund_composition")->latest('entry_date')->first();
        $dateall = DB::table("fund_composition")->select('entry_date')->where("fund_code", $fund_code)->orderByRaw("entry_date  DESC")->groupBy('entry_date')->limit(12)->get();
        $date1 = "";
        $date2 = "";
        $date3 = "";
        $date4 = "";
        foreach ($dateall as $new => $value) {
            if ($new = 1) $date1 = $dateall[$new]->entry_date;
            if ($new = 4) $date2 = $dateall[$new]->entry_date;
            if ($new = 7) $date3 = $dateall[$new]->entry_date;
            if ($new = 10) $date4 = $dateall[$new]->entry_date;
        }
        $dayn = date('F, y', strtotime($date->entry_date));
        $day1n = date('F, y', strtotime($date1));
        $day2n = date('F, y', strtotime($date2));
        $day3n = date('F, y', strtotime($date3));
        $day4n = date('F, y', strtotime($date4));
        $fund_scrips = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date->entry_date)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();
        $fund_scrips1 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date1)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();
        $fund_scrips2 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date2)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();
        $fund_scrips3 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date3)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();
        $fund_scrips4 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date4)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();

        return view('web.pages.demo-new-fundwatch', compact('fundMaster', 'fundWatch', 'AAUMValue', 'dataArr', 'returnLessIndex', 'returnLessIndexRank', 'getRankQuartileDecile', 'archiveData', 'scrips', 'total_asset', 'fund_scrips', 'fund_scrips1', 'fund_scrips2', 'fund_scrips3', 'fund_scrips4', 'dayn', 'day1n', 'day2n', 'day3n', 'day4n', 'scarrimo', 'crore', 'snm', 'nfm', 'schemenamei','recentPosts'));
        //return response()->json(['fund_code' => $fund_code,'RiskAdjustedAlpha'=>$RiskAdjustedAlpha, 'breakup' => $PortFoliBreakup, 'AAUM' => $AAUMValue, 'lumsum' => $lumbsum, 'sip' => $sip, 'fund_comp_analysis' => $fundCompAnalysis], 200); //

    }
    public function returnLessIndex($fund_code,$indices_name){
		$last_date = FundDetail::getLastPublishedDate($fund_code);
        // dd($last_date);
        $return_scheme = DB::select('CALL sp_fund_search_scheme_ret("'.$last_date.'","'.$fund_code.'")');
        // dd($return_scheme);
		$return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret("'.$last_date.'","'.$indices_name.'","'.$fund_code.'")');
        // dd('CALL sp_fund_search_benchmark_ret("'.$last_date.'","'.$indices_name.'","'.$fund_code.'")');
        // dd($return_benchmark);
		$defaultTimePeriod =['6 months'=>'SIXMONTHS','1 Year'=>'ONEYEAR','2 Year'=>'TWOYEAR','3 Year'=>'THREEYEAR','5 Year'=>'FIVEYEAR'];
		$return_schemer =(array) $return_scheme[0];
		$return_benchmarkr = (array)$return_benchmark[0];
        $result[]=['Years','Value'];
		foreach($defaultTimePeriod as $key=>$val)
		{
			$s = $return_schemer[$val] != "9999" ? $return_schemer[$val] : 0;
			$b = $return_benchmarkr[$val] != "9999" ? $return_benchmarkr[$val] : 0;
			$result[]=[$key,$s-$b];
		}
        // dd($result);
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
				$dataArr['sixmonths'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 6 months')) . '","' . $last_date . '","' . $fund_code . '","' . $type_id . '")');
				$dataArr['oneyear'] = DB::select('CALL sp_get_cagr_quartile_decile("'.date('Y-m-d', strtotime($last_date. ' - 1 year')).'","'.$last_date.'","'.$fund_code.'","'.$type_id.'")');
				$dataArr['twoyear'] = DB::select('CALL sp_get_cagr_quartile_decile("'.date('Y-m-d', strtotime($last_date. ' - 2 year')).'","'.$last_date.'","'.$fund_code.'","'.$type_id.'")');
				$dataArr['threeyear'] = DB::select('CALL sp_get_cagr_quartile_decile("'.date('Y-m-d', strtotime($last_date. ' - 3 year')).'","'.$last_date.'","'.$fund_code.'","'.$type_id.'")');
				$dataArr['fiveyear'] = DB::select('CALL sp_get_cagr_quartile_decile("'.date('Y-m-d', strtotime($last_date. ' - 5 year')).'","'.$last_date.'","'.$fund_code.'","'.$type_id.'")');
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
        $benchMarkResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-return-benchmark?fund_code='.$fund_code))->json();
		
        $CategoryAverageResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-performance-compare-category?fund_code='.$fund_code))->json();
		//dd($CategoryAverageResponse);
		
        $schemeResponse =Http::get(url('/api/v1/fund-return-scheme?fund_code='.$fund_code))->json();
		//dd($schemeResponse);
        $scheme =$schemeResponse['data']['return_scheme'];
        // dd($scheme);
		$CategoryAverage =$CategoryAverageResponse['data']['category_compare_data'];
			// dd($CategoryAverage);
		$benchMark =$benchMarkResponse['data']['return_benchmark'];	
		
		// return json_encode($schemeResponse);exit;
		
		$html = view('web.pages.fund_watch.retun_continus',['scheme'=>$scheme,'category_average'=>$CategoryAverage,'bench_mark'=>$benchMark])->render();
        return ['status'=>'success','html'=>$html];
		}
		catch(Exception $e)
		{
		   dd($e->getMessage());
		}
		
    }
	public function getReturndisContinous($fund_code){ ///cod new
        // dd($fund_code);
		try{
        $benchMarkResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-return-benchmark?fund_code='.$fund_code))->json();
		// dd($benchMarkResponse);
        $CategoryAverageResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-performance-compare-category-dis?fund_code='.$fund_code))->json();

        // $benchMarkResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-return-benchmark?fund_code='.$fund_code))->json();
		
        // $CategoryAverageResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-performance-compare-category-dis?fund_code='.$fund_code))->json();
		//dd($CategoryAverageResponse);
		
        $schemeResponse =Http::get(url('/api/v1/fund-return-scheme?fund_code='.$fund_code))->json();
		//dd($schemeResponse);
        
        // dd($CategoryAverageResponse);
        if($CategoryAverageResponse != null){
            $CategoryAverage =$CategoryAverageResponse['data']['category_compare_data'];
        }else{
            $CategoryAverage=[];
        }
        if($benchMarkResponse != null){
            $benchMark =$benchMarkResponse['data']['return_benchmark'];
        }else{
            $benchMark= [];
        }

        if($schemeResponse != null){
            $scheme =$schemeResponse['data']['return_scheme'];
        }else{
            $scheme= [];
        }
        // return $scheme;
			
		
		$html = view('web.pages.fund_watch.retun_discontinus',['category_average'=>$CategoryAverage,'bench_mark'=>$benchMark,'scheme'=>$scheme])->render();
        return ['status'=>'success','html'=>$html];
		}
		catch(Exception $e)
		{
		   dd($e->getMessage());
		}
		
    }
    public function getRiskAplha($fund_code){
        // dd($fund_code);
        // echo $fund_code;die;
        $response =Http::get(url('api/v1/fund-performance-jensenalpha-beta-volatility-new?fund_code='.$fund_code))->json();
        // dd($response);
        // print_r($response);die;
		$defaultYears = ['SIXMONTHS_1','SIXMONTHS_2', 'SIXMONTHS_3'];
		$result =[];
		if($response['success']){
			$data =$response['data']['jensenalpha_beta_volatility_data'];
			// dd($data);
			foreach($defaultYears as $val){
				if($data[$val]) {
					$finacialYearStart1 =date("M'y",strtotime($data[$val]['end_date']));
					$finacialYearStart2 =date("M'y",strtotime($data[$val]['start_date']));
					$result [$finacialYearStart2.' - '.$finacialYearStart1]=$data[$val];
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
        // dd($fund_code);
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
					 $result[]=[date('M, Y', strtotime($FUnddata[0]['entry_date'])),$FUnddata[0]['corpus_entry']*0.01];
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
    function getReturnlessIndexRank($fund_code, $fund_type_ID){
        // dd('Fund Code : '.$fund_code." Fund Type ID: ".$fund_type_ID);
        $last_date = FundDetail::getLastPublishedDate($fund_code);
        // dd($last_date);
        //getting each funds returns....
        $allFunds = FundMaster::where('fund_type_id', $fund_type_ID)->get();
        // dd($allFunds);
        $six_months_rank_array =[];
        $one_year_rank_array =[];
        $two_years_rank_array =[];
        $three_years_rank_array =[];
        $five_years_rank_array =[];
        $selected_fund_return_array =[];
        foreach($allFunds as $fund){
            $selected_fund_code = $fund->fund_code;
            $return_scheme = DB::select('CALL sp_fund_search_scheme_ret("'.$last_date.'","'.$selected_fund_code.'")');
            $return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret("'.$last_date.'","'.$fund->indices_name.'","'.$selected_fund_code.'")');
            // dd($return_scheme);
            // dd($return_scheme[0]->SIXMONTHS);
            // dd($return_benchmark);
            //sixmonths
            if($return_scheme[0]->SIXMONTHS==9999.0){
                $return_scheme[0]->SIXMONTHS=0;
            }
            if($return_benchmark[0]->SIXMONTHS==9999.0){
                $return_benchmark[0]->SIXMONTHS=0;
            }
            
            array_push($six_months_rank_array, ($return_scheme[0]->SIXMONTHS-$return_benchmark[0]->SIXMONTHS));
            // dd($six_months_rank_array);
            //one year
            if($return_scheme[0]->ONEYEAR==9999.0){
                $return_scheme[0]->ONEYEAR=0;
            }
            if($return_benchmark[0]->ONEYEAR==9999.0){
                $return_benchmark[0]->ONEYEAR=0;
            }
            
            array_push($one_year_rank_array, ($return_scheme[0]->ONEYEAR-$return_benchmark[0]->ONEYEAR));
            // dd($one_year_rank_array);
            //two year
            if($return_scheme[0]->TWOYEAR==9999.0){
                $return_scheme[0]->TWOYEAR=0;
            }
            if($return_benchmark[0]->TWOYEAR==9999.0){
                $return_benchmark[0]->TWOYEAR=0;
            }
            
            array_push($two_years_rank_array, ($return_scheme[0]->TWOYEAR-$return_benchmark[0]->TWOYEAR));
            // dd($two_years_rank_array);
            //three year
            if($return_scheme[0]->THREEYEAR==9999.0){
                $return_scheme[0]->THREEYEAR=0;
            }
            if($return_benchmark[0]->THREEYEAR==9999.0){
                $return_benchmark[0]->THREEYEAR=0;
            }
            
            array_push($three_years_rank_array, ($return_scheme[0]->THREEYEAR-$return_benchmark[0]->THREEYEAR));
            // dd($three_years_rank_array);
            //five year
            if($return_scheme[0]->FIVEYEAR==9999.0){
                $return_scheme[0]->FIVEYEAR=0;
            }
            if($return_benchmark[0]->FIVEYEAR==9999.0){
                $return_benchmark[0]->FIVEYEAR=0;
            }
            
            array_push($five_years_rank_array, ($return_scheme[0]->FIVEYEAR-$return_benchmark[0]->FIVEYEAR));
            // dd($five_years_rank_array[0]);
            if($selected_fund_code == $fund_code){
                $selected_fund_return_array[0]['SIXMONTHS'] = $return_scheme[0]->SIXMONTHS-$return_benchmark[0]->SIXMONTHS;
                $selected_fund_return_array[0]['ONEYEAR'] = $return_scheme[0]->ONEYEAR-$return_benchmark[0]->ONEYEAR;
                $selected_fund_return_array[0]['TWOYEAR'] = $return_scheme[0]->TWOYEAR-$return_benchmark[0]->TWOYEAR;
                $selected_fund_return_array[0]['THREEYEAR'] = $return_scheme[0]->THREEYEAR-$return_benchmark[0]->THREEYEAR;
                $selected_fund_return_array[0]['FIVEYEAR'] = $return_scheme[0]->FIVEYEAR-$return_benchmark[0]->FIVEYEAR;
                $selected_fund_return = $selected_fund_return_array;
                // dd($selected_fund_return);
            }

        }
        // dd($selected_fund_return);
        // dd($six_months_rank_array);
        // dd($five_years_rank_array);
        //Rank calculation begins here...
        // dd($selected_fund_return[0]->SIXMONTHS);
        $val_six_month= $selected_fund_return_array[0]['SIXMONTHS'];
        $val_one_year= $selected_fund_return_array[0]['ONEYEAR'];
        $val_two_year= $selected_fund_return_array[0]['TWOYEAR'];
        $val_three_year= $selected_fund_return_array[0]['THREEYEAR'];
        $val_five_year= $selected_fund_return_array[0]['FIVEYEAR'];
        // dd($six_months_rank_array);
        $six_months_rank = self::findRank($six_months_rank_array, $val_six_month);
        // dd($six_months_rank);
        $one_year_rank = self::findRank($one_year_rank_array, $val_one_year);
        $two_years_rank = self::findRank($two_years_rank_array, $val_two_year);
        $three_years_rank = self::findRank($three_years_rank_array, $val_three_year);
        $five_years_rank = self::findRank($five_years_rank_array, $val_five_year);

        //sending the rank as the charts data
        $response_array = array('6 months'=>$six_months_rank,'1 year'=>$one_year_rank, '2 years'=> $two_years_rank, '3 years'=>$three_years_rank, '5 years'=> $five_years_rank);
        // dd($response_array);
        return json_encode($response_array);
    }
    // function getQuartile($fund_code, $fund_type_ID){
    //     $last_date = FundDetail::getLastPublishedDate($fund_code);
    //     // Convert the last date string to a timestamp
    //     $last_date_timestamp = strtotime($last_date);
    //     // Calculate the timestamp for 6 months before the last date
    //     $six_months_before_timestamp = strtotime('-6 months', $last_date_timestamp);
    //     // Convert the timestamp back to a date string in Y-m-d format
    //     $six_month_before_date = date('Y-m-d', $six_months_before_timestamp);
    //     // dd($six_months_before_date);
    //     $one_year_before_timestamp = strtotime('-1 year', $last_date_timestamp);
    //     $two_years_before_timestamp = strtotime('-2 years', $last_date_timestamp);
    //     $three_years_before_timestamp = strtotime('-3 years', $last_date_timestamp);
    //     $five_years_before_timestamp = strtotime('-5 years', $last_date_timestamp);

    //     $one_year_before_date = date('Y-m-d', $one_year_before_timestamp);
    //     $two_years_before_date = date('Y-m-d', $two_years_before_timestamp);
    //     $three_years_before_date = date('Y-m-d', $three_years_before_timestamp);
    //     $five_years_before_date = date('Y-m-d', $five_years_before_timestamp);
    //     //six month...
    //     $six_months_quartile = DB::select('CALL sp_get_cagr_quartile_decile_new("'.$six_month_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
    //     // dd($quartile);
    //     $six_months_quartile = $six_months_quartile[0]->quartile;
    //     // dd($quartile);
    // }
    function getQuartile($fund_code, $fund_type_ID){
        $last_date = FundDetail::getLastPublishedDate($fund_code);
        // Convert the last date string to a timestamp
        $last_date_timestamp = strtotime($last_date);
        // Calculate the timestamp for 6 months before the last date
        $six_months_before_timestamp = strtotime('-6 months', $last_date_timestamp);
        // Convert the timestamp back to a date string in Y-m-d format
        $six_month_before_date = date('Y-m-d', $six_months_before_timestamp);
        // dd($six_months_before_date);
        $one_year_before_timestamp = strtotime('-1 year', $last_date_timestamp);
        $two_years_before_timestamp = strtotime('-2 years', $last_date_timestamp);
        $three_years_before_timestamp = strtotime('-3 years', $last_date_timestamp);
        $five_years_before_timestamp = strtotime('-5 years', $last_date_timestamp);
    
        $one_year_before_date = date('Y-m-d', $one_year_before_timestamp);
        // dd($one_year_before_date);
        $two_years_before_date = date('Y-m-d', $two_years_before_timestamp);
        $three_years_before_date = date('Y-m-d', $three_years_before_timestamp);
        $five_years_before_date = date('Y-m-d', $five_years_before_timestamp);
        
        // Retrieve quartiles for each time span
        // dd('CALL sp_get_cagr_quartile_decile_new("'.$six_month_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        $six_months_quartile = DB::select('CALL sp_get_cagr_quartile_decile("'.$six_month_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($six_months_quartile)){
            $sixMonths_cagr = $six_months_quartile[0]->cagr_value;
            $six_months_quartile = self::getOnlyQuartile($sixMonths_cagr, $six_month_before_date, $last_date, $fund_type_ID);
        }else{
            $six_months_quartile = [];
        }
        $one_year_quartile = DB::select('CALL sp_get_cagr_quartile_decile("'.$one_year_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($one_year_quartile)){
            $one_year_cagr = $one_year_quartile[0]->cagr_value;
            $one_year_quartile = self::getOnlyQuartile($one_year_cagr, $one_year_before_date, $last_date, $fund_type_ID);
        }else{
            $one_year_quartile = [];
        }
        $two_years_quartile = DB::select('CALL sp_get_cagr_quartile_decile("'.$two_years_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($two_years_quartile)){
            $two_years_cagr = $two_years_quartile[0]->cagr_value;
            $two_years_quartile = self::getOnlyQuartile($two_years_cagr, $two_years_before_date, $last_date, $fund_type_ID);
        }else{
            $two_years_quartile = [];
        }
        $three_years_quartile = DB::select('CALL sp_get_cagr_quartile_decile("'.$three_years_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($three_years_quartile)){
            $three_years_cagr = $three_years_quartile[0]->cagr_value;
            $three_years_quartile = self::getOnlyQuartile($three_years_cagr, $three_years_before_date, $last_date, $fund_type_ID);
        }else{
            $three_years_quartile = [];
        }
        $five_years_quartile = DB::select('CALL sp_get_cagr_quartile_decile("'.$five_years_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($five_years_quartile)){
            $five_years_cagr = $five_years_quartile[0]->cagr_value;
            $five_years_quartile = self::getOnlyQuartile($five_years_cagr, $five_years_before_date, $last_date, $fund_type_ID);
        }else{
            $five_years_quartile = [];
        }
        // Extract quartile values
        $six_months_quartile = !empty($six_months_quartile)?$six_months_quartile[0]->quartile:0;
        $one_year_quartile = !empty($one_year_quartile)?$one_year_quartile[0]->quartile:0;
        $two_years_quartile = !empty($two_years_quartile)?$two_years_quartile[0]->quartile:0;
        $three_years_quartile = !empty($three_years_quartile)?$three_years_quartile[0]->quartile:0;
        $five_years_quartile = !empty($five_years_quartile)?$five_years_quartile[0]->quartile:0;
    
        // Return quartiles for all time spans
        $response_array = array('6 months'=>$six_months_quartile,'1 year'=>$one_year_quartile, '2 years'=> $two_years_quartile, '3 years'=>$three_years_quartile, '5 years'=> $five_years_quartile);
        // dd($response_array);
        return json_encode($response_array);
    }
    function getDecile($fund_code, $fund_type_ID){
        $last_date = FundDetail::getLastPublishedDate($fund_code);
        // Convert the last date string to a timestamp
        $last_date_timestamp = strtotime($last_date);
        // Calculate the timestamp for 6 months before the last date
        $six_months_before_timestamp = strtotime('-6 months', $last_date_timestamp);
        // Convert the timestamp back to a date string in Y-m-d format
        $six_month_before_date = date('Y-m-d', $six_months_before_timestamp);
        // dd($six_months_before_date);
        $one_year_before_timestamp = strtotime('-1 year', $last_date_timestamp);
        $two_years_before_timestamp = strtotime('-2 years', $last_date_timestamp);
        $three_years_before_timestamp = strtotime('-3 years', $last_date_timestamp);
        $five_years_before_timestamp = strtotime('-5 years', $last_date_timestamp);
    
        $one_year_before_date = date('Y-m-d', $one_year_before_timestamp);
        // dd($one_year_before_date);
        $two_years_before_date = date('Y-m-d', $two_years_before_timestamp);
        $three_years_before_date = date('Y-m-d', $three_years_before_timestamp);
        $five_years_before_date = date('Y-m-d', $five_years_before_timestamp);
        
        // Retrieve quartiles for each time span
        $six_months_decile = DB::select('CALL sp_get_cagr_quartile_decile("'.$six_month_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        // dd('CALL sp_get_cagr_quartile_decile("'.$six_month_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($six_months_decile)){
            $sixMonths_cagr = $six_months_decile[0]->cagr_value;
            $six_months_decile = self::getOnlyDecile($sixMonths_cagr, $six_month_before_date, $last_date, $fund_type_ID);
        }else{
            $six_months_decile = [];
        }
        $one_year_decile = DB::select('CALL sp_get_cagr_quartile_decile("'.$one_year_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($one_year_decile)){
            $one_year_cagr = $one_year_decile[0]->cagr_value;
            $one_year_decile = self::getOnlyDecile($one_year_cagr, $one_year_before_date, $last_date, $fund_type_ID);
        }else{
            $one_year_decile = [];
        }
        $two_years_decile = DB::select('CALL sp_get_cagr_quartile_decile("'.$two_years_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($two_years_decile)){
            $two_years_cagr = $two_years_decile[0]->cagr_value;
            $two_years_decile = self::getOnlyDecile($two_years_cagr, $two_years_before_date, $last_date, $fund_type_ID);
        }else{
            $two_years_decile = [];
        }
        $three_years_decile = DB::select('CALL sp_get_cagr_quartile_decile("'.$three_years_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($three_years_decile)){
            $three_years_cagr = $three_years_decile[0]->cagr_value;
            $three_years_decile = self::getOnlyDecile($three_years_cagr, $three_years_before_date, $last_date, $fund_type_ID);
        }else{
            $three_years_decile = [];
        }
        $five_years_decile = DB::select('CALL sp_get_cagr_quartile_decile("'.$five_years_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if(!empty($five_years_decile)){
            $five_years_cagr = $five_years_decile[0]->cagr_value;
            $five_years_decile = self::getOnlyDecile($five_years_cagr, $five_years_before_date, $last_date, $fund_type_ID);
        }else{
            $five_years_decile = [];
        }
        // Extract quartile values
        $six_months_decile = !empty($six_months_decile)?$six_months_decile[0]->decile:0;
        $one_year_decile = !empty($one_year_decile)?$one_year_decile[0]->decile:0;
        $two_years_decile = !empty($two_years_decile)?$two_years_decile[0]->decile:0;
        $three_years_decile = !empty($three_years_decile)?$three_years_decile[0]->decile:0;
        $five_years_decile = !empty($five_years_decile)?$five_years_decile[0]->decile:0;
    
        // Return quartiles for all time spans
        $response_array = array('6 months'=>$six_months_decile,'1 year'=>$one_year_decile, '2 years'=> $two_years_decile, '3 years'=>$three_years_decile, '5 years'=> $five_years_decile);
        // dd($response_array);
        return json_encode($response_array);
    }    
    function findRank($array, $number) {
        // Sort the array in ascending order
        rsort($array);
        
        // Find the index of the number in the sorted array
        $index = array_search($number, $array);
        
        // If the number is not found, return false
        if ($index === false) {
            return false;
        }
        
        // Add 1 to the index to get the rank (since array indexes are zero-based)
        if(($index + 1) > 10){
            return 10;
        }else{
            return $index + 1;
        }
    }
    // function getRankQuartileDecile($fund_code, $fund_type_ID){
    //     $rank = self::getReturnlessIndexRank($fund_code, $fund_type_ID);
    //     $quartile = self::getQuartile($fund_code, $fund_type_ID);
    //     $decile = self::getDecile($fund_code, $fund_type_ID);
    //     // dd($rank);
    //     // dd($quartile);
    //     // dd($decile);
    //     // $data = compact($rank, $quartile, $decile);
    //     return json_encode($data);
    // }

    function getRankQuartileDecile($fund_code, $fund_type_ID){
        $rank = json_decode(self::getReturnlessIndexRank($fund_code, $fund_type_ID));
        // dd($rank);
        $quartile = json_decode(self::getQuartile($fund_code, $fund_type_ID));
        $decile = json_decode(self::getDecile($fund_code, $fund_type_ID));
        
        // Merge arrays
        $mergedData = [];
        foreach ($rank as $timeSpan => $rankValue) {
            $mergedData[$timeSpan] = [
                'rank' => $rankValue,
                'quartile' => $quartile->$timeSpan,
                'decile' => $decile->$timeSpan
            ];
        }
    
        return json_encode($mergedData);
    }
    function getOnlyQuartile($cagr_value, $start_date, $end_date, $fund_type_id){
        $quartile = DB::select('CALL sp_calculate_quartile("'.$start_date.'","'.$end_date.'","'.$fund_type_id.'","'.$cagr_value.'")');
        return $quartile;
    }
    function getOnlyDecile($cagr_value, $start_date, $end_date, $fund_type_id){
        $decile = DB::select('CALL sp_calculate_decile("'.$start_date.'","'.$end_date.'","'.$fund_type_id.'","'.$cagr_value.'")');
        return $decile;
    }
    
}
