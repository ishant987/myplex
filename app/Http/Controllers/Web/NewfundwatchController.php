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
    public function list(Request $request, $reqYear = 0)
    {

        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        //dd($dataArr);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $query = "
                SELECT YEAR(published_date) AS creation_year, COUNT(*) AS record_count
                FROM mpx_fund_watch_new
                WHERE status = 1
                GROUP BY YEAR(published_date)
                ORDER BY creation_year
            ";

            // Execute the query with the array values bound
            $archiveData = DB::select($query);
            // dd($archiveData);
            //dd($reqYear);
            if ($reqYear > 0) {
                $fundWatch = FundWatchNew::where('status', '1')->where(DB::raw('YEAR(published_date)'), '=', $reqYear)->orderBy('id', 'desc')->with('fundDetails')->get();
            } else {
                $fundWatch = FundWatchNew::where('status', '1')->orderBy('id', 'desc')->with('fundDetails')->get();
            }

            // dd($fundWatch);

            $recentPosts = FundWatchNew::where('status', '1')->orderBy('id', 'desc')->with('fundDetails')->limit(5)->get();
            // dd($recentPosts);
            return view('web.pages.new-fundwatch-list', compact('dataArr', 'archiveData', 'fundWatch', 'recentPosts', 'reqYear'));
        }
        return abort(404);
    }
    
    public function index_11032025(Request $request, $fund_code)
    {
        // Uncomment the lines below to debug
        // dd($request->all());
        // dd($fund_code);
        
        
        $fund_code = base64_decode($fund_code);
        //$lastPublishedDate = FundDetail::getLastPublishedDate($fund_code);
        
        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
        $updated_at = date('Y-m-d',strtotime($fundWatch->updated_at));
        $last_date = FundDetail::select('entry_date')->where('fund_code', $fund_code)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first()->entry_date;
        $lastPublishedDate = $last_date;
        //dd($getLastPublishedDate);
        // dd($fund_code);
        $indices_name = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();

        $last_indices_date = IndicesDetail::select('entry_date')->where('name', $indices_name->indices_name)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->orderBy('idcd_id', 'desc')->first();

        //dd($last_indices_date);
        $last_indices_timestamp = strtotime($last_indices_date->entry_date);
        $last_indices_date_format = date("M'y", $last_indices_timestamp);
        // Calculate the timestamps for each interval
        $timestamp_6_months_before = strtotime('-6 months', $last_indices_timestamp);
        $timestamp_odd_1_year_before = strtotime('-1 year', $timestamp_6_months_before);
        $timestamp_odd_2_year_before = strtotime('-2 year', $timestamp_odd_1_year_before);
        $timestamp_1_year_before = strtotime('-1 year', $last_indices_timestamp);
        $timestamp_2_year_before = strtotime('-2 year', $last_indices_timestamp);
        $timestamp_3_years_before = strtotime('-3 years', $last_indices_timestamp);
        $timestamp_5_years_before = strtotime('-5 years', $last_indices_timestamp);

        // Format the timestamps to 'M, Y'
        $date_6_months_before = date("M'y", $timestamp_6_months_before);
        $date_odd_1_year_before = date("M'y", $timestamp_odd_1_year_before);
        $date_odd_2_year_before = date("M'y", $timestamp_odd_2_year_before);
        $date_1_year_before = date("M'y", $timestamp_1_year_before);
        $date_2_year_before = date("M'y", $timestamp_2_year_before);
        $date_3_years_before = date("M'y", $timestamp_3_years_before);
        $date_5_years_before = date("M'y", $timestamp_5_years_before);


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

        $return_date_odd_1 = $date_odd_1_year_before;
        $return_date_odd_2 = $date_odd_2_year_before;

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
        $fund_typeid = $fundMaster->fund_type_id;
        // dd($fund_typeid);
        $allFundCodes = FundMaster::where("fund_type_id", $fund_typeid)->get();
        // dd($allFundCodes);
        $fundCodeArray = [];
        foreach ($allFundCodes as $fund) {
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


        $recentPosts = FundWatchNew::where('status', '1')->orderBy('id', 'desc')->with('fundDetails')->limit(5)->get();
        // dd($recentPosts);

        $disclaimer = DB::select("SELECT * FROM fund_watch_disclaimer WHERE status = 1");
        // dd($disclaimer[0]->disclaimer);
        if (!empty($disclaimer)) {
            $disclaimer_text = $disclaimer[0]->disclaimer;
        } else {
            $disclaimer_text = '';
        }

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
        $total_asset = DB::select("select corpus_entry,entry_date from mpx_corpus_entry where fund_code='" . $fund_code . "' order by entry_date desc limit 1");
        $crore = round($total_asset[0]->corpus_entry * 0.01, 2);

        //dd($AAUMValue);

       
        $date = DB::table("fund_composition")->latest('entry_date')->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->first();
        $dateall = DB::table("fund_composition")->select('entry_date')->where("fund_code", $fund_code)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->orderByRaw("entry_date  DESC")->groupBy('entry_date')->limit(12)->get();
        $date1 = "";
        $date2 = "";
        $date3 = "";
        $date4 = "";
        $dayn = date("F'y", strtotime($date->entry_date));
        $day1n = date("F'y", strtotime('-6 months', strtotime($date->entry_date)));
        $date1 = date('Y-m-t', strtotime('-6 months', strtotime($date->entry_date)));
        $day2n = date("F'y", strtotime("-12 months", strtotime($date->entry_date)));
        $date2 = date('Y-m-t', strtotime("-12 months", strtotime($date->entry_date))); 
        $day3n = date("F'y", strtotime("-18 months", strtotime($date->entry_date)));
        $date3 = date('Y-m-t', strtotime("-18 months", strtotime($date->entry_date)));
        $day4n = date("F'y", strtotime("-24 months", strtotime($date->entry_date)));
        $date4 = date('Y-m-t', strtotime("-24 months", strtotime($date->entry_date)));

        $fund_scrips = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code '))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date->entry_date)
            ->WHERE('category', 'Equity')
            ->orderByRaw("qty  DESC")
            ->limit(10)
            ->get();
            
        $all_fund_scripts=DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name,entry_date,fund_code '))
        ->WHERE("fund_code", $fund_code)
        ->WHERE('entry_date', $date->entry_date)
        ->WHERE('category', 'Equity')
        ->orderByRaw("qty  DESC")
        ->limit(10)
        ->get()
        ->pluck('scrip_name')
        ->toArray();
        //echo '<pre>';
        foreach($fund_scrips as $kfs=>$fund_scrip){

            $fund_scrips1 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date1)
            ->WHERE('category', 'Equity')
            ->where('scrip_name', $fund_scrip->scrip_name)
            ->first(); 
            $fund_scrips2 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date2)
            ->WHERE('category', 'Equity')
            ->where('scrip_name', $fund_scrip->scrip_name)
            ->first(); 
            $fund_scrips3 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date3)
            ->WHERE('category', 'Equity')
            ->where('scrip_name', $fund_scrip->scrip_name)
            ->first(); 
            $fund_scrips4 = DB::table("fund_composition")->select(DB::raw('content_per as qty,scrip_name'))
            ->WHERE("fund_code", $fund_code)
            ->WHERE('entry_date', $date4)
            ->WHERE('category', 'Equity')
            ->where('scrip_name', $fund_scrip->scrip_name)
            ->first(); 

            //print_r($fund_scrips1);

            $fund_scrips[$kfs]->qty= !empty($fund_scrip->qty)?number_format($fund_scrip->qty,2):'';
            $fund_scrips[$kfs]->qty1= !empty($fund_scrips1->qty)?number_format($fund_scrips1->qty,2):'';
            $fund_scrips[$kfs]->qty2= !empty($fund_scrips2->qty)?number_format($fund_scrips2->qty,2):'';
            $fund_scrips[$kfs]->qty3= !empty($fund_scrips3->qty)?number_format($fund_scrips3->qty,2):'';
            $fund_scrips[$kfs]->qty4= !empty($fund_scrips4->qty)?number_format($fund_scrips4->qty,2):'';
        }
        //dd($fund_scrips);

        // return continious
        $return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret_new("' . $last_indices_date->entry_date . '","' . $indices_name->indices_name . '","' .  $fund_code . '")');           
        //dd($last_indices_date->entry_date);
        //dd($return_benchmark);
        $CategoryAverageResponse = Http::get(url('/api/v1/fund-performance-compare-category2?fund_code=' . $fund_code))->json();
        $schemeResponse = Http::get(url('/api/v1/fund-return-scheme?fund_code=' . $fund_code))->json();
        $scheme = $schemeResponse['data']['return_scheme'];
        $CategoryAverage = $CategoryAverageResponse['data']['category_compare_data'];
        $benchMark = !empty($return_benchmark)?(array)$return_benchmark[0]:[]; 
        $returnContinious['bench_mark']=$benchMark;
        $returnContinious['category_average']=$CategoryAverage;
        $returnContinious['scheme']=$scheme;


        //dd($return_benchmark);

        // quartile decile        
        $sp_quick_return_ration_new = DB::select('CALL sp_quick_return_ration_new2("' . $lastPublishedDate . '",' . $fund_typeid . ')');
        //dd($sp_quick_return_ration_new);
        foreach ($sp_quick_return_ration_new as $fundId => $fundValue) {

            //dd($fundValue);
            $seven_days = '7DAYS';
            $thirty_days = '30DAYS';
            $ninety_days = '90DAYS';
            $sixmonths = 'sixmonths';
            $oneyear = 'oneyear';
            $twoyear = 'twoyear';
            $threeyear = 'threeyear';
            $fiveyear = 'fiveyear';

            if($fundValue->$seven_days!='N/A'){
                $seven_days_fund_returns[$fundValue->fund_id] = $fundValue->$seven_days;
            }
            if ($fundValue->$thirty_days != 'N/A') {
                $thirty_days_fund_returns[$fundValue->fund_id] = $fundValue->$thirty_days;
            }
            if ($fundValue->$ninety_days != 'N/A') {
                $ninety_days_fund_returns[$fundValue->fund_id] = $fundValue->$ninety_days;
            }
            if ($fundValue->$sixmonths != 'N/A') {
                $sixmonths_fund_returns[$fundValue->fund_id] = $fundValue->$sixmonths;
            }
            if ($fundValue->$oneyear != 'N/A') {
                $oneyear_fund_returns[$fundValue->fund_id] = $fundValue->$oneyear;
            }
            if ($fundValue->$twoyear != 'N/A') {
                $twoyear_fund_returns[$fundValue->fund_id] = $fundValue->$twoyear;
            }
            if ($fundValue->$threeyear != 'N/A') {
                $threeyear_fund_returns[$fundValue->fund_id] = $fundValue->$threeyear;
            }
            if ($fundValue->$fiveyear != 'N/A') {
                $fiveyear_fund_returns[$fundValue->fund_id] = $fundValue->$fiveyear;
            }

            //dd($fundValue->$sevenDAYS);
        }
        
        $getRankQuartile[] = ['Time', 'Quartile'];
        $getRankDecile[] = ['Time', 'Decile'];
        if (!empty($sixmonths_fund_returns[$fundMaster->fund_id])) {
            $decile = self::decile_calc($sixmonths_fund_returns, $fundMaster->fund_id);
            $quartile = self::quartile_calc($sixmonths_fund_returns, $fundMaster->fund_id);
            //dd($decile);
            $getRankQuartile[] = ['6 Months', $quartile];
            $getRankDecile[] = ['6 Months', $decile];
        }
        if (!empty($oneyear_fund_returns[$fundMaster->fund_id])) {
            $decile = self::decile_calc($oneyear_fund_returns, $fundMaster->fund_id);
            $quartile = self::quartile_calc($oneyear_fund_returns, $fundMaster->fund_id);
            //dd($decile);
            $getRankQuartile[] = ['1 year', $quartile];
            $getRankDecile[] = ['1 year',  $decile];
        }
        if (!empty($twoyear_fund_returns[$fundMaster->fund_id])) {
            $decile = self::decile_calc($twoyear_fund_returns, $fundMaster->fund_id);
            $quartile = self::quartile_calc($twoyear_fund_returns, $fundMaster->fund_id);
            //dd($decile);
            $getRankQuartile[] = ['2 year', $quartile];
            $getRankDecile[] = ['2 year',  $decile];
        }
        if (!empty($threeyear_fund_returns[$fundMaster->fund_id])) {
            $decile = self::decile_calc($threeyear_fund_returns, $fundMaster->fund_id);
            $quartile = self::quartile_calc($threeyear_fund_returns, $fundMaster->fund_id);
            //dd($decile);
            $getRankQuartile[] = ['3 year', $quartile];
            $getRankDecile[] = ['3 year',  $decile];
        }
        if (!empty($fiveyear_fund_returns[$fundMaster->fund_id])) {
            $decile = self::decile_calc($fiveyear_fund_returns, $fundMaster->fund_id);
            $quartile = self::quartile_calc($fiveyear_fund_returns, $fundMaster->fund_id);
            //dd($decile);
            $getRankQuartile[] = ['5 year', $quartile];
            $getRankDecile[] = ['5 year',  $decile];
        }
        $getRankQuartile = json_encode($getRankQuartile);
        $getRankDecile = json_encode($getRankDecile);
        //dd($getRankQuartile);
        $returnLessIndex = self::returnLessIndex($fund_code, $fundMaster->indices_name);
        //dd($returnLessIndex);
        $returnLessIndexRank = self::getReturnlessIndexRank($fund_code, $fundMaster->fund_type_id);
        //  dd($returnLessIndexRank);


        // top industries
        $total_corpus_entry = DB::table('corpus_entry')
            ->where('fund_code', $fund_code)
            ->where('entry_date', $date->entry_date)
            ->select(
                DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
            )->first()->total_corpus_entry;
        $top_industries = DB::table('view_corpus_with_allocation')
            ->where('fund_code', $fund_code)
            ->where('corpus_entry_date', $date->entry_date)
            ->where('composition_entry_date', $date->entry_date)
            ->where('category', 'Equity')
            ->select(
                'industry',
                'category',
                'fund_code',
                DB::raw($total_corpus_entry . ' as AUM'),
                DB::raw('SUM(content_per) as allocation'),
                // DB::raw('SUM(content_per/100) as allocation'),
                DB::raw('SUM(calculated_amount/100) as amount'),
                DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
            )
            ->orderBy('content_per', 'desc')
            ->groupBy('industry')
            ->limit(10)
            ->get();

        //dd($top_industries);
        return view('web.pages.new-fundwatch2', compact('dataArr','disclaimer_text', 'fundMaster', 'fundWatch', 'schemenamei','snm','total_asset', 'return_date', 'return_date_1', 'return_date_2', 'return_date_3', 'return_date_6_month', 'return_date_5', 'return_date_odd_1', 'return_date_odd_2','archiveData','recentPosts','AAUMValue','returnLessIndex', 'fund_scrips', 'dayn', 'day1n', 'day2n', 'day3n', 'day4n','returnContinious','getRankQuartile','getRankDecile','returnLessIndexRank','top_industries' ));
        //return response()->json(['fund_code' => $fund_code,'RiskAdjustedAlpha'=>$RiskAdjustedAlpha, 'breakup' => $PortFoliBreakup, 'AAUM' => $AAUMValue, 'lumsum' => $lumbsum, 'sip' => $sip, 'fund_comp_analysis' => $fundCompAnalysis], 200); //

    }
    public function index(Request $request, $fund_code)
    {
        // Uncomment the lines below to debug
        // dd($request->all());
        // dd($fund_code);
        
        
        $fund_code = base64_decode($fund_code);
        //$lastPublishedDate = FundDetail::getLastPublishedDate($fund_code);
        
        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
        $updated_at = date('Y-m-d',strtotime($fundWatch->published_date));
        $fund_watch_id = $fundWatch->id;

        $last_date = FundDetail::select('entry_date')->where('fund_code', $fund_code)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first()->entry_date;
        $lastPublishedDate = $last_date;
        //dd($getLastPublishedDate);
        // dd($fund_code);
        $indices_name = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();

        $last_indices_date = IndicesDetail::select('entry_date')->where('name', $indices_name->indices_name)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->orderBy('idcd_id', 'desc')->first();

        //dd($last_indices_date);
        $last_indices_timestamp = strtotime($last_indices_date->entry_date);
        $last_indices_date_format = date("M'y", $last_indices_timestamp);
        // Calculate the timestamps for each interval
        $timestamp_6_months_before = strtotime('-6 months', $last_indices_timestamp);
        $timestamp_odd_1_year_before = strtotime('-1 year', $timestamp_6_months_before);
        $timestamp_odd_2_year_before = strtotime('-2 year', $timestamp_odd_1_year_before);
        $timestamp_1_year_before = strtotime('-1 year', $last_indices_timestamp);
        $timestamp_2_year_before = strtotime('-2 year', $last_indices_timestamp);
        $timestamp_3_years_before = strtotime('-3 years', $last_indices_timestamp);
        $timestamp_5_years_before = strtotime('-5 years', $last_indices_timestamp);

        // Format the timestamps to 'M, Y'
        $date_6_months_before = date("M'y", $timestamp_6_months_before);
        $date_odd_1_year_before = date("M'y", $timestamp_odd_1_year_before);
        $date_odd_2_year_before = date("M'y", $timestamp_odd_2_year_before);
        $date_1_year_before = date("M'y", $timestamp_1_year_before);
        $date_2_year_before = date("M'y", $timestamp_2_year_before);
        $date_3_years_before = date("M'y", $timestamp_3_years_before);
        $date_5_years_before = date("M'y", $timestamp_5_years_before);


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

        $return_date_odd_1 = $date_odd_1_year_before;
        $return_date_odd_2 = $date_odd_2_year_before;

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
        $fund_typeid = $fundMaster->fund_type_id;
        // dd($fund_typeid);
        $allFundCodes = FundMaster::where("fund_type_id", $fund_typeid)->get();
        // dd($allFundCodes);
        $fundCodeArray = [];
        foreach ($allFundCodes as $fund) {
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


        $recentPosts = FundWatchNew::where('status', '1')->orderBy('id', 'desc')->with('fundDetails')->limit(5)->get();
        // dd($recentPosts);

        $disclaimer = DB::select("SELECT * FROM fund_watch_disclaimer WHERE status = 1");
        // dd($disclaimer[0]->disclaimer);
        if (!empty($disclaimer)) {
            $disclaimer_text = $disclaimer[0]->disclaimer;
        } else {
            $disclaimer_text = '';
        }

        for ($i = 0; $i < 4; $i++) {
            $fundnames[] = $fundMaster->fund_name;
            $schemenamei = date("jS F Y", strtotime($fundMaster->fund_opened));
        }

        $i = 0;
        $fundmanager = $fundMaster->fund_manager;
        //dd($fundmanager);
        $schemename=[];
        if (strpos($fundmanager, ",") !== false) {
            $efm = explode(',', $fundmanager);
            for ($t = 0; $t < count($efm); $t++) {
                $rth = trim($efm[$t], " ");
                $scheme = FundMaster::whereRaw("fund_manager like '%$rth%' ")->get();
                foreach ($scheme as $tow) {
                    if ($i <= 3) {
                        $schemename[] = $tow->fund_name;
                    }
                    $i++;
                }
            }
        } else {
            $scheme = FundMaster::whereRaw("fund_manager like '%$fundmanager%' ")->get();
            //$scheme = FundMaster::where("fund_manager", $fundmanager)->get();
            foreach ($scheme as $tow) {
                if ($i <= 3) {
                    $schemename[] = $tow->fund_name;
                }
                $i++;
            }
        }
        //dd($schemename);
        $fund_typeid = $fundMaster->fund_type_id;
        
        $fundname = FundMaster::where("fund_type_id", $fund_typeid)->get();
        // dd($fundname);
        $nfm = count($fundname);
        $snm = implode(',', $schemename);
        $fmbfm = implode(',', $fundnames);
        // dd($fmbfm);
        $AAUMValue = SELF::AAUMValue($fund_code);
        $total_asset = DB::select("select corpus_entry,entry_date from mpx_corpus_entry where fund_code='" . $fund_code . "' and DATE(entry_date) <= '".$updated_at."' order by entry_date desc limit 1");
        $crore = round($total_asset[0]->corpus_entry * 0.01, 2);

        //dd($AAUMValue);

       
        $date = DB::table("fund_composition")->latest('entry_date')->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->first();
        $dateall = DB::table("fund_composition")->select('entry_date')->where("fund_code", $fund_code)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->orderByRaw("entry_date  DESC")->groupBy('entry_date')->limit(12)->get();
        $date1 = "";
        $date2 = "";
        $date3 = "";
        $date4 = "";
        $dayn = date("F'y", strtotime($date->entry_date));
        $day1n = date("F'y", strtotime('-6 months', strtotime($date->entry_date)));
        $date1 = date('Y-m-t', strtotime('-6 months', strtotime($date->entry_date)));
        $day2n = date("F'y", strtotime("-12 months", strtotime($date->entry_date)));
        $date2 = date('Y-m-t', strtotime("-12 months", strtotime($date->entry_date))); 
        $day3n = date("F'y", strtotime("-18 months", strtotime($date->entry_date)));
        $date3 = date('Y-m-t', strtotime("-18 months", strtotime($date->entry_date)));
        $day4n = date("F'y", strtotime("-24 months", strtotime($date->entry_date)));
        $date4 = date('Y-m-t', strtotime("-24 months", strtotime($date->entry_date)));

        $fund_scrips = DB::table("fund_watch_fund_composition_analyses")->select('*')
        ->WHERE("fund_watch_id", $fund_watch_id)
        ->get();

        //dd($fund_scrips);
        
        //dd($fund_scrips);

        // return continious
        $returnContinious = DB::table("fund_watch_return_continious")->select('*')->WHERE("fund_watch_id", $fund_watch_id)->get();
        $returnContiniousDis = DB::table("fund_watch_return_discontinious")->select('*')->WHERE("fund_watch_id", $fund_watch_id)->get();
        $fund_watch_graphs = DB::table("fund_watch_graphs")->select('*')->WHERE("fund_watch_id", $fund_watch_id)->first();
        //dd($return_benchmark);

        // quartile decile        
        $sp_quick_return_ration_new = DB::select('CALL sp_quick_return_ration_new2("' . $lastPublishedDate . '",' . $fund_typeid . ')');
        //dd($sp_quick_return_ration_new);
        foreach ($sp_quick_return_ration_new as $fundId => $fundValue) {

            //dd($fundValue);
            $seven_days = '7DAYS';
            $thirty_days = '30DAYS';
            $ninety_days = '90DAYS';
            $sixmonths = 'sixmonths';
            $oneyear = 'oneyear';
            $twoyear = 'twoyear';
            $threeyear = 'threeyear';
            $fiveyear = 'fiveyear';

            if($fundValue->$seven_days!='N/A'){
                $seven_days_fund_returns[$fundValue->fund_id] = $fundValue->$seven_days;
            }
            if ($fundValue->$thirty_days != 'N/A') {
                $thirty_days_fund_returns[$fundValue->fund_id] = $fundValue->$thirty_days;
            }
            if ($fundValue->$ninety_days != 'N/A') {
                $ninety_days_fund_returns[$fundValue->fund_id] = $fundValue->$ninety_days;
            }
            if ($fundValue->$sixmonths != 'N/A') {
                $sixmonths_fund_returns[$fundValue->fund_id] = $fundValue->$sixmonths;
            }
            if ($fundValue->$oneyear != 'N/A') {
                $oneyear_fund_returns[$fundValue->fund_id] = $fundValue->$oneyear;
            }
            if ($fundValue->$twoyear != 'N/A') {
                $twoyear_fund_returns[$fundValue->fund_id] = $fundValue->$twoyear;
            }
            if ($fundValue->$threeyear != 'N/A') {
                $threeyear_fund_returns[$fundValue->fund_id] = $fundValue->$threeyear;
            }
            if ($fundValue->$fiveyear != 'N/A') {
                $fiveyear_fund_returns[$fundValue->fund_id] = $fundValue->$fiveyear;
            }

            //dd($fundValue->$sevenDAYS);
        }
        
        
        $getRankQuartile = $fund_watch_graphs->rankQuartile;
        $getRankDecile = $fund_watch_graphs->rankDecile;
        $returnLessIndex = $fund_watch_graphs->returnLessIndex;
        $returnLessIndexRank = $fund_watch_graphs->returnLessIndexRank;


        // top industries
        $total_corpus_entry = DB::table('corpus_entry')
            ->where('fund_code', $fund_code)
            ->where('entry_date', $date->entry_date)
            ->select(
                DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
            )->first()->total_corpus_entry;
        $top_industries = DB::table('view_corpus_with_allocation')
            ->where('fund_code', $fund_code)
            ->where('corpus_entry_date', $date->entry_date)
            ->where('composition_entry_date', $date->entry_date)
            ->where('category', 'Equity')
            ->select(
                'industry',
                'category',
                'fund_code',
                DB::raw($total_corpus_entry . ' as AUM'),
                DB::raw('SUM(content_per) as allocation'),
                // DB::raw('SUM(content_per/100) as allocation'),
                DB::raw('SUM(calculated_amount/100) as amount'),
                DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
            )
            ->orderBy('content_per', 'desc')
            ->groupBy('industry')
            ->limit(10)
            ->get();

        //dd($top_industries);
        return view('web.pages.new-fundwatch2', compact('dataArr','disclaimer_text', 'fundMaster', 'fundWatch', 'schemenamei','snm','total_asset', 'return_date', 'return_date_1', 'return_date_2', 'return_date_3', 'return_date_6_month', 'return_date_5', 'return_date_odd_1', 'return_date_odd_2','archiveData','recentPosts','AAUMValue','returnLessIndex', 'fund_scrips', 'dayn', 'day1n', 'day2n', 'day3n', 'day4n','returnContinious','getRankQuartile','getRankDecile','returnLessIndexRank','top_industries','returnContiniousDis' ));
        //return response()->json(['fund_code' => $fund_code,'RiskAdjustedAlpha'=>$RiskAdjustedAlpha, 'breakup' => $PortFoliBreakup, 'AAUM' => $AAUMValue, 'lumsum' => $lumbsum, 'sip' => $sip, 'fund_comp_analysis' => $fundCompAnalysis], 200); //

    }
    
    public function returnLessIndex($fund_code, $indices_name)
    {
        $date = FundDetail::getLastPublishedDate($fund_code);
        // dd($last_date);
        $sixMonthsAgo = date('Y-m-d', strtotime('-6 months', strtotime($date)));
        $oneYearAgo = date('Y-m-d', strtotime('-1 year', strtotime($date)));
        $twoYearsAgo = date('Y-m-d', strtotime('-2 year', strtotime($date)));
        $threeYearsAgo = date('Y-m-d', strtotime('-3 year', strtotime($date)));
        $fiveYearsAgo = date('Y-m-d', strtotime('-5 year', strtotime($date)));

        $indicesDetails = IndicesDetail::where('correlation_new', $indices_name)
                ->select(DB::raw("
                correlation_new,
                MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS closing_value_current_date,
                MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END) AS closing_value_sixMonthsAgo,
                MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END) AS closing_value_oneYearAgo,
                MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_value END) AS closing_value_twoYearsAgo,
                MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_value END) AS closing_value_threeYearsAgo,
                MAX(CASE WHEN entry_date = '$fiveYearsAgo' THEN closing_value END) AS closing_value_fiveYearsAgo,
                (
                    (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                    MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END)) / 
                    NULLIF(MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END), 0)
                ) * 100 AS sixmonthsReturn,
                (
                    (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                    MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END)) / 
                    NULLIF(MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END), 0)
                ) * 100 AS oneYearReturn,
                (
                    (
                        POW(
                            CAST(MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_value END) AS DECIMAL(15, 6)), 0),
                            1 / 2
                        ) - 1
                    ) * 100
                ) AS twoyearsReturn,
                (
                    (
                        POW(
                            CAST(MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_value END) AS DECIMAL(15, 6)), 0),
                            (1 / 3)
                        ) - 1 
                    ) * 100
                ) AS threeyearsReturn,
                (
                    (
                        POW(
                            CAST(MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN entry_date = '$fiveYearsAgo' THEN closing_value END) AS DECIMAL(15, 6)), 0),
                            (1 / 3)
                        ) - 1 
                    ) * 100
                ) AS fiveyearsReturn
            "))->groupBy('correlation_new')
                ->get()->keyBy('correlation_new')->toArray();

        //dd($indicesDetails);
        $fundDetails = FundDetail::where('fund_detail.fund_code', $fund_code)
                ->join('fund_master', 'fund_master.fund_code', '=', 'fund_detail.fund_code')
                ->select(DB::raw("
                mpx_fund_master.fund_code,
                mpx_fund_master.fund_name,
                mpx_fund_master.indices_name as correlation_new,
                MAX(CASE WHEN entry_date = '$date' THEN closing_nav END) AS closing_nav_current_date,
                MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_nav END) AS closing_nav_sixMonthsAgo,
                MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_nav END ) AS closing_nav_oneYearAgo,
                MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_nav END) AS closing_nav_twoYearsAgo,
                MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_nav END) AS closing_nav_threeYearsAgo,
                MAX(CASE WHEN entry_date = '$fiveYearsAgo' THEN closing_nav END) AS closing_nav_fiveYearsAgo,
                (
                    (MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
                    MAX(CASE WHEN mpx_fund_detail.entry_date = '$sixMonthsAgo' THEN mpx_fund_detail.closing_nav END)) / 
                    NULLIF(MAX(CASE WHEN mpx_fund_detail.entry_date = '$sixMonthsAgo' THEN mpx_fund_detail.closing_nav END), 0)
                ) * 100 AS sixmonthsReturn,
                (
                    (MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
                    MAX(CASE WHEN mpx_fund_detail.entry_date = '$oneYearAgo' THEN mpx_fund_detail.closing_nav END)) / 
                    NULLIF(MAX(CASE WHEN mpx_fund_detail.entry_date = '$oneYearAgo' THEN mpx_fund_detail.closing_nav END), 0)
                ) * 100 AS oneYearReturn,
                (
                (
                    POW(
                            CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$twoYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
                            (1 / 2)
                        ) - 1 
                    ) * 100
                ) AS twoyearsReturn,
                (
                (
                    POW(
                        CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                        NULLIF(CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$threeYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
                        (1 / 3)
                    ) - 1 ) * 100
                ) AS threeyearsReturn,
                (
                (
                    POW(
                        CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                        NULLIF(CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$fiveYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
                        (1 / 3)
                    ) - 1 ) * 100
                ) AS fiveyearsReturn
            "))->groupBy('fund_detail.fund_code')
                ->get()->toArray();

        //dd($fundDetails);
        $mergedResults = [];
        $defaultTimePeriod = ['6 months' => 'sixmonthsReturn', '1 Year' => 'oneYearReturn', '2 Year' => 'twoyearsReturn', '3 Year' => 'threeyearsReturn', '5 Year' => 'fiveyearsReturn'];
        
        $res[] = ['Years', 'Value'];
        foreach ($fundDetails as $fund) {
            $correlation_new = $fund['correlation_new'];
            // Check if the index data exists for the correlation_new
            $index = isset($indicesDetails[$correlation_new]) ? $indicesDetails[$correlation_new] : [
                'sixmonthsReturn' => 0,
                'oneYearReturn' => 0,
                'twoyearsReturn' => 0,
                'threeyearsReturn' => 0,
                'fiveyearsReturn' => 0
            ];
            
            foreach ($defaultTimePeriod as $key => $val) {
                $s = $fund[$val] != "9999" ? $fund[$val] : 0;
                $b = $index[$val] != "9999" ? $index[$val] : 0;
                $res[] = [$key, self::calculateDifference($s,$b)];
            }
        }
        //dd($res);
        return json_encode($res);
    }
    public function getreturnLessRank($fund_code, $classification, $indices)
    { //cod rank
        try {
            $last_date = $this->Useful->get_yesterday(); // IndicesDetail::getLastPublishedDate($indices);
            //print_r($last_date);
            $defaultMonths = ['sixmonths' => [6, '6 M'], 'oneyear' => [12, '1 Y'], 'twoyear' => [24, '2 Y'], 'threeyear' => [36, '3 Y'], 'fiveyear' => [60, '5 Y']]; //,12,24,36,60
            $type_id = $classification;
            foreach ($defaultMonths as $key => $val) {
                $date[] = SELF::get_last_month($val[0], $last_date);
            }
            //print_r($last_date);
            $data['sixmonths'] = DB::select('CALL sp_monthly_return_less_index_rank_six_new("' . $last_date . '","' . $type_id . '")');
            //dd($data['sixmonths']);
            $data['oneyear'] = DB::select('CALL sp_monthly_return_less_index_rank_one_year_new("' . $last_date . '","' . $type_id . '")');
            $data['twoyear'] = DB::select('CALL sp_monthly_return_less_index_rank_two_year_new("' . $last_date . '","' . $type_id . '")');
            $data['threeyear'] = DB::select('CALL sp_monthly_return_less_index_rank_three_year_new("' . $last_date . '","' . $type_id . '")');
            $data['fiveyear'] = DB::select('CALL sp_monthly_return_less_index_rank_five_year_new("' . $last_date . '","' . $type_id . '")');
            $i = 0;
            $dataArr['sixmonths'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 6 months')) . '","' . $last_date . '","' . $fund_code . '","' . $type_id . '")');
            $dataArr['oneyear'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 1 year')) . '","' . $last_date . '","' . $fund_code . '","' . $type_id . '")');
            $dataArr['twoyear'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 2 year')) . '","' . $last_date . '","' . $fund_code . '","' . $type_id . '")');
            $dataArr['threeyear'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 3 year')) . '","' . $last_date . '","' . $fund_code . '","' . $type_id . '")');
            $dataArr['fiveyear'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 5 year')) . '","' . $last_date . '","' . $fund_code . '","' . $type_id . '")');
            $finalArr = [];
            //dd($data['fiveyear']);
            //die();
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        //return ['status'=>'success','html'=>$data];
        foreach ($defaultMonths as $key => $val) {
            $sortedData = collect($data[$key])->sortBy([[$key, 'desc']]);
            //dd($sortedData);
            $rank = $sortedData->search(function ($user) use ($fund_code) {
                return $user->fund_code == $fund_code;
            });
            foreach ($dataArr as $keyq => $valq) {
                if ($key == $keyq) {
                    if (!empty($valq)) {
                        $quartile = $valq[0]->quartile;
                        $decile = $valq[0]->decile;
                    } else {
                        $quartile = 0;
                        $decile = 0;
                    }
                }
            }

            $result[] = [
                'period' => $val[1],
                'active_funds' => count($data[$key]),
                'rank' => $rank,
                'quartile' => $quartile,
                'decile' => $decile,
                'date' => date('d-M-Y', strtotime($date[$i])),

            ];
            $i++;
        }
        //dd($result);
        $html = view('web.pages.fund_watch.return_less_rank', ['result' => $result])->render();
        return ['status' => 'success', 'html' => $html];
    }
    public function get_last_month($month, $last_date)
    {
        $last_month_sd =  date('Y-m-d', strtotime("-" . $month . " months", strtotime($last_date)));

        return $last_month_sd;
    }
    public function getReturnContinous($fund_code)
    { ///cod new
        try {
            
            $indices_name = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();
            if ($fund_code && !empty($indices_name)) {
                $last_date = IndicesDetail::select('entry_date')->where('name', $indices_name->indices_name)->orderBy('idcd_id', 'desc')->first()->entry_date;
                $return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret_new("' . $last_date . '","' . $indices_name->indices_name . '","' .  $fund_code . '")');
                //$returnData['return_benchmark'] = $return_benchmark[0];
    
                //dd($return_benchmark);

            }
            

            //$benchMarkResponse = Http::get(url('/api/v1/fund-return-benchmark?fund_code=' . $fund_code))->json();
            //dd($benchMarkResponse);
            $CategoryAverageResponse = Http::get(url('/api/v1/fund-performance-compare-category?fund_code=' . $fund_code))->json();
            //dd($CategoryAverageResponse);

            $schemeResponse = Http::get(url('/api/v1/fund-return-scheme?fund_code=' . $fund_code))->json();
            //dd($schemeResponse);
            $scheme = $schemeResponse['data']['return_scheme'];
            // dd($scheme);
            $CategoryAverage = $CategoryAverageResponse['data']['category_compare_data'];
            // dd($CategoryAverage);
            //$benchMark = !empty($benchMarkResponse['data'])?$benchMarkResponse['data']['return_benchmark']:[];
            $benchMark = !empty($return_benchmark)?(array)$return_benchmark[0]:[]; 

            // return json_encode($schemeResponse);exit;

            $html = view('web.pages.fund_watch.retun_continus', ['scheme' => $scheme, 'category_average' => $CategoryAverage, 'bench_mark' => $benchMark])->render();
            return ['status' => 'success', 'html' => $html];
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function getReturndisContinous($fund_watch_id)
    { ///cod new
        // dd($fund_code);
        try {
            
            $benchMarkResponse = Http::get(url('/api/v1/fund-return-benchmark-dis?fund_code=' . $fund_code))->json();
            // dd($benchMarkResponse);
            $CategoryAverageResponse = Http::get(url('/api/v1/fund-performance-compare-category-dis?fund_code=' . $fund_code))->json();

            // $benchMarkResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-return-benchmark?fund_code='.$fund_code))->json();

            // $CategoryAverageResponse =Http::get(url('https://www.myplexus.com/api/v1/fund-performance-compare-category-dis?fund_code='.$fund_code))->json();
            //dd($CategoryAverageResponse);

            $schemeResponse = Http::get(url('/api/v1/fund-return-scheme-dis?fund_code=' . $fund_code))->json();
            //dd($schemeResponse);

            // dd($CategoryAverageResponse);
            if ($CategoryAverageResponse != null) {
                $CategoryAverage = $CategoryAverageResponse['data']['category_compare_data'];
            } else {
                $CategoryAverage = [];
            }
            if ($benchMarkResponse != null) {
                $benchMark = !empty($benchMarkResponse['data'])?$benchMarkResponse['data']['return_benchmark']:[];
            } else {
                $benchMark = [];
            }

            if ($schemeResponse != null) {
                $scheme = $schemeResponse['data']['return_scheme'];
            } else {
                $scheme = [];
            }
            // return $scheme;


            $html = view('web.pages.fund_watch.retun_discontinus', ['category_average' => $CategoryAverage, 'bench_mark' => $benchMark, 'scheme' => $scheme])->render();
            return ['status' => 'success', 'html' => $html];
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function getRiskAplha($fund_watch_id)
    {
        // dd($fund_code);
        // echo $fund_code;die;
        /*$response = Http::get(url('api/v1/fund-performance-jensenalpha-beta-volatility-new?fund_code=' . $fund_code))->json();
        // dd($response);
        // print_r($response);die;
        $defaultYears = ['SIXMONTHS_1', 'SIXMONTHS_2', 'SIXMONTHS_3'];
        $result = [];
        if ($response['success']) {
            $data = $response['data']['jensenalpha_beta_volatility_data'];
            // dd($data);
            foreach ($defaultYears as $k=> $val) {
                if ($data[$val]) {
                    $finacialYearStart1 = date("M'y", strtotime($data[$val]['end_date']));
                    $finacialYearStart2 = date("M'y", strtotime($data[$val]['start_date']));
                    if($k==0){
                        $diff = ' (6M)';
                    }else if($k==1){
                        $diff = ' (1Y)';
                    }else{
                        $diff = ' (2Y)';
                    }
                    $key = $finacialYearStart2 . ' - ' . $finacialYearStart1 . $diff;
                    $result[$key] = $data[$val];
                }
            }
        }*/

        $result = DB::table("fund_watch_risk_ratios")->select('*')->WHERE("fund_watch_id", $fund_watch_id)->get();

        //dd($result);
        $html = view('web.pages.fund_watch.risk_adjusted_alpha', ['RiskAdjustedAlpha' => $result])->render();
        return ['status' => 'success', 'html' => $html];
    }
    public function breakUP($fund_code)
    {
        $lastMonthDate = $lastSavedDate =  FundComposition::getPublishReadyDate();
        $filterArray = ['Equity' => 0, 'Cash' => 0, 'Corporate Debt' => 0, 'SOV' => 0, 'Others' => 0];
        $AllBreakUP = FundComposition::where(['fund_code' => $fund_code, 'entry_date' => $lastMonthDate])->get()->toArray();

        //dd($AllBreakUP);

        foreach ($AllBreakUP as $key => $value) {
            if (in_array($value['category'], array_keys($filterArray))) {
                $filterArray[$value['category']] = $filterArray[$value['category']] + $value['content_per'];
            } else {
                $filterArray['Others'] = $filterArray['Others'] + $value['content_per'];
            }
        }

        //dd($filterArray);

        $html = view('web.pages.fund_watch.portfolio_break_up', ['PortFoliBreakup' => $filterArray])->render();
        return ['status' => 'success', 'html' => $html];
        return $filterArray;
    }
    public function getSIPData($fund_code)
    {
        $deatultSIPAmount = 10000;
        $defaultYears = ['ONEYEAR' => 1, 'TWOYEAR' => 2, 'THREEYEAR' => 3];
        $dataArr['1 Year'] = DB::select('CALL sp_SIP_calc(12,"' . $fund_code . '",10000)');
        $dataArr['2 Years'] = DB::select('CALL sp_SIP_calc(24,"' . $fund_code . '",10000)');
        $dataArr['3 Years'] = DB::select('CALL sp_SIP_calc(36,"' . $fund_code . '",10000)');
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
        //$flastMonthDate = $this->Useful->get_last_month();
        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
        $updated_at = date('Y-m-d',strtotime($fundWatch->updated_at));
        $flastMonthDate = CorpusEntry::where("fund_code", $fund_code)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->orderBy('entry_date','desc')->get(['entry_date'])->first()->entry_date;
        //dd($flastMonthDate);
        $result[] = ['Entry Date', 'Value'];
        for ($i = 0; $i <= $numberOfGrapBar; $i++) {
            $s_date = $flastMonthDate;
            $dates = $this->Useful->get_last_month_quatery($s_date, $i * $mothsGap);

            //echo '<pre>';print_r($dates) ;
            $FUnddata = CorpusEntry::where("fund_code", $fund_code)->where('entry_date', $dates[1])->get(['corpus_entry', 'entry_date'])->toArray();
            //print_r($FUnddata);
            if (!empty($FUnddata)) {
                $result[] = [date('M, Y', strtotime($FUnddata[0]['entry_date'])), $FUnddata[0]['corpus_entry'] * 0.01];
            }
        }

        
        return json_encode($result);
    }
    public function getLumnsubData($fund_code)
    {
        $deatultLumsumAmount = 100000;
        $defaultYears = ['ONEYEAR' => 1, 'TWOYEAR' => 2, 'THREEYEAR' => 3];
        //$yesterday = $this->Useful->get_yesterday();
        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
        $updated_at = date('Y-m-d',strtotime($fundWatch->updated_at));
        $yesterday = $updated_at;
        //$yesterday='2022-12-16';
        $presentClosingNav = SELF::lumsumClosingNav($fund_code, $yesterday);
        $PreviewYearNavs = [];
        if (!empty($presentClosingNav)) {
            //$response = Http::get(url('api/v1/fund-return-scheme?fund_code=' . $fund_code))->json();
            //$percentege = $response['data']['return_scheme'];
            foreach ($defaultYears as $key => $val) {
                $LastYeardate = $this->Useful->getYears($val, $yesterday);
                $data = FundDetail::where("fund_code", $fund_code)->where('entry_date', $LastYeardate)->first('closing_nav');
                //dd(round($percentege[$key], 2));
                switch ($val) {
                    case 1:
                        $perc = (($presentClosingNav['closing_nav'] - $data->closing_nav) / $data->closing_nav) * 100;
                        break;
                    default:
                        if (!empty($data)) {
                            $perc = (pow(($presentClosingNav['closing_nav'] / $data->closing_nav), (1 / $val)) - 1) * 100;
                        } else {
                            $perc = 0;
                        }
                }

                if ($data) {
                    $numberofUnits = round($deatultLumsumAmount / $data->closing_nav, 3);
                    $finalamount =  $deatultLumsumAmount * pow((1 + ($perc / 100)), $val);

                    //dd($this->Useful->currencyFormat(round($numberofUnits * $presentClosingNav->closing_nav)));
                    if($val>1){
                        $keyn=$val . ' Years';
                    }else{
                        $keyn=$val . ' Year';
                    }
                    $PreviewYearNavs[$keyn] = [
                        /*'amount' => $this->Useful->currencyFormat(round($numberofUnits * $presentClosingNav->closing_nav)),*/
                        'amount' => number_format($finalamount) ? number_format($finalamount) : "NA",
                        'last_date' => $LastYeardate,
                        'last_date_nav_val' => $data->closing_nav,
                        'start_date' => $yesterday,
                        'start_date_nav_val' => $presentClosingNav['closing_nav'],
                        'numer_of_units' => $numberofUnits,
                        //'percentage' => round($percentege[$key], 2),
                        'percentage' => round($perc, 2) ? round($perc, 2) : "NA",
                    ];
                } else {
                    $PreviewYearNavs[$keyn . $LastYeardate . $yesterday] = [];
                }
            }
        }

        //dd($PreviewYearNavs);


        $html = view('web.pages.fund_watch.lumsum', ['lumbsum' => $PreviewYearNavs])->render();
        return ['status' => 'success', 'html' => $html];
    }
    private function lumsumClosingNav($fund_code, $yesterday)
    {
        $fundDetails = FundDetail::where("fund_code", $fund_code);
        $presentClosingNav = $fundDetails->where('entry_date', $yesterday)->first('closing_nav');
        if ($presentClosingNav == null) {
            $newDate = date('Y-m-d', (strtotime('-1 day', strtotime($yesterday))));
            return  SELF::lumsumClosingNav($fund_code, $newDate);
        } else {
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
        $headers = array_merge(['script'], $Headertemp);
        $result = [];
        foreach ($topScripts as $key => $script) {
            $temp = [];
            foreach ($top_10 as $date => $values) {
                $temp[] = isset($values[$script]) ? $values[$script] : 'NA';
            }
            $result[$script] = $temp;
        }
        $fundCompAnalysis = ['headers' => $headers, 'result' => $result];
        $html = view('web.pages.fund_watch.fund_composition', ['fundCompAnalysis' => $fundCompAnalysis])->render();
        return ['status' => 'success', 'html' => $html];
    }
    function getReturnlessIndexRank($fund_code, $fund_type_id)
    {
        
        $date = FundDetail::getLastPublishedDate($fund_code);
        $fund_codes = FundMaster::where('fund_type_id', $fund_type_id)->select('fund_code')->get()->pluck('fund_code')->toArray();
        $indices = FundMaster::where('fund_type_id', $fund_type_id)->select('indices_name')->groupBy('indices_name')->get()->pluck('indices_name')->toArray();
        $sixMonthsAgo = date('Y-m-d', strtotime('-6 months', strtotime($date)));
        $oneYearAgo = date('Y-m-d', strtotime('-1 year', strtotime($date)));
        $twoYearsAgo = date('Y-m-d', strtotime('-2 year', strtotime($date)));
        $threeYearsAgo = date('Y-m-d', strtotime('-3 year', strtotime($date)));
        $fiveYearsAgo = date('Y-m-d', strtotime('-5 year', strtotime($date)));
        $mergedResults = [];
        $six_months_rank_array = [];
        $one_year_rank_array = [];
        $two_years_rank_array = [];
        $three_years_rank_array = [];
        $five_years_rank_array = [];
        $selected_fund_return_array = [];

        $indicesDetails = IndicesDetail::whereIn('correlation_new', $indices)
        ->select(DB::raw("
                correlation_new,
                MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS closing_value_current_date,
                MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END) AS closing_value_sixMonthsAgo,
                MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END) AS closing_value_oneYearAgo,
                MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_value END) AS closing_value_twoYearsAgo,
                MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_value END) AS closing_value_threeYearsAgo,
                MAX(CASE WHEN entry_date = '$fiveYearsAgo' THEN closing_value END) AS closing_value_fiveYearsAgo,
                (
                    (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                    MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END)) / 
                    NULLIF(MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END), 0)
                ) * 100 AS sixmonthsReturn,
                (
                    (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                    MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END)) / 
                    NULLIF(MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END), 0)
                ) * 100 AS oneYearReturn,
                (
                    (
                        POW(
                            CAST(MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_value END) AS DECIMAL(15, 6)), 0),
                            1 / 2
                        ) - 1
                    ) * 100
                ) AS twoyearsReturn,
                (
                    (
                        POW(
                            CAST(MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_value END) AS DECIMAL(15, 6)), 0),
                            (1 / 3)
                        ) - 1 
                    ) * 100
                ) AS threeyearsReturn,
                (
                    (
                        POW(
                            CAST(MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN entry_date = '$fiveYearsAgo' THEN closing_value END) AS DECIMAL(15, 6)), 0),
                            (1 / 3)
                        ) - 1 
                    ) * 100
                ) AS fiveyearsReturn
            "))->groupBy('correlation_new')
        ->get()->keyBy('correlation_new')->toArray();

        $fundDetails = FundDetail::whereIn('fund_detail.fund_code', $fund_codes)
            ->join('fund_master', 'fund_master.fund_code', '=', 'fund_detail.fund_code')
            ->select(DB::raw("
                    mpx_fund_master.fund_code,
                    mpx_fund_master.fund_name,
                    mpx_fund_master.indices_name as correlation_new,
                    MAX(CASE WHEN entry_date = '$date' THEN closing_nav END) AS closing_nav_current_date,
                    MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_nav END) AS closing_nav_sixMonthsAgo,
                    MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_nav END ) AS closing_nav_oneYearAgo,
                    MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_nav END) AS closing_nav_twoYearsAgo,
                    MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_nav END) AS closing_nav_threeYearsAgo,
                    MAX(CASE WHEN entry_date = '$fiveYearsAgo' THEN closing_nav END) AS closing_nav_fiveYearsAgo,
                    (
                        (MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
                        MAX(CASE WHEN mpx_fund_detail.entry_date = '$sixMonthsAgo' THEN mpx_fund_detail.closing_nav END)) / 
                        NULLIF(MAX(CASE WHEN mpx_fund_detail.entry_date = '$sixMonthsAgo' THEN mpx_fund_detail.closing_nav END), 0)
                    ) * 100 AS sixmonthsReturn,
                    (
                        (MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
                        MAX(CASE WHEN mpx_fund_detail.entry_date = '$oneYearAgo' THEN mpx_fund_detail.closing_nav END)) / 
                        NULLIF(MAX(CASE WHEN mpx_fund_detail.entry_date = '$oneYearAgo' THEN mpx_fund_detail.closing_nav END), 0)
                    ) * 100 AS oneYearReturn,
                    (
                    (
                        POW(
                                CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                                NULLIF(CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$twoYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
                                (1 / 2)
                            ) - 1 
                        ) * 100
                    ) AS twoyearsReturn,
                    (
                    (
                        POW(
                            CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$threeYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
                            (1 / 3)
                        ) - 1 ) * 100
                    ) AS threeyearsReturn,
                    (
                    (
                        POW(
                            CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$fiveYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
                            (1 / 3)
                        ) - 1 ) * 100
                    ) AS fiveyearsReturn
                    "))->groupBy('fund_detail.fund_code')
                    ->get()->toArray();

            // dd($sixMonthsAgo, $oneYearAgo, $twoYearsAgo, $threeYearsAgo, $fundDetails, $indicesDetails);

        foreach ($fundDetails as $fund) {
            $correlation_new = $fund['correlation_new'];
            // Check if the index data exists for the correlation_new
            $index = isset($indicesDetails[$correlation_new]) ? $indicesDetails[$correlation_new] : [
                'sixmonthsReturn' => 0,
                'oneYearReturn' => 0,
                'twoyearsReturn' => 0,
                'threeyearsReturn' => 0,
                'fiveyearsReturn' => 0
            ];

            // Helper function to check if value is 'N/A'
            array_push($six_months_rank_array, (self::calculateDifference($fund['sixmonthsReturn'], $index['sixmonthsReturn'])));
            array_push($one_year_rank_array, (self::calculateDifference($fund['oneYearReturn'], $index['oneYearReturn'])));
            array_push($two_years_rank_array, (self::calculateDifference($fund['twoyearsReturn'], $index['twoyearsReturn'])));
            array_push($three_years_rank_array, (self::calculateDifference($fund['threeyearsReturn'], $index['threeyearsReturn'])));
            array_push($five_years_rank_array, (self::calculateDifference($fund['fiveyearsReturn'], $index['fiveyearsReturn'])));
            /*$result = [
                'fund_name' => $fund['fund_name'],
                'fund_code' => $fund['fund_code'],
                'sixmonths' => self::calculateDifference($fund['sixmonthsReturn'], $index['sixmonthsReturn']),
                'oneyear'   => self::calculateDifference($fund['oneYearReturn'], $index['oneYearReturn']),
                'twoyear'   => self::calculateDifference($fund['twoyearsReturn'], $index['twoyearsReturn']),
                'threeyear' => self::calculateDifference($fund['threeyearsReturn'], $index['threeyearsReturn']),
                'fiveyear' => self::calculateDifference($fund['fiveyearsReturn'], $index['fiveyearsReturn']),
            ];*/
            if ($fund['fund_code'] == $fund_code) {
                $selected_fund_return_array[0]['SIXMONTHS'] = self::calculateDifference($fund['sixmonthsReturn'], $index['sixmonthsReturn']);
                $selected_fund_return_array[0]['ONEYEAR'] = self::calculateDifference($fund['oneYearReturn'], $index['oneYearReturn']);
                $selected_fund_return_array[0]['TWOYEAR'] = self::calculateDifference($fund['twoyearsReturn'], $index['twoyearsReturn']);
                $selected_fund_return_array[0]['THREEYEAR'] = self::calculateDifference($fund['threeyearsReturn'], $index['threeyearsReturn']);
                $selected_fund_return_array[0]['FIVEYEAR'] = self::calculateDifference($fund['fiveyearsReturn'], $index['fiveyearsReturn']);
                $selected_fund_return = $selected_fund_return_array;
                // dd($selected_fund_return);
            }

            //array_push($mergedResults, (object) $result);
        }
        $val_six_month = $selected_fund_return_array[0]['SIXMONTHS'];
        $val_one_year = $selected_fund_return_array[0]['ONEYEAR'];
        $val_two_year = $selected_fund_return_array[0]['TWOYEAR'];
        $val_three_year = $selected_fund_return_array[0]['THREEYEAR'];
        $val_five_year = $selected_fund_return_array[0]['FIVEYEAR'];
        $six_months_rank = self::findRank($six_months_rank_array, $val_six_month);
        $one_year_rank = self::findRank($one_year_rank_array, $val_one_year);
        $two_years_rank = self::findRank($two_years_rank_array, $val_two_year);
        $three_years_rank = self::findRank($three_years_rank_array, $val_three_year);
        $five_years_rank = self::findRank($five_years_rank_array, $val_five_year);
        $defaultRank = ['1' => 10,'2' => 9,'3' => 8,'4' => 7,'5' => 6,'6' => 5,'7' => 4,'8' => 3,'9' => 2,'10' => 1];

        //dd($defaultRank[$six_months_rank]);

        $response_array = array('6 months' => ['rank'=>$defaultRank[$six_months_rank],'tooltip'=>'Rank: '.$six_months_rank], '1 year' => ['rank'=>$defaultRank[$one_year_rank],'tooltip'=>'Rank: '.$one_year_rank], '2 years' => ['rank'=>$defaultRank[$two_years_rank],'tooltip'=>'Rank: '.$two_years_rank], '3 years' => ['rank'=>$defaultRank[$three_years_rank],'tooltip'=>'Rank: '.$three_years_rank], '5 years' => ['rank'=>$defaultRank[$five_years_rank],'tooltip'=>'Rank: '.$five_years_rank]);
        // dd($response_array);
        return json_encode($response_array);



    }
    
    function getQuartile($fund_code, $fund_type_ID)
    {
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
        $six_months_quartile = DB::select('CALL sp_get_cagr_quartile_decile("' . $six_month_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        if (!empty($six_months_quartile)) {
            $sixMonths_cagr = $six_months_quartile[0]->cagr_value;
            $six_months_quartile = self::getOnlyQuartile($sixMonths_cagr, $six_month_before_date, $last_date, $fund_type_ID);
        } else {
            $six_months_quartile = [];
        }
        $one_year_quartile = DB::select('CALL sp_get_cagr_quartile_decile("' . $one_year_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        if (!empty($one_year_quartile)) {
            $one_year_cagr = $one_year_quartile[0]->cagr_value;
            $one_year_quartile = self::getOnlyQuartile($one_year_cagr, $one_year_before_date, $last_date, $fund_type_ID);
        } else {
            $one_year_quartile = [];
        }
        $two_years_quartile = DB::select('CALL sp_get_cagr_quartile_decile("' . $two_years_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        if (!empty($two_years_quartile)) {
            $two_years_cagr = $two_years_quartile[0]->cagr_value;
            $two_years_quartile = self::getOnlyQuartile($two_years_cagr, $two_years_before_date, $last_date, $fund_type_ID);
        } else {
            $two_years_quartile = [];
        }
        $three_years_quartile = DB::select('CALL sp_get_cagr_quartile_decile("' . $three_years_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        if (!empty($three_years_quartile)) {
            $three_years_cagr = $three_years_quartile[0]->cagr_value;
            $three_years_quartile = self::getOnlyQuartile($three_years_cagr, $three_years_before_date, $last_date, $fund_type_ID);
        } else {
            $three_years_quartile = [];
        }
        $five_years_quartile = DB::select('CALL sp_get_cagr_quartile_decile("' . $five_years_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        if (!empty($five_years_quartile)) {
            $five_years_cagr = $five_years_quartile[0]->cagr_value;
            $five_years_quartile = self::getOnlyQuartile($five_years_cagr, $five_years_before_date, $last_date, $fund_type_ID);
        } else {
            $five_years_quartile = [];
        }
        // Extract quartile values
        $six_months_quartile = !empty($six_months_quartile) ? $six_months_quartile[0]->quartile : 0;
        $one_year_quartile = !empty($one_year_quartile) ? $one_year_quartile[0]->quartile : 0;
        $two_years_quartile = !empty($two_years_quartile) ? $two_years_quartile[0]->quartile : 0;
        $three_years_quartile = !empty($three_years_quartile) ? $three_years_quartile[0]->quartile : 0;
        $five_years_quartile = !empty($five_years_quartile) ? $five_years_quartile[0]->quartile : 0;

        // Return quartiles for all time spans
        $response_array = array('6 months' => $six_months_quartile, '1 year' => $one_year_quartile, '2 years' => $two_years_quartile, '3 years' => $three_years_quartile, '5 years' => $five_years_quartile);
        // dd($response_array);
        return json_encode($response_array);
    }
    function getDecile($fund_code, $fund_type_ID)
    {
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
        $six_months_decile = DB::select('CALL sp_get_cagr_quartile_decile("' . $six_month_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        // dd('CALL sp_get_cagr_quartile_decile("'.$six_month_before_date.'","'.$last_date.'","'.$fund_code.'","'.$fund_type_ID.'")');
        if (!empty($six_months_decile)) {
            $sixMonths_cagr = $six_months_decile[0]->cagr_value;
            $six_months_decile = self::getOnlyDecile($sixMonths_cagr, $six_month_before_date, $last_date, $fund_type_ID);
        } else {
            $six_months_decile = [];
        }
        $one_year_decile = DB::select('CALL sp_get_cagr_quartile_decile("' . $one_year_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        if (!empty($one_year_decile)) {
            $one_year_cagr = $one_year_decile[0]->cagr_value;
            $one_year_decile = self::getOnlyDecile($one_year_cagr, $one_year_before_date, $last_date, $fund_type_ID);
        } else {
            $one_year_decile = [];
        }
        $two_years_decile = DB::select('CALL sp_get_cagr_quartile_decile("' . $two_years_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        if (!empty($two_years_decile)) {
            $two_years_cagr = $two_years_decile[0]->cagr_value;
            $two_years_decile = self::getOnlyDecile($two_years_cagr, $two_years_before_date, $last_date, $fund_type_ID);
        } else {
            $two_years_decile = [];
        }
        $three_years_decile = DB::select('CALL sp_get_cagr_quartile_decile("' . $three_years_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        if (!empty($three_years_decile)) {
            $three_years_cagr = $three_years_decile[0]->cagr_value;
            $three_years_decile = self::getOnlyDecile($three_years_cagr, $three_years_before_date, $last_date, $fund_type_ID);
        } else {
            $three_years_decile = [];
        }
        $five_years_decile = DB::select('CALL sp_get_cagr_quartile_decile("' . $five_years_before_date . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_ID . '")');
        if (!empty($five_years_decile)) {
            $five_years_cagr = $five_years_decile[0]->cagr_value;
            $five_years_decile = self::getOnlyDecile($five_years_cagr, $five_years_before_date, $last_date, $fund_type_ID);
        } else {
            $five_years_decile = [];
        }
        // Extract quartile values
        $six_months_decile = !empty($six_months_decile) ? $six_months_decile[0]->decile : 0;
        $one_year_decile = !empty($one_year_decile) ? $one_year_decile[0]->decile : 0;
        $two_years_decile = !empty($two_years_decile) ? $two_years_decile[0]->decile : 0;
        $three_years_decile = !empty($three_years_decile) ? $three_years_decile[0]->decile : 0;
        $five_years_decile = !empty($five_years_decile) ? $five_years_decile[0]->decile : 0;

        // Return quartiles for all time spans
        $response_array = array('6 months' => $six_months_decile, '1 year' => $one_year_decile, '2 years' => $two_years_decile, '3 years' => $three_years_decile, '5 years' => $five_years_decile);
        // dd($response_array);
        return json_encode($response_array);
    }
    function findRank($array, $number)
    {
        // Sort the array in ascending order
        rsort($array);

        // Find the index of the number in the sorted array
        $index = array_search($number, $array);

        // If the number is not found, return false
        if ($index === false) {
            return false;
        }

        // Add 1 to the index to get the rank (since array indexes are zero-based)
        if (($index + 1) > 10) {
            return 10;
        } else {
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

    function getRankQuartileDecile($fund_code, $fund_type_ID)
    {
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
    function getOnlyQuartile($cagr_value, $start_date, $end_date, $fund_type_id)
    {
        $quartile = DB::select('CALL sp_calculate_quartile("' . $start_date . '","' . $end_date . '","' . $fund_type_id . '","' . $cagr_value . '")');
        return $quartile;
    }
    function getOnlyDecile($cagr_value, $start_date, $end_date, $fund_type_id)
    {
        $decile = DB::select('CALL sp_calculate_decile("' . $start_date . '","' . $end_date . '","' . $fund_type_id . '","' . $cagr_value . '")');
        return $decile;
    }


    function calculateDifference($fundValue, $indexValue)
    {
        if ($fundValue === 'N/A' || $fundValue == 0) {
            return ''; // If fund value is 'N/A', return 'N/A'
        }
        if ($indexValue === 'N/A') {
            $indexValue = 0; // If index value is 'N/A', consider it as 0
        }
        return number_format($fundValue, 2) - number_format($indexValue, 2); // Calculate the difference
    }
    public static function quartile_calc($fund_returns, $fundID)
    {
        $numeric_fund_returns = array_filter($fund_returns, function ($value) {
            return is_numeric($value);
        });

        sort($numeric_fund_returns);
        // dd($numeric_fund_returns);

        // $tolerance = 0.0000001;

        $leader = max($numeric_fund_returns);
        // $leader = 8.08;
        // dd($max_fund_return_val);
        $laggard = min($numeric_fund_returns);
        // $laggard = 8.03;
        // dd($min_fund_return_val);
        $leader = number_format($leader, 2);
        $laggard = number_format($laggard, 2);

        $class_interval = $leader - $laggard;
        // dd($class_interval);
        $class_interval = number_format($class_interval, 2);

        $quartile_interval = ($class_interval / 4);
        // dd($quartile_interval);
        $interval_4th = $leader - $quartile_interval;
        // dd($interval_4th);
        $interval_3rd = $interval_4th - $quartile_interval;
        // dd($interval_3rd);
        $interval_2nd = $interval_3rd  - $quartile_interval;
        // dd($interval_2nd);
        $interval_1st = $interval_2nd - $quartile_interval;

        $fund_type_quartile_array = [];
        $params['leader'] = $leader;
        $params['laggard'] = $laggard;
        $params['interval_4th'] = $interval_4th;
        $params['interval_3rd'] = $interval_3rd;
        $params['interval_2nd'] = $interval_2nd;
        $params['interval_1st'] = $interval_1st;
        $params['report_type'] = 'returns';
        $params['selected_fund_return'] = $fund_returns[$fundID];

        $selected_fund_return = number_format(floatval($params['selected_fund_return']), 2);
        // $selected_fund_return = 3.0181409536041;
        // $leader = $params['leader'];
        $leader =  $params['leader'];
        $laggard = $params['laggard'];
        // dd($laggard);
        $interval_4th = number_format($params['interval_4th'], 2);
        $interval_3rd = number_format($params['interval_3rd'], 2);
        $interval_2nd = number_format($params['interval_2nd'], 2);
        // $interval_2nd = 3.1920756346725;
        $interval_1st = number_format($params['interval_1st'], 2);
        // $interval_1st = 3.0181409536041;

        // echo $interval_1st.'-------------'.$selected_fund_return."-------------|".$interval_2nd;
        $quartile = null;
        /*if($selected_fund_return > $interval_4th && $selected_fund_return <= $leader){
            $quartile = 4;
        }elseif($selected_fund_return > $interval_3rd && $selected_fund_return <= $interval_4th){
            $quartile = 3;
        }elseif($selected_fund_return > $interval_2nd && $selected_fund_return <= $interval_3rd){
            $quartile = 2;
        }elseif($selected_fund_return >= $interval_1st && $selected_fund_return <= $interval_2nd){
            $quartile = 1;
        }else{
            $quartile = 0;
        }*/
        $tolerance = 0.0000001;

        $report_type = $params['report_type'];

        $risk_ratio_array = ['beta', 'volatility', 'tracking_error'];

        if (in_array($report_type, $risk_ratio_array)) {

            if ($selected_fund_return >= $interval_4th  && $selected_fund_return <= $leader) {
                $quartile = 1;
            } elseif ($selected_fund_return >= $interval_3rd  && $selected_fund_return <= $interval_4th) {
                $quartile = 2;
            } elseif ($selected_fund_return >= $interval_2nd  && $selected_fund_return <= $interval_3rd) {
                $quartile = 3;
            } elseif ($selected_fund_return >= $interval_1st  && $selected_fund_return <= $interval_2nd) {
                $quartile = 4;
            } else {
                $quartile = '';
            }
        } else {
            if ($selected_fund_return >= $interval_4th  && $selected_fund_return <= $leader) {
                $quartile = 4;
            } elseif ($selected_fund_return >= $interval_3rd  && $selected_fund_return <= $interval_4th) {
                $quartile = 3;
            } elseif ($selected_fund_return >= $interval_2nd  && $selected_fund_return <= $interval_3rd) {
                $quartile = 2;
            } elseif ($selected_fund_return >= $interval_1st  && $selected_fund_return <= $interval_2nd) {
                $quartile = 1;
            } else {
                $quartile = '';
            }
        }



        // dd($quartile);

        return $quartile;
    }
    public static function decile_calc($fund_returns, $fundID)
    {
        //echo '<pre>';print_r($fund_returns);
        $numeric_fund_returns = array_filter($fund_returns, function ($value) {
            return is_numeric($value);
        });

        sort($numeric_fund_returns);

        $leader = max($numeric_fund_returns);
        // $leader = 8.08;
        // dd($max_fund_return_val);
        $laggard = min($numeric_fund_returns);
        // $laggard = 8.03;
        // dd($min_fund_return_val);

        $leader = number_format($leader, 2);
        $laggard = number_format($laggard, 2);

        $class_interval = $leader - $laggard;
        // dd($class_interval);
        $decile_interval = ($class_interval / 10);

        // $decile_interval = number_format($decile_interval,2);

        // dd($leader,$laggard,$decile_interval);
        $interval_10th = $leader - $decile_interval;
        // dd($interval_4th);
        $interval_9th = $interval_10th - $decile_interval;
        // dd($interval_3rd);
        $interval_8th = $interval_9th - $decile_interval;
        // dd($interval_2nd);
        $interval_7th = $interval_8th - $decile_interval;
        $interval_6th = $interval_7th - $decile_interval;
        $interval_5th = $interval_6th - $decile_interval;
        $interval_4th = $interval_5th - $decile_interval;
        $interval_3rd = $interval_4th - $decile_interval;
        $interval_2nd = $interval_3rd - $decile_interval;
        $interval_1st = $interval_2nd - $decile_interval;

        //dd($fund_returns[1493]);
        $selected_fund_return2 =  $fund_returns[$fundID];
        //dd($selected_fund_return2);

        $params['leader'] = $leader;
        $params['laggard'] = $laggard;
        $params['interval_10th'] = $interval_10th;
        $params['interval_9th'] = $interval_9th;
        $params['interval_8th'] = $interval_8th;
        $params['interval_7th'] = $interval_7th;
        $params['interval_6th'] = $interval_6th;
        $params['interval_5th'] = $interval_5th;
        $params['interval_4th'] = $interval_4th;
        $params['interval_3rd'] = $interval_3rd;
        $params['interval_2nd'] = $interval_2nd;
        $params['interval_1st'] = $interval_1st;
        $params['report_type'] = 'returns';
        $params['selected_fund_return'] = $selected_fund_return2;
        $params['fund_id'] = $fundID;
        //$decile = self::decile_calc($params);

        $selected_fund_return = number_format(floatval($params['selected_fund_return']), 2);

        // $selected_fund_return = $params['selected_fund_return'];
        $leader =  $params['leader'];
        $laggard = $params['laggard'];
        // dd($laggard);
        $interval_10th = number_format($params['interval_10th'], 2);
        $interval_9th = number_format($params['interval_9th'], 2);
        $interval_8th = number_format($params['interval_8th'], 2);
        $interval_7th = number_format($params['interval_7th'], 2);
        $interval_6th = number_format($params['interval_6th'], 2);
        $interval_5th = number_format($params['interval_5th'], 2);
        $interval_4th = number_format($params['interval_4th'], 2);
        $interval_3rd = number_format($params['interval_3rd'], 2);
        $interval_2nd = number_format($params['interval_2nd'], 2);
        $interval_1st = number_format($params['interval_1st'], 2);


        // echo $interval_1st.'-------------'.$selected_fund_return."-------------|".$interval_2nd;
        $decile = null;

        // if($params['fund_id'] == 80){

        //     dd($selected_fund_return,$params,$interval_10th,$interval_9th,$interval_8th,$interval_7th,$interval_6th,$interval_5th,$interval_4th,$interval_3rd,$interval_2nd,$interval_1st);

        // }
        $report_type = $params['report_type'];


        $risk_ratio_array = ['beta', 'volatility', 'tracking_error'];

        $tolerance = 0.0000001;

        if (in_array($report_type, $risk_ratio_array)) {

            if ($selected_fund_return >= $interval_10th  && $selected_fund_return <= $leader) {
                $decile = 1;
            } elseif ($selected_fund_return >= $interval_9th  && $selected_fund_return <= $interval_10th) {
                $decile = 2;
            } elseif ($selected_fund_return >= $interval_8th  && $selected_fund_return <= $interval_9th) {
                $decile = 3;
            } elseif ($selected_fund_return >= $interval_7th  && $selected_fund_return <= $interval_8th) {
                $decile = 4;
            } elseif ($selected_fund_return >= $interval_6th  && $selected_fund_return <= $interval_7th) {
                $decile = 5;
            } elseif ($selected_fund_return >= $interval_5th  && $selected_fund_return <= $interval_6th) {
                $decile = 6;
            } elseif ($selected_fund_return >= $interval_4th  && $selected_fund_return <= $interval_5th) {
                $decile = 7;
            } elseif ($selected_fund_return >= $interval_3rd  && $selected_fund_return <= $interval_4th) {
                $decile = 8;
            } elseif ($selected_fund_return >= $interval_2nd  && $selected_fund_return <= $interval_3rd) {
                $decile = 9;
            } elseif ($selected_fund_return >= $interval_1st  && $selected_fund_return <= $interval_2nd) {
                $decile = 10;
            } else {
                $decile = '';
            }
        } else {

            if ($selected_fund_return >= $interval_10th  && $selected_fund_return <= $leader) {
                $decile = 10;
            } elseif ($selected_fund_return >= $interval_9th  && $selected_fund_return <= $interval_10th) {
                $decile = 9;
            } elseif ($selected_fund_return >= $interval_8th  && $selected_fund_return <= $interval_9th) {
                $decile = 8;
            } elseif ($selected_fund_return >= $interval_7th  && $selected_fund_return <= $interval_8th) {
                $decile = 7;
            } elseif ($selected_fund_return >= $interval_6th  && $selected_fund_return <= $interval_7th) {
                $decile = 6;
            } elseif ($selected_fund_return >= $interval_5th  && $selected_fund_return <= $interval_6th) {
                $decile = 5;
            } elseif ($selected_fund_return >= $interval_4th  && $selected_fund_return <= $interval_5th) {
                $decile = 4;
            } elseif ($selected_fund_return >= $interval_3rd  && $selected_fund_return <= $interval_4th) {
                $decile = 3;
            } elseif ($selected_fund_return >= $interval_2nd  && $selected_fund_return <= $interval_3rd) {
                $decile = 2;
            } elseif ($selected_fund_return >= $interval_1st  && $selected_fund_return <= $interval_2nd) {
                $decile = 1;
            } else {
                $decile = '';
            }
        }





        return $decile;
    }
}
