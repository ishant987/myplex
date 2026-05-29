<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BaseController;
use App\Models\CorpusEntry;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FundMaster;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use DB;
use App\Lib\Core\Useful;
use App\Models\FundComposition;
use App\Models\FundDetail;
use App\Models\FundType;
use App\Models\IndicesComposition;
use App\Models\IndicesDetail;
use App\Models\IndicesMaster;
use DateTime;
use Illuminate\Support\Str;

class RatioController extends Controller
{
  public function __construct()
  {
    $this->Useful = new Useful;
  }
  public static function loggedInUserData()
  {
    $user = Auth::user();
    $userId = $user->u_id;
    // dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';


    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();

    return $data;
  }
  public function dashboard(Request $request)
  {
    //  dd("ok");
    $data['browser_title'] = 'Ration Reports';
    $data['active_menu'] = 'dashboard';
    $user = Auth::user();
    $userId = $user->u_id;
    // dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';


    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
    //$data['fiveDaysBeforeExpiry']='2024-04-21';
    // dd($fiveDaysBeforeExpiry);
    return view('web.auth.ratio_analysis.dashboard', $data);
    // return view('web.auth.ratio',$data);
  }
  function quick_ratio()
  {

    $data['browser_title'] = 'Quick Ratio';
    $data['active_menu'] = 'dashboard';
    $user = Auth::user();
    $userId = $user->u_id;
    //  dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
    return view('web.ratio-reports.quick_ratio', $data);
  }

  function quick_ratio_new(Request $request)
  {

    $data['browser_title'] = 'Quick Ratio';
    $data['active_menu'] = 'dashboard';
    $user = Auth::user();
    $userId = $user->u_id;
    $data['request'] = $request;
    $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();
    $data['disclaimer'] = $disclaimerQuery->disclaimer;


    $data['all_fund_types'] = FundType::where('active_passive', 'A')->get();
    if (isset($request->fund_type_id)) {
      $data['request_fund_type'] = FundType::where('ft_id', $request->fund_type_id)->first();
    }



    //  dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();

    if (isset($reports) && $reports->type == 'weekly' && $request->report_category == 'corpus_change') {
      return view('web.ratio-reports.quick_ratio_new', $data);
    }

    /*=================================================*/

    $type = (isset($request->type) && $request->type) ? $request->type : '';
    $type_id = isset($request->fund_type_id) ? $request->fund_type_id : '';
    $report_category = isset($request->report_category) ? $request->report_category : '';
    $date = (isset($request->date) && $request->date) ? date('Y-m-d', strtotime(urldecode($request->date))) : '';
    // dd($type,$type_id,$report_category,$date);
    if (!empty($type) && !empty($type_id) && !empty($report_category) && !empty($date)) {

      // $Latest_corpus_entry_date='2024-03-31';
      // $last_aaum =  DB::select("SELECT `entry_date` FROM `mpx_corpus_entry` WHERE fund_code IN (SELECT fund_code FROM mpx_fund_master WHERE fund_type_id = $type_id) ORDER BY `entry_date` DESC LIMIT 0,1;");
      // $last_aaum_date = $last_aaum[0]->entry_date;

      // dd($last_aaum_date);
      $corpusdate = $date = date('Y-m-d', strtotime($date));
      $corpusdate = Carbon::createFromFormat('Y-m-d', trim($corpusdate));


      // Get the current date
      $currentDate = Carbon::now();

      if ($corpusdate->isCurrentMonth()) {
        // If the given date is in the current month, return the last date of the previous month
        $final_corpus_date =  $currentDate->subMonthNoOverflow()->endOfMonth()->format('Y-m-d');
      } else {
        // If the given date is in a previous month, return the last date of that month
        $final_corpus_date =  $corpusdate->endOfMonth()->format('Y-m-d');
      }

      // $last_aaum_date = '2023-03-31';
      //  dd($date);
      if ($type == 'weekly') {
        if ($report_category == 'return') {
          // $dataArr = DB::select('CALL sp_weekly_funds("' . $date . '",' . $type_id . ')');
          $dataArr = DB::select('CALL sp_weekly_funds_test(' . $type_id . ',"' . $date . '")');
          // dd('CALL sp_weekly_funds_test("' . $type_id . '",' . $date . ')');
        }
        if ($report_category == 'indices') {
          $dataArr = DB::select('CALL sp_weekly_indices("' . $date . '",' . $type_id . ')');
        }
        if ($report_category == 'return_less_index') {
          $dataArr = self::return_less_index($type_id, $date, 'weekly');
          // $dataArr = DB::select('CALL sp_weekly_return_less_index("' . $date . '",' . $type_id . ')');
        }
      }
      if ($type == 'monthly') {
        if ($report_category == 'return') {
          // $dataArr = DB::select('CALL sp_monthly_funds("'.$date.'",'.$type_id.')');
          // $dataArr = DB::select('CALL sp_quick_return_ration("' . $date . '",' . $type_id . ')');
          $dataArr = DB::select('CALL sp_quick_return_ration_test("' . $date . '",' . $type_id . ')');
        }
        if ($report_category == 'indices') {
          // dd('CALL sp_monthly_indices("'.$date.'",'.$type_id.')');
          $dataArr = DB::select('CALL sp_monthly_indices("' . $date . '",' . $type_id . ')');
        }
        if ($report_category == 'return_less_index') {
          $dataArr = self::return_less_index($type_id, $date, 'monthly');
          // $dataArr = DB::select('CALL sp_monthly_return_less_index("' . $date . '",' . $type_id . ')');
        }
        if ($report_category == 'corpus_change') {
          $dataArr = DB::select('CALL sp_monthly_corpus_change("' . $final_corpus_date . '",' . $type_id . ')');
        }
      }
      //dd($dataArr);
      if (count($dataArr)) {

        $responseArr['snapshot_data'] = $dataArr;
        $responseArr['test'] = $type_id;
        if ($report_category == 'corpus_change') {
          $responseArr['aaum_date'] = $final_corpus_date;
        }
        // dd($responseArr);
        $data['responseArr'] = $responseArr;
        // return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
      }
    }
    // dd($data);
    /*================================================*/

    return view('web.ratio-reports.quick_ratio_new', $data);
  }


  /*================================================*/

  function return_less_index($fund_type_id, $date, $type)
  {
    $fund_codes = FundMaster::where('fund_type_id', $fund_type_id)->select('fund_code')->get()->pluck('fund_code')->toArray();

    $indices = FundMaster::where('fund_type_id', $fund_type_id)->select('indices_name')->groupBy('indices_name')->get()->pluck('indices_name')->toArray();

    $mergedResults = [];

    if ($type == 'monthly') {

      // $sixMonthsAgo = date('Y-m-d', strtotime('-6 months +1 day', strtotime($date)));
      // $oneYearAgo = date('Y-m-d', strtotime('-1 year +1 day', strtotime($date)));
      // $twoYearsAgo = date('Y-m-d', strtotime('-2 year +1 day', strtotime($date)));
      // $threeYearsAgo = date('Y-m-d', strtotime('-3 year +1 day', strtotime($date)));

      $sixMonthsAgo = date('Y-m-d', strtotime('-6 months', strtotime($date)));
      $oneYearAgo = date('Y-m-d', strtotime('-1 year', strtotime($date)));
      $twoYearsAgo = date('Y-m-d', strtotime('-2 year', strtotime($date)));
      $threeYearsAgo = date('Y-m-d', strtotime('-3 year', strtotime($date)));

      // dd($sixMonthsAgo,$oneYearAgo,$twoYearsAgo,$threeYearsAgo);

      $indicesDetails = IndicesDetail::whereIn('correlation_new', $indices)
        ->select(DB::raw("
                correlation_new,
                MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS closing_value_current_date,
                MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END) AS closing_value_sixMonthsAgo,
                MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END) AS closing_value_oneYearAgo,
                MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_value END) AS closing_value_twoYearsAgo,
                MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_value END) AS closing_value_threeYearsAgo,
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
                ) AS threeyearsReturn
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
                ) AS threeyearsReturn
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
          'threeyearsReturn' => 0
        ];

        // Helper function to check if value is 'N/A'

        $result = [
          'fund_name' => $fund['fund_name'],
          'fund_code' => $fund['fund_code'],
          'sixmonths' => self::calculateDifference($fund['sixmonthsReturn'], $index['sixmonthsReturn']),
          'oneyear'   => self::calculateDifference($fund['oneYearReturn'], $index['oneYearReturn']),
          'twoyear'   => self::calculateDifference($fund['twoyearsReturn'], $index['twoyearsReturn']),
          'threeyear' => self::calculateDifference($fund['threeyearsReturn'], $index['threeyearsReturn']),
        ];

        array_push($mergedResults, (object) $result);
      }
    } elseif ($type == 'weekly') {

      $sevenDaysAgo = date('Y-m-d', strtotime('-7 days', strtotime($date)));
      $fourteenDaysAgo = date('Y-m-d', strtotime('-14 days', strtotime($date)));
      $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days', strtotime($date)));
      $sixtyDaysAgo = date('Y-m-d', strtotime('-60 days', strtotime($date)));

      // dd($sixMonthsAgo,$oneYearAgo,$twoYearsAgo,$threeYearsAgo);

      $indicesDetails = IndicesDetail::whereIn('correlation_new', $indices)
        ->select(DB::raw("
            correlation_new,
            MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS closing_value_current_date,
            MAX(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_value END) AS closing_value_sevenDaysAgo,
            MAX(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_value END) AS closing_value_fourteenDaysAgo,
            MAX(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_value END) AS closing_value_thirtyDaysAgo,
            MAX(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_value END) AS closing_value_sixtyDaysAgo,
            (
                (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                MAX(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_value END)) / 
                NULLIF(MAX(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_value END), 0)
            ) * 100 AS sevenDaysReturn,
            (
                (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                MAX(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_value END)) / 
                NULLIF(MAX(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_value END), 0)
            ) * 100 AS fourteenDaysReturn,
            (
                (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                MAX(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_value END)) / 
                NULLIF(MAX(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_value END), 0)
            ) * 100 AS thirtyDaysReturn,
            (
                (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                MAX(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_value END)) / 
                NULLIF(MAX(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_value END), 0)
            ) * 100 AS sixtyDaysReturn
        "))
        ->groupBy('correlation_new')
        ->get()
        ->keyBy('correlation_new')
        ->toArray();

      $fundDetails = FundDetail::whereIn('fund_detail.fund_code', $fund_codes)
        ->join('fund_master', 'fund_master.fund_code', '=', 'fund_detail.fund_code')
        ->select(DB::raw("
          mpx_fund_master.fund_code,
          mpx_fund_master.fund_name,
          mpx_fund_master.indices_name as correlation_new,
          MAX(CASE WHEN entry_date = '$date' THEN closing_nav END) AS closing_nav_current_date,
          MAX(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_nav END) AS closing_nav_sevenDaysAgo,
          MAX(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_nav END ) AS closing_nav_fourteenDaysAgo,
          MAX(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_nav END) AS closing_nav_thirtyDaysAgo,
          MAX(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_nav END) AS closing_nav_sixtyDaysAgo,
          (
              (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
              SUM(CASE WHEN mpx_fund_detail.entry_date = '$sevenDaysAgo' THEN mpx_fund_detail.closing_nav END)) / 
              NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$sevenDaysAgo' THEN mpx_fund_detail.closing_nav END), 0)
          ) * 100 AS sevenDaysReturn,
          (
              (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
              SUM(CASE WHEN mpx_fund_detail.entry_date = '$fourteenDaysAgo' THEN mpx_fund_detail.closing_nav END)) / 
              NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$fourteenDaysAgo' THEN mpx_fund_detail.closing_nav END), 0)
          ) * 100 AS fourteenDaysReturn,
          (
              (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
              SUM(CASE WHEN mpx_fund_detail.entry_date = '$thirtyDaysAgo' THEN mpx_fund_detail.closing_nav END)) / 
              NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$thirtyDaysAgo' THEN mpx_fund_detail.closing_nav END), 0)
          ) * 100 AS thirtyDaysReturn,
          (
              (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
              SUM(CASE WHEN mpx_fund_detail.entry_date = '$sixtyDaysAgo' THEN mpx_fund_detail.closing_nav END)) / 
              NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$sixtyDaysAgo' THEN mpx_fund_detail.closing_nav END), 0)
          ) * 100 AS sixtyDaysReturn
      "))
        ->groupBy('fund_detail.fund_code')
        ->get()->toArray();

      // dd($date,$sevenDaysAgo, $fourteenDaysAgo, $thirtyDaysAgo, $sixtyDaysAgo,$indicesDetails,$fundDetails);

      foreach ($fundDetails as $fund) {
        $correlation_new = $fund['correlation_new'];
        // Check if the index data exists for the correlation_new
        $index = isset($indicesDetails[$correlation_new]) ? $indicesDetails[$correlation_new] : [
          'sevenDaysReturn' => 0,
          'fourteenDaysReturn' => 0,
          'thirtyDaysReturn' => 0,
          'sixtyDaysReturn' => 0
        ];

        // Helper function to check if value is 'N/A'

        $result = [
          'fund_name' => $fund['fund_name'],
          'fund_code' => $fund['fund_code'],
          '7DAYS' => self::calculateDifference($fund['sevenDaysReturn'], $index['sevenDaysReturn']),
          '14DAYS'   => self::calculateDifference($fund['fourteenDaysReturn'], $index['fourteenDaysReturn']),
          '30DAYS'   => self::calculateDifference($fund['thirtyDaysReturn'], $index['thirtyDaysReturn']),
          '60DAYS' => self::calculateDifference($fund['sixtyDaysReturn'], $index['sixtyDaysReturn']),
        ];

        array_push($mergedResults, (object) $result);
      }
    }

    return $mergedResults;
  }


  function calculateDifference($fundValue, $indexValue)
  {
    if ($fundValue === 'N/A' || $fundValue == 0) {
      return 'N/A'; // If fund value is 'N/A', return 'N/A'
    }
    if ($indexValue === 'N/A') {
      $indexValue = 0; // If index value is 'N/A', consider it as 0
    }
    return number_format($fundValue, 2) - number_format($indexValue, 2); // Calculate the difference
  }

  /*==============================================*/

  function monthly_snapshot()
  {
    $user = Auth::user();
    $userId = $user->u_id;
    //  dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
    return view('web.ratio-reports.monthly_snapshot', $data);
  }

  function monthly_snapshot_new()
  {
    $user = Auth::user();
    $userId = $user->u_id;
    //  dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
    return view('web.ratio-reports.monthly_snapshot_new', $data);
  }

  function weekly_snapshot()
  {
    $user = Auth::user();
    $userId = $user->u_id;
    //  dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
    return view('web.ratio-reports.weekly_snapshot', $data);
  }

  function weekly_snapshot_new()
  {
    $user = Auth::user();
    $userId = $user->u_id;
    //  dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
    return view('web.ratio-reports.weekly_snapshot_new', $data);
  }

  function subscription_lock()
  {
    $user = Auth::user();
    $userId = $user->u_id;
    //  dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
    return view('web.ratio-reports.subscription_lock', $data);
  }

  function fund_factsheet_original(Request $request)
  {
    $user = Auth::user();
    $userId = $user->u_id;
    //  dd($userId);

    $data['browser_title'] = 'Fund Factsheet';
    $data['active_menu'] = 'dashboard';


    $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();
    $data['disclaimer'] = $disclaimerQuery->disclaimer;
    // dd($data['disclaimer']);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();

    $data['all_funds'] = FundMaster::select('fund_name', 'fund_id')->where('status', '1')->get();
    // dd($data['fund_details']);
    $selected_fund_id = $request->fund_id;
    $data['fund_details'] = FundMaster::where('fund_id', $selected_fund_id)->first();
    $data['index_name'] = isset($data['fund_details']) ? $data['fund_details']->indices_name : '';
    // dd($index_name);

    if (isset($request->fund_id, $request->to_date)) {
      // $data['']
      //gettting the datas through the WebApi's
      //jensen alpha+Returns+Returns - Index+Beta
      $request->to_date = Carbon::parse($request->to_date)->format('Y-m-d');

      $getData = $request->all();

      $jensonAlphaData['six_months'] = self::getJensonAlpha($getData, 6);
      // dd($jensonAlphaData);
      $jensonAlphaData['one_year'] = self::getJensonAlpha($getData, 1);
      $jensonAlphaData['two_year'] = self::getJensonAlpha($getData, 2);
      $jensonAlphaData['three_year'] = self::getJensonAlpha($getData, 3);
      $jensonAlphaData['four_year'] = self::getJensonAlpha($getData, 4);
      $jensonAlphaData['five_year'] = self::getJensonAlpha($getData, 5);
      // dd($jensonAlphaData);
      $data['jensonAlphaData'] = $jensonAlphaData;


      //Sharpe + Volatility
      $sharpeData['six_months'] = self::getSharpe($getData, 6);
      $sharpeData['one_year'] = self::getSharpe($getData, 1);
      $sharpeData['two_year'] = self::getSharpe($getData, 2);
      $sharpeData['three_year'] = self::getSharpe($getData, 3);
      $sharpeData['four_year'] = self::getSharpe($getData, 4);
      $sharpeData['five_year'] = self::getSharpe($getData, 5);
      // dd($sharpeData);
      $data['sharpeData'] = $sharpeData;

      //Treynor
      $treynorData['six_months'] = self::getTreynor($getData, 6);
      $treynorData['one_year'] = self::getTreynor($getData, 1);
      $treynorData['two_year'] = self::getTreynor($getData, 2);
      $treynorData['three_year'] = self::getTreynor($getData, 3);
      $treynorData['four_year'] = self::getTreynor($getData, 4);
      $treynorData['five_year'] = self::getTreynor($getData, 5);
      // dd($treynorData);
      $data['treynorData'] = $treynorData;

      //Tracking error
      $trackingErrorData['six_months'] = self::getTrackingError($getData, 6);
      $trackingErrorData['one_year'] = self::getTrackingError($getData, 1);
      $trackingErrorData['two_year'] = self::getTrackingError($getData, 2);
      $trackingErrorData['three_year'] = self::getTrackingError($getData, 3);
      $trackingErrorData['four_year'] = self::getTrackingError($getData, 4);
      $trackingErrorData['five_year'] = self::getTrackingError($getData, 5);
      // dd($trackingErrorData);
      $data['trackingErrorData'] = $trackingErrorData;

      //skewness
      $skewness['six_months'] = self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 6);
      $skewness['one_year'] = self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 1);
      $skewness['two_year'] = self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 2);
      $skewness['three_year'] = self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 3);
      $skewness['four_year'] = self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 4);
      $skewness['five_year'] = self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 5);
      // dd($skewness);
      $data['skewness'] = $skewness;

      //skewness
      $kurtosis['six_months'] = self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 6);
      $kurtosis['one_year'] = self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 1);
      $kurtosis['two_year'] = self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 2);
      $kurtosis['three_year'] = self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 3);
      $kurtosis['four_year'] = self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 4);
      $kurtosis['five_year'] = self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 5);
      // dd($kurtosis);
      $data['kurtosis'] = $kurtosis;


      $data['AAUMValue'] = SELF::AAUMValue($data['fund_details']->fund_code);

      $indices_name = $data['fund_details']->indices_name;
      $target_date = $request->to_date;

      // Find the closest entry_date to the target_date.
      $closest_entry_date = DB::table('indices_composition')
        ->select('entry_date')
        ->where('indices_name', $indices_name)
        ->orderByRaw('ABS(TIMESTAMPDIFF(SECOND, entry_date, ?))', [$target_date])
        ->orderBy('entry_date', 'desc')
        ->first()
        ->entry_date;

      $data['top_industries'] = self::get_industries($data['fund_details'], $closest_entry_date);

      $indices_composition_date = new DateTime($closest_entry_date);

      $fund_code = $data['fund_details']->fund_code;
      $month = $indices_composition_date->format('m');
      $year = $indices_composition_date->format('Y');
      $limit = 5;

      $scrips_query = 'CALL sp_fund_search_portfolio_top_script(?, ?, ?, ?)';
      $data['top_scrips'] = json_encode(DB::select($scrips_query, [$month, $year, $fund_code, $limit]));

      $data['scrip_bias'] = DB::select("
            SELECT fc.*, ic.*
            FROM mpx_fund_composition fc
            JOIN mpx_indices_composition ic
              ON fc.scrip_name = ic.scrip_name
            AND ic.entry_date = ?
            WHERE fc.entry_date = ?
              AND fc.fund_code = ?
              AND ic.indices_name = ?
            ORDER BY fc.content_per DESC
            LIMIT 5
        ", [$closest_entry_date, $closest_entry_date, $fund_code, $data['fund_details']->indices_name]);

      $query = '
        SELECT 
            fc.industry AS fc_industry,
            SUM(fc.content_per) AS total_content_per, 
            SUM(ic.percentage) AS total_percentage
        FROM 
            mpx_fund_composition fc 
        JOIN 
            mpx_indices_composition ic 
        ON 
            fc.industry = ic.industry 
        AND 
            ic.entry_date = \'' . $closest_entry_date . '\' 
        WHERE 
            fc.entry_date = \'' . $closest_entry_date . '\' 
        AND 
            fc.fund_code = \'' . $fund_code . '\' 
        AND 
            ic.indices_name = \'' . $data['fund_details']->indices_name . '\' 
        GROUP BY 
            fc.industry 
        ORDER BY 
            total_content_per DESC
        LIMIT 5
    ';

      $data['industry_bias'] = DB::select(DB::raw($query));

      $toDate = Carbon::createFromFormat('Y-m-d', $target_date);

      $periods = [1, 2, 3, 5];
      $reports = [];

      foreach ($periods as $period) {
        $fromDate = $toDate->copy()->subYears($period)->format('Y-m-d');
        $reports[$period . '_year_report'] = self::r_squareApi($fund_code, $fromDate, $target_date);
      }

      $data['r_square'] = $reports;
    }



    return view('web.ratio-reports.fund_factsheet', $data);
  }

  function fund_factsheet(Request $request)
  {
    // dd('open');
    $user = Auth::user();
    $userId = $user->u_id;

    $data['browser_title'] = 'Fund Factsheet';
    $data['active_menu'] = 'dashboard';

    // Cache disclaimer query result
    $data['disclaimer'] = Cache::remember('disclaimer', 3600, function () {
      return DB::table('fund_watch_disclaimer')->where('status', 1)->value('disclaimer');
    });

    $data['userdetails'] = $userdetails = Cache::remember("user_details_{$userId}", 3600, function () use ($userId) {
      return User::where('u_id', $userId)->first();
    });

    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_datetime->toDateString();
    $data['current_date'] = Carbon::now()->toDateString();
    $data['fiveDaysBeforeExpiry'] = $expiry_datetime->copy()->subDays(5)->toDateString();

    // Cache all funds result
    // $data['all_funds'] = Cache::remember('all_funds', 3600, function () {
    //   return FundMaster::select('fund_name', 'fund_id')->orderBy('fund_name','asc')->where('status', '1')->get();
    // });

    $data['all_funds'] = FundMaster::select('fund_name', 'fund_id')->orderBy('fund_name', 'asc')->where('status', '1')->get();

    if (isset($request->fund_id, $request->to_date)) {

      $selected_fund_id = $request->fund_id;
      $data['fund_details'] = Cache::remember("fund_details_{$selected_fund_id}", 3600, function () use ($selected_fund_id) {
        return FundMaster::where('fund_id', $selected_fund_id)->first();
      });


      $data['index_name'] = $data['fund_details']->indices_name ?? '';

      $request->to_date = $target_date = Carbon::parse($request->to_date)->format('Y-m-d');
      $getData = $request->all();

      $fund_code = $data['fund_details']->fund_code;

      $data['closest_entry_date'] = $closest_entry_date = DB::table('fund_composition')
        ->select('entry_date')
        ->where('fund_code', $fund_code)
        ->where('entry_date', '<', $request->to_date)
        ->orderBy('entry_date', 'desc')
        ->limit(1)
        ->first()?->entry_date ?? null;

      if (isset($closest_entry_date)) {

        $data['jensonAlphaData'] = [
          'six_months' => self::getJensonAlpha($getData, 6),
          'one_year' => self::getJensonAlpha($getData, 1),
          'two_year' => self::getJensonAlpha($getData, 2),
          'three_year' => self::getJensonAlpha($getData, 3),
          'four_year' => self::getJensonAlpha($getData, 4),
          'five_year' => self::getJensonAlpha($getData, 5),
        ];

        // dd('stop');

        // dd($data['jensonAlphaData']);

        $data['sharpeData'] = Cache::remember("sharpeData_{$selected_fund_id}_{$request->to_date}", 3600, function () use ($getData) {
          return [
            'six_months' => self::getSharpe($getData, 6),
            'one_year' => self::getSharpe($getData, 1),
            'two_year' => self::getSharpe($getData, 2),
            'three_year' => self::getSharpe($getData, 3),
            'four_year' => self::getSharpe($getData, 4),
            'five_year' => self::getSharpe($getData, 5),
          ];
        });
        // dd($data['sharpeData']);
        // dd(self::getSharpe($getData, 1));

        $data['treynorData'] = Cache::remember("treynorData_{$selected_fund_id}_{$request->to_date}", 3600, function () use ($getData) {
          return [
            'six_months' => self::getTreynor($getData, 6),
            'one_year' => self::getTreynor($getData, 1),
            'two_year' => self::getTreynor($getData, 2),
            'three_year' => self::getTreynor($getData, 3),
            'four_year' => self::getTreynor($getData, 4),
            'five_year' => self::getTreynor($getData, 5),
          ];
        });

        $data['trackingErrorData'] = Cache::remember("trackingErrorData_{$selected_fund_id}_{$request->to_date}", 3600, function () use ($getData) {
          return [
            'six_months' => self::getTrackingError($getData, 6),
            'one_year' => self::getTrackingError($getData, 1),
            'two_year' => self::getTrackingError($getData, 2),
            'three_year' => self::getTrackingError($getData, 3),
            'four_year' => self::getTrackingError($getData, 4),
            'five_year' => self::getTrackingError($getData, 5),
          ];
        });

        $data['skewness'] = Cache::remember("skewness_{$selected_fund_id}_{$request->to_date}", 3600, function () use ($data, $request) {
          return [
            'six_months' => self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 6),
            'one_year' => self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 1),
            'two_year' => self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 2),
            'three_year' => self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 3),
            'four_year' => self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 4),
            'five_year' => self::skewnessApi($data['fund_details']->fund_code, $request->to_date, 5),
          ];
        });

        $data['kurtosis'] = Cache::remember("kurtosis_{$selected_fund_id}_{$request->to_date}", 3600, function () use ($data, $request) {
          return [
            'six_months' => self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 6),
            'one_year' => self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 1),
            'two_year' => self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 2),
            'three_year' => self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 3),
            'four_year' => self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 4),
            'five_year' => self::kurtosisApi($data['fund_details']->fund_code, $request->to_date, 5),
          ];
        });

        // $data['information_ratio'] = Cache::remember("kurtosis_{$selected_fund_id}_{$request->to_date}", 3600, function () use ($data, $request) {
        //   return [
        //     'six_months' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 6),
        //     'one_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 1),
        //     'two_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 2),
        //     'three_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 3),
        //     'four_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 4),
        //     'five_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 5),
        //   ];
        // });

        $data['information_ratio'] = [
          'six_months' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 6),
          'one_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 1),
          'two_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 2),
          'three_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 3),
          'four_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 4),
          'five_year' => self::informationRatio($data['fund_details']->fund_code, $request->to_date, 5),
        ];

        $data['AAUMValue'] = Cache::remember("AAUMValue_{$selected_fund_id}", 3600, function () use ($data) {
          return SELF::AAUMValue($data['fund_details']->fund_code);
        });

        $indices_name = $data['fund_details']->indices_name;


        // Cache the closest entry date query result
        // $data['closest_entry_date'] = $closest_entry_date = Cache::remember("closest_entry_date_{$indices_name}_{$request->to_date}", 3600, function () use ($indices_name, $target_date) {
        //   return DB::table('indices_composition')
        //     ->select('entry_date')
        //     ->where('indices_name', $indices_name)
        //     ->orderByRaw('ABS(TIMESTAMPDIFF(SECOND, entry_date, ?))', [$target_date])
        //     ->orderBy('entry_date', 'desc')
        //     ->first()
        //     ->entry_date;
        // });

        $data['top_industries'] = self::get_industries($data['fund_details'], $closest_entry_date);

        $indices_composition_date = new DateTime($closest_entry_date);
        $month = $indices_composition_date->format('m');
        $year = $indices_composition_date->format('Y');
        $limit = 10;


        // Cache the stored procedure result
        $data['top_scrips'] = Cache::remember("top_scrips_{$fund_code}_{$month}_{$year}_{$limit}", 3600, function () use ($month, $year, $fund_code, $limit) {
          $scrips_query = 'CALL sp_fund_search_portfolio_top_script(?, ?, ?, ?)';
          return json_encode(DB::select($scrips_query, [$month, $year, $fund_code, $limit]));
        });

        // $data['scrip_bias'] = Cache::remember("scrip_bias_{$fund_code}_{$closest_entry_date}_{$indices_name}", 3600, function() use ($closest_entry_date, $fund_code, $indices_name) {
        //       return DB::select("
        //           SELECT fc.*, ic.*
        //           FROM mpx_fund_composition fc
        //           JOIN mpx_indices_composition ic
        //           ON fc.scrip_name = ic.scrip_name
        //           AND ic.entry_date = ?
        //           WHERE fc.entry_date = ?
        //           AND fc.fund_code = ?
        //           AND ic.indices_name = ?
        //           ORDER BY fc.content_per DESC
        //           LIMIT 5
        //       ", [$closest_entry_date, $closest_entry_date, $fund_code, $indices_name]);
        //   });
        // dd($closest_entry_date, $closest_entry_date, $fund_code, $indices_name);

        $scripBias = DB::table('fund_composition as fc')
          ->select(
            DB::raw('(mpx_fc.content_per - COALESCE(mpx_ic.percentage, 0)) as bias')
          )
          ->leftJoin('indices_composition as ic', function ($join) use ($closest_entry_date, $indices_name) {
            $join->on('fc.scrip_name', '=', 'ic.scrip_name')
              ->where('ic.entry_date', '=', $closest_entry_date)
              ->where('ic.indices_name', '=', $indices_name)
              ->where('ic.type', '=', 'Equity');
          })
          ->where('fc.entry_date', '=', $closest_entry_date)
          ->where('fc.fund_code', '=', $fund_code)
          ->where('fc.category', '=', 'Equity')
          ->orderBy('fc.content_per', 'DESC')
          ->pluck('bias')->toArray();

        $data['scrip_bias']['top_ten_bias'] = 0;
        $data['scrip_bias']['top_twenty_bias'] = 0;
        $data['scrip_bias']['rest_of_bias'] = 0;

        // Calculate sums
        foreach ($scripBias as $index => $value) {
          if ($index < 10) {
            $data['scrip_bias']['top_ten_bias'] += $value;
          } elseif ($index < 20) {
            $data['scrip_bias']['top_twenty_bias'] += $value;
          } else {
            $data['scrip_bias']['rest_of_bias'] += $value;
          }
        }

        // dd($data['scrip_bias']);

        $query = 'WITH FundData AS (
            SELECT 
              fund_code,
              entry_date, 
              industry, 
              SUM(content_per) AS total_content_per, 
              COUNT(industry) AS fc_industry_count
            FROM mpx_fund_composition
            WHERE category = "Equity" AND fund_code = ? AND entry_date = ?
            GROUP BY fund_code, entry_date, industry
          ),
          IndexData AS (
            SELECT 
              entry_date, 
              industry, 
              SUM(percentage) AS total_percentage, 
              COUNT(industry) AS ic_industry_count
            FROM mpx_indices_composition
            WHERE type = "Equity" AND entry_date = ? AND indices_name = ?
            GROUP BY entry_date, industry
          )
          SELECT 
            (fd.total_content_per - COALESCE(id.total_percentage, 0)) AS bias
          FROM FundData fd
          LEFT JOIN IndexData id ON fd.entry_date = id.entry_date AND fd.industry = id.industry
          ORDER BY fd.total_content_per DESC;';

        $industryBias = DB::select(DB::raw($query), [$fund_code, $closest_entry_date, $closest_entry_date, $indices_name]);

        // dd($fund_code, $closest_entry_date, $closest_entry_date, $indices_name,$industryBias);


        $data['industry_bias']['top_ten_bias'] = 0;
        $data['industry_bias']['top_twenty_bias'] = 0;
        $data['industry_bias']['rest_of_bias'] = 0;

        foreach ($industryBias as $index => $value) {
          if ($index < 10) {
            $data['industry_bias']['top_ten_bias'] += $value->bias;
          } elseif ($index < 20) {
            $data['industry_bias']['top_twenty_bias'] += $value->bias;
          } else {
            $data['industry_bias']['rest_of_bias'] += $value->bias;
          }
        }

        $toDate = Carbon::createFromFormat('Y-m-d', $target_date);
        $periods = [1, 2, 3, 5];
        $reports = [];

        foreach ($periods as $period) {
          $fromDate = $toDate->copy()->subYears($period)->format('Y-m-d');
          $reports["{$period}_year_report"] = Cache::remember("r_square_{$fund_code}_{$fromDate}_{$target_date}", 3600, function () use ($fund_code, $fromDate, $target_date) {
            return self::r_squareApi($fund_code, $fromDate, $target_date);
          });
        }

        $data['r_square'] = $reports;
      }


      // Cache the results of these API calls if the data does not change frequently
      // $data['jensonAlphaData'] = Cache::remember("jensonAlphaData_{$selected_fund_id}_{$request->to_date}", 3600, function () use ($getData) {
      //   return [
      //     'six_months' => self::getJensonAlpha($getData, 6),
      //     'one_year' => self::getJensonAlpha($getData, 1),
      //     'two_year' => self::getJensonAlpha($getData, 2),
      //     'three_year' => self::getJensonAlpha($getData, 3),
      //     'four_year' => self::getJensonAlpha($getData, 4),
      //     'five_year' => self::getJensonAlpha($getData, 5),
      //   ];
      // });


    }

    return view('web.ratio-reports.fund_factsheet', $data);
  }

  function getJensonAlpha($getData, $timeSpan)
  {
    // dd($getData);
    $fundDetails = FundMaster::find($getData['fund_id']);
    // dd($fundDetails->fund_code);
    $search_fund_name = $fundDetails->fund_code;
    $search_to_date = date('Y-m-d', strtotime($getData['to_date']));
    if ($timeSpan == 6) {
      $search_from_date = date('Y-m-d', strtotime('-6 months', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 1) {
      $search_from_date = date('Y-m-d', strtotime('-1 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 2) {
      // $search_from_date = date('Y-m-d', strtotime('-730 days', strtotime($getData['to_date'])));
      $search_from_date = date('Y-m-d', strtotime('-2 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 3) {
      // $search_from_date = date('Y-m-d', strtotime('-1095 days', strtotime($getData['to_date'])));
      $search_from_date = date('Y-m-d', strtotime('-3 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 4) {
      $search_from_date = date('Y-m-d', strtotime('-4 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 5) {
      $search_from_date = date('Y-m-d', strtotime('-5 year', strtotime($getData['to_date'])));
    }

    // dd($input);
    $baseUrl = URL::to('/');
    $endpoint = 'report-jensens-alpla-api';

    // Construct the full URL
    $url = $baseUrl . '/' . $endpoint;

    $params = [
      'search_fund_name' => $search_fund_name,
      'search_from_date' => $search_from_date,
      'search_to_date' => $search_to_date,
      'search' => 'Search'
    ];

    // if ($timeSpan == 2) {
    //   dd($params);
    // }

    // Send a GET request to the URL with the query parameters
    $response = Http::get($url, $params);

    // Check if the request was successful
    if ($response->successful()) {
      // Get the data from the response
      $data = $response->json();

      // Handle the data (e.g., return it, save it to the database, etc.)
      // dd($data);

      // if ($timeSpan == 2) {
      //   dd($data);
      // }
      return $data;
    } else {
      // Handle the error
      return response()->json(['error' => 'Failed to fetch data'], 500);
    }
  }

  function getSharpe($getData, $timeSpan)
  {
    // dd($getData);
    $fundDetails = FundMaster::find($getData['fund_id']);
    // dd($fundDetails->fund_code);
    $search_fund_name = $fundDetails->fund_code;
    $search_to_date = $getData['to_date'];
    if ($timeSpan == 6) {
      $search_from_date = date('Y-m-d', strtotime('-6 months', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 1) {
      $search_from_date = date('Y-m-d', strtotime('-1 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 2) {
      $search_from_date = date('Y-m-d', strtotime('-2 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 3) {
      $search_from_date = date('Y-m-d', strtotime('-3 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 4) {
      $search_from_date = date('Y-m-d', strtotime('-4 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 5) {
      $search_from_date = date('Y-m-d', strtotime('-5 year', strtotime($getData['to_date'])));
    }
    // dd($search_from_date);

    // dd($input);
    $baseUrl = URL::to('/');
    $endpoint = 'report-sharpe-api';

    // Construct the full URL
    $url = $baseUrl . '/' . $endpoint;
    // dd($url);

    $params = [
      'search_fund_name' => $search_fund_name,
      'search_from_date' => $search_from_date,
      'search_to_date' => $search_to_date,
      'search' => 'Search'
    ];

    // Send a GET request to the URL with the query parameters
    $response = Http::get($url, $params);

    // Check if the request was successful
    if ($response->successful()) {
      // Get the data from the response
      $data = $response->json();

      // Handle the data (e.g., return it, save it to the database, etc.)
      // dd($data);
      return $data;
    } else {
      // Handle the error
      return response()->json(['error' => 'Failed to fetch data'], 500);
    }
  }

  function getTreynor($getData, $timeSpan)
  {
    // dd($getData);
    $fundDetails = FundMaster::find($getData['fund_id']);
    // dd($fundDetails->fund_code);
    $search_fund_name = $fundDetails->fund_code;
    $search_to_date = $getData['to_date'];
    if ($timeSpan == 6) {
      $search_from_date = date('Y-m-d', strtotime('-6 months', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 1) {
      $search_from_date = date('Y-m-d', strtotime('-1 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 2) {
      $search_from_date = date('Y-m-d', strtotime('-2 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 3) {
      $search_from_date = date('Y-m-d', strtotime('-3 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 4) {
      $search_from_date = date('Y-m-d', strtotime('-4 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 5) {
      $search_from_date = date('Y-m-d', strtotime('-5 year', strtotime($getData['to_date'])));
    }
    // dd($search_from_date);

    // dd($input);
    $baseUrl = URL::to('/');
    $endpoint = 'report-treynor-api';

    // Construct the full URL
    $url = $baseUrl . '/' . $endpoint;

    $params = [
      'search_fund_name' => $search_fund_name,
      'search_from_date' => $search_from_date,
      'search_to_date' => $search_to_date,
      'search' => 'Search'
    ];

    // Send a GET request to the URL with the query parameters
    $response = Http::get($url, $params);

    // Check if the request was successful
    if ($response->successful()) {
      // Get the data from the response
      $data = $response->json();

      // Handle the data (e.g., return it, save it to the database, etc.)
      // dd($data);
      return $data;
    } else {
      // Handle the error
      return response()->json(['error' => 'Failed to fetch data'], 500);
    }
  }

  function getTrackingError($getData, $timeSpan)
  {
    // dd($getData);
    $fundDetails = FundMaster::find($getData['fund_id']);
    // dd($fundDetails->fund_code);
    $search_fund_name = $fundDetails->fund_code;
    $search_to_date = $getData['to_date'];
    if ($timeSpan == 6) {
      $search_from_date = date('Y-m-d', strtotime('-6 months', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 1) {
      $search_from_date = date('Y-m-d', strtotime('-1 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 2) {
      $search_from_date = date('Y-m-d', strtotime('-2 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 3) {
      $search_from_date = date('Y-m-d', strtotime('-3 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 4) {
      $search_from_date = date('Y-m-d', strtotime('-4 year', strtotime($getData['to_date'])));
    } elseif ($timeSpan == 5) {
      $search_from_date = date('Y-m-d', strtotime('-5 year', strtotime($getData['to_date'])));
    }
    // dd($search_from_date);

    // dd($input);
    $baseUrl = URL::to('/');
    $endpoint = 'report-tracking-error-api';

    // Construct the full URL
    $url = $baseUrl . '/' . $endpoint;

    $params = [
      'search_fund_name' => $search_fund_name,
      'search_from_date' => $search_from_date,
      'search_to_date' => $search_to_date,
      'search' => 'Search'
    ];

    // Send a GET request to the URL with the query parameters
    $response = Http::get($url, $params);

    // Check if the request was successful
    if ($response->successful()) {
      // Get the data from the response
      $data = $response->json();

      // Handle the data (e.g., return it, save it to the database, etc.)
      // dd($data);
      return $data;
    } else {
      // Handle the error
      return response()->json(['error' => 'Failed to fetch data'], 500);
    }
  }

  function stats()
  {
    $user = Auth::user();
    $userId = $user->u_id;
    //  dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
    return view('web.ratio-reports.stats', $data);
  }

  function quartile_decile()
  {

    $user = Auth::user();
    $userId = $user->u_id;
    //  dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';
    // dd($data);
    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();
    return view('web.ratio-reports.quartile_decile', $data);
  }

  function comparative()
  {
    $data = self::loggedInUserData();

    $data['browser_title'] = 'Comparative Quartile & Decile';
    $data['active_menu'] = 'dashboard';
    $data['fund_type'] = FundType::get();

    $data['fund_master'] = FundMaster::where('status', 1)->get();

    return view('web.ratio-reports.comparative', $data);
  }

  function common()
  {
    $user = Auth::user();
    $userId = $user->u_id;
    // dd($userId);
    $data['userdetails'] = $userdetails = User::where('u_id', $userId)->first();
    $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
    $data['expiry_date'] = $expiry_date = $expiry_datetime->toDateString();
    // $data['expiry_date']=$expiry_date='2024-04-26';


    $currentDateTime = Carbon::now();
    //  dd($expiry_date);
    $data['current_date'] = $current_date = $currentDateTime->toDateString();
    // $data['current_date']= '2024-04-20';
    //dd($current_date);
    $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
    // dd($fiveDaysBeforeExpiryDate);
    $data['fiveDaysBeforeExpiry'] = $fiveDaysBeforeExpiry = $fiveDaysBeforeExpiryDate->toDateString();

    return $data;
  }

  public function ratio_analysis()
  {
    $data['browser_title']  = 'Ratio Analysis';
    $data['active_menu']  = 'ratio_analysis_list';

    return view('web.auth.ratio_analysis.index', $data, self::common());
  }
  public function composition_report()
  {
    $data['active_menu']  = 'composition_report_list';

    return view('web.auth.composition_report.index', $data, self::common());
  }
  public function indices_report()
  {
    // $data['active_menu']  = 'indices_report_list';

    return view('web.auth.indices_report.index', self::common());
  }
  public function filters()
  {
    $data['active_menu']  = 'filters_list';

    return view('web.auth.filters.index', $data, self::common());
  }

  function get_industries($fund_details, $date)
  {
    $fund_code = $fund_details->fund_code;
    $indices_name = $fund_details->indices_name;

    $query = '(SELECT industry, \'FUND\', SUM(content_per) AS holdings FROM `mpx_fund_composition` WHERE `entry_date` = \'' . $date . '\' AND `fund_code` LIKE \'' . $fund_code . '\' GROUP BY industry ORDER BY SUM(content_per) DESC) ORDER BY holdings DESC LIMIT 10';

    // dd($query);

    $industries = json_encode(DB::select(DB::raw($query)));

    return $industries;
  }

  private function AAUMValue($fund_code)
  {
    // dd($fund_code);
    $numberOfGrapBar = 6;
    $mothsGap = 3;
    $flastMonthDate = $this->Useful->get_last_month();
    $result[] = ['Entry Date', 'Value'];
    for ($i = 0; $i <= $numberOfGrapBar; $i++) {
      $s_date = $flastMonthDate[0];
      $dates = $this->Useful->get_last_month_quatery($s_date, $i * $mothsGap);
      $FUnddata = CorpusEntry::where("fund_code", $fund_code)->where('entry_date', $dates[1])->get(['corpus_entry', 'entry_date'])->toArray();
      if (!empty($FUnddata)) {
        $result[] = [date('M, Y', strtotime($FUnddata[0]['entry_date'])), $FUnddata[0]['corpus_entry'] * 0.01];
      }
    }

    return json_encode($result);
  }

  function skewnessApi($fund_code, $to_date, $timeSpan)
  {

    $search_to_date = $to_date;
    if ($timeSpan == 6) {
      $search_from_date = date('Y-m-d', strtotime('-6 months', strtotime($to_date)));
    } elseif ($timeSpan == 1) {
      $search_from_date = date('Y-m-d', strtotime('-1 year', strtotime($to_date)));
    } elseif ($timeSpan == 2) {
      $search_from_date = date('Y-m-d', strtotime('-2 year', strtotime($to_date)));
    } elseif ($timeSpan == 3) {
      $search_from_date = date('Y-m-d', strtotime('-3 year', strtotime($to_date)));
    } elseif ($timeSpan == 4) {
      $search_from_date = date('Y-m-d', strtotime('-4 year', strtotime($to_date)));
    } elseif ($timeSpan == 5) {
      $search_from_date = date('Y-m-d', strtotime('-5 year', strtotime($to_date)));
    }

    $fund_return = QuartileDecileController::skewnessApi($fund_code, $search_from_date, $search_to_date);
    if (!empty($fund_return)) {
      return $fund_return['skewness'];
    }
    return 0;
  }

  function kurtosisApi($fund_code, $to_date, $timeSpan)
  {

    $search_to_date = $to_date;

    if ($timeSpan == 6) {
      $search_from_date = date('Y-m-d', strtotime('-6 months', strtotime($to_date)));
    } elseif ($timeSpan == 1) {
      $search_from_date = date('Y-m-d', strtotime('-1 year', strtotime($to_date)));
    } elseif ($timeSpan == 2) {
      $search_from_date = date('Y-m-d', strtotime('-2 year', strtotime($to_date)));
    } elseif ($timeSpan == 3) {
      $search_from_date = date('Y-m-d', strtotime('-3 year', strtotime($to_date)));
    } elseif ($timeSpan == 4) {
      $search_from_date = date('Y-m-d', strtotime('-4 year', strtotime($to_date)));
    } elseif ($timeSpan == 5) {
      $search_from_date = date('Y-m-d', strtotime('-5 year', strtotime($to_date)));
    }

    $fund_return = QuartileDecileController::kurtosisApi($fund_code, $search_from_date, $search_to_date);

    if (!empty($fund_return)) {

      return $fund_return['kurtosis'];
    }

    return 0;
  }

  function informationRatio($fund_code, $to_date, $timeSpan)
  {

    $search_to_date = $to_date;

    if ($timeSpan == 6) {
      $search_from_date = date('Y-m-d', strtotime('-6 months', strtotime($to_date)));
    } elseif ($timeSpan == 1) {
      $search_from_date = date('Y-m-d', strtotime('-1 year', strtotime($to_date)));
    } elseif ($timeSpan == 2) {
      $search_from_date = date('Y-m-d', strtotime('-2 year', strtotime($to_date)));
    } elseif ($timeSpan == 3) {
      $search_from_date = date('Y-m-d', strtotime('-3 year', strtotime($to_date)));
    } elseif ($timeSpan == 4) {
      $search_from_date = date('Y-m-d', strtotime('-4 year', strtotime($to_date)));
    } elseif ($timeSpan == 5) {
      $search_from_date = date('Y-m-d', strtotime('-5 year', strtotime($to_date)));
    }

    $fund_return = QuartileDecileController::informationRatioApi($fund_code, $search_from_date, $search_to_date);

    if (!empty($fund_return)) {

      return $fund_return['information_ratio'];
    }

    return 0;
  }

  public static function r_squareApi($fund_code, $start_date, $end_date)
  {
    // dd('informationRatioApi');
    $baseUrl = URL::to('/');
    $endpoint = 'report-r-squere-api';

    // Construct the full URL
    $url = $baseUrl . '/' . $endpoint;
    // dd($url);

    $params = [
      'search_fund_name' => $fund_code,
      'search_from_date' => $start_date,
      'search_to_date' => $end_date,
      'search' => 'Search'
    ];
    $fullUrl = $url . '?' . http_build_query($params);
    // dd($fullUrl);
    // Send a GET request to the URL with the query parameters
    $response = Http::get($url, $params);
    // dd($response);
    // Check if the request was successful
    if ($response->successful()) {
      // Get the data from the response
      $ratioData = $response->json();
    } else {
      $ratioData = [];
    }
    return $ratioData;
  }

  function r_squere_calculator($fund_code, $from_date, $to_date)
  {
    $fundsDatas = FundDetail::where('fund_code', $fund_code)->whereBetween('entry_date', [date("Y-m-d", strtotime($from_date)), date("Y-m-d", strtotime($to_date))])->get();

    $firstFundData = $fundsDatas->first();

    $fund_details = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();

    $indices_names = IndicesMaster::where('name', $fund_details->indices_name)->first();
    if ($indices_names) {
      $indices_name_array = [$indices_names->name, $indices_names->corelation];
    }

    $oneDayBeforeEntryDateFundData = null;

    for ($i = 1; $i <= 10; $i++) {
      $entryDate = date("Y-m-d", strtotime($from_date . " -$i day"));

      $oneDayBeforeEntryDateFundData = FundDetail::where('fund_code', $fund_code)
        ->where('holiday', '<>', 1)
        ->where('entry_date', '=', $entryDate)
        ->first();

      if ($oneDayBeforeEntryDateFundData) {
        break;
      }
    }
    if ($oneDayBeforeEntryDateFundData != null) {
      if (isset($indices_name_array)) {
        $oneDayBeforeEntryDateIndicesDatas = IndicesDetail::whereIn('name', $indices_name_array)->where('entry_date', $oneDayBeforeEntryDateFundData->entry_date)->first();
      } else {
        $oneDayBeforeEntryDateIndicesDatas = IndicesDetail::where('name', $fund_details->indices_name)->where('entry_date', $oneDayBeforeEntryDateFundData->entry_date)->first();
      }
    } elseif ($firstFundData) {
      $oneDayBeforeEntryDateIndicesDatas = IndicesDetail::whereIn('name', $indices_name_array)->where('entry_date', date("Y-m-d", strtotime($firstFundData->entry_date . " -1 day")))->first();
    }

    $fundsDatasArray = $fundsDatas->toArray();

    $start = Carbon::parse(date("Y-m-d", strtotime($from_date)));
    $end = Carbon::parse(date("Y-m-d", strtotime($to_date)));

    $monthsDifference = $start->diffInMonths($end) + 1;
    $getYear = $monthsDifference / 12;

    $allDates = [];

    while ($start->lte($end)) {
      $allDates[] = $start->toDateString();
      $start->addDay();
    }

    $total_fund = 0;
    $total_nav = 0;
    $j = 0;
    $fund_entry_date_array = [];

    foreach ($allDates as $value) {
      $filteredFundRowsData = [];

      $filteredFundRowsData = array_filter($fundsDatasArray, function ($row) use ($value) {
        return $row['entry_date'] === $value && $row['holiday'] != 1;
      });

      $foundFundRowData = reset($filteredFundRowsData);

      if ($foundFundRowData == false) {

        $fundsSingleDatas = FundDetail::where('fund_code', $fund_code)->where('entry_date', date("Y-m-d", strtotime($value)))->first();
        if (!$fundsSingleDatas) {
          $check_weekdeys  = $this->check_weekdeys($value);
          if ($check_weekdeys) {
            $maxAttempts = 29;

            $reset_date = '';
            for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
              if ($attempt == 1) {
                $oneDayAgoDate = Carbon::parse($value)->subDay('1')->toDateString();

                $reset_date = $oneDayAgoDate;
              } else {
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

      if ($foundFundRowData != false) {
        if ($j == 0) {
          if (isset($oneDayBeforeEntryDateFundData->closing_nav) && $oneDayBeforeEntryDateFundData->closing_nav != 0) {
            $total_nav += (($foundFundRowData['closing_nav'] - $oneDayBeforeEntryDateFundData->closing_nav) / $oneDayBeforeEntryDateFundData->closing_nav) * 100;
          } else {
            $total_nav += 0;
          }
          $old_store_fund_value = $foundFundRowData['closing_nav'];
          array_push($fund_entry_date_array, $value);
        } else {
          if (isset($old_store_fund_value)) {
            $total_nav += (($foundFundRowData['closing_nav'] - $old_store_fund_value) / $old_store_fund_value) * 100;
            $old_store_fund_value = $foundFundRowData['closing_nav'];
            array_push($fund_entry_date_array, $value);
          }
        }
        $total_fund += 1;
        $j++;
      }
    }


    if ($total_fund != 0) {
      $average_of_nav = ($total_nav / $total_fund);
    } else {
      $average_of_nav = 0;
    }


    if (isset($indices_name_array)) {
      $indicesDatas = IndicesDetail::whereIn('name', $indices_name_array)->whereIn('entry_date', $fund_entry_date_array)->get();
    } else {
      $indicesDatas = IndicesDetail::where('name', $fund_details->indices_name)->whereIn('entry_date', $fund_entry_date_array)->get();
    }

    $indicesDatasArray = $indicesDatas->toArray();

    $i = 0;
    $sub_of_fund_index_array = [];
    $fund_return_array = [];
    $index_return_array = [];
    foreach ($allDates as $value) {
      $filteredFundRows = [];
      $filteredIndicesRows = [];

      $filteredFundRows = array_filter($fundsDatasArray, function ($row) use ($value) {
        return $row['entry_date'] === $value && $row['holiday'] != 1;
      });

      $foundFundRow = reset($filteredFundRows);

      if ($foundFundRow == false) {
        $fundsSingleDatas = FundDetail::where('fund_code', $fund_code)->where('entry_date', date("Y-m-d", strtotime($value)))->first();

        if (!$fundsSingleDatas) {
          $check_weekdeys  = $this->check_weekdeys($value);
          if ($check_weekdeys) {
            $maxAttemptsFund = 29;

            $reset_date_fund = '';
            for ($attemptFund = 1; $attemptFund <= $maxAttemptsFund; $attemptFund++) {
              if ($attemptFund == 1) {
                $oneDayAgoDate = Carbon::parse($value)->subDay('1')->toDateString();

                $reset_date_fund = $oneDayAgoDate;
              } else {
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
          } else {
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

      if ($foundIndicesRow == false) {

        if (isset($indices_name_array)) {
          $indicesSingleDatas = IndicesDetail::where('name', $indices_name_array)->where('entry_date', date("Y-m-d", strtotime($value)))->first();
        } else {
          $indicesSingleDatas = IndicesDetail::where('name', $fund_details->indices_name)->where('entry_date', date("Y-m-d", strtotime($value)))->first();
        }


        if (!$indicesSingleDatas) {

          $check_weekdeys  = $this->check_weekdeys($value);
          if ($check_weekdeys) {
            $maxIndicesAttemptsDays = 29;

            $reset_indices_date_day = '';
            for ($attemptIndecesDays = 1; $attemptIndecesDays <= $maxIndicesAttemptsDays; $attemptIndecesDays++) {
              if ($attemptIndecesDays == 1) {
                $oneDayAgoDateIndices = Carbon::parse($value)->subDay('1')->toDateString();

                $reset_indices_date_day = $oneDayAgoDateIndices;
              } else {
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
          } else {
            $reset_indices_date_day = '';
            $foundIndicesRow = false;
          }
        }
      }

      if ($foundFundRow != false) {
        if ($i == 0) {
          if (isset($oneDayBeforeEntryDateFundData->closing_nav) && $oneDayBeforeEntryDateFundData->closing_nav != 0) {
            $fund_return = (($foundFundRow['closing_nav'] - $oneDayBeforeEntryDateFundData->closing_nav) / $oneDayBeforeEntryDateFundData->closing_nav) * 100;
          } else {
            $fund_return = 0;
          }
          $fund_closing_store_value = $foundFundRow['closing_nav'];

          if (isset($oneDayBeforeEntryDateIndicesDatas->closing_value) && $oneDayBeforeEntryDateIndicesDatas->closing_value != 0) {
            if (isset($foundIndicesRow['closing_value'])) {
              $index_return = (($foundIndicesRow['closing_value'] - $oneDayBeforeEntryDateIndicesDatas->closing_value) / $oneDayBeforeEntryDateIndicesDatas->closing_value) * 100;
            } else {
              $index_return = 0;
            }
          } else {
            $index_return = 0;
          }

          $index_closing_store_value = isset($foundIndicesRow['closing_value']) ? $foundIndicesRow['closing_value'] : 0;
        } else {
          if (isset($fund_closing_store_value)) {
            if ($fund_closing_store_value != 0) {
              $fund_return = (($foundFundRow['closing_nav'] - $fund_closing_store_value) / $fund_closing_store_value) * 100;
            } else {
              $fund_return = 0;
            }

            $fund_closing_store_value = $foundFundRow['closing_nav'];
          }

          if (isset($index_closing_store_value)) {
            if ($index_closing_store_value != 0) {
              if (isset($foundIndicesRow['closing_value'])) {
                $index_return = (($foundIndicesRow['closing_value'] - $index_closing_store_value) / $index_closing_store_value) * 100;
              } else {
                $index_return = 0;
              }
            } else {
              $index_return = 0;
            }

            $index_closing_store_value = isset($foundIndicesRow['closing_value']) ? $foundIndicesRow['closing_value'] : 0;
          }
        }

        if (isset($index_return)) {
          $sub_of_fund_index  = ($fund_return - $index_return);
          $percentage_change = $index_return;
        } else {
          $sub_of_fund_index  = $fund_return;
          $percentage_change = 0;
        }

        $i++;
        array_push($fund_return_array, $fund_return);
        array_push($index_return_array, $percentage_change);
        array_push($sub_of_fund_index_array, $sub_of_fund_index);
      }
    }

    $data['average_of_nav'] = $average_of_nav ?? 0;
    $data['total_number_of_result'] = $i;

    if (count($sub_of_fund_index_array) > 1) {
      $mean = array_sum($sub_of_fund_index_array) / count($sub_of_fund_index_array);

      $squaredDifferencesSum = array_reduce($sub_of_fund_index_array, function ($carry, $value) use ($mean) {
        return $carry + pow($value - $mean, 2);
      }, 0);
      $data['tracking_error'] = $tracking_error = sqrt($squaredDifferencesSum / (count($sub_of_fund_index_array) - 1));
    } else {
      $data['tracking_error'] = $tracking_error = 0;
    }

    $correlation = $this->correlation($fund_return_array, $index_return_array);

    if ($correlation !== null) {
      $data['correlation'] = $correlation;
    } else {
      $data['correlation'] = 0;
    }
    $data['r_squere'] = $data['correlation'] * $data['correlation'];

    return $data;
  }

  public function correlation($arr1, $arr2)
  {
    $n = count($arr1);

    // Check if both arrays have the same number of elements
    if ($n != count($arr2)) {
      return null; // Correlation is undefined if arrays have different lengths
    }

    $sum1 = array_sum($arr1);
    $sum2 = array_sum($arr2);

    $sum1Sq = array_sum(array_map('pow', $arr1, array_fill(0, $n, 2)));
    $sum2Sq = array_sum(array_map('pow', $arr2, array_fill(0, $n, 2)));

    $pSum = array_sum(array_map(function ($a, $b) {
      return $a * $b;
    }, $arr1, $arr2));

    $numerator = $pSum - (($sum1 * $sum2) / $n);
    $denominator = sqrt(($sum1Sq - pow($sum1, 2) / $n) * ($sum2Sq - pow($sum2, 2) / $n));

    // Avoid division by zero
    if ($denominator == 0) {
      return null; // Correlation is undefined if the denominator is zero
    }

    return $numerator / $denominator;
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

  public function getTopScripTopIndustries(Request $request)
  {
    $results = '';
    if ($request->type == 'scrip') {
      $query = DB::table('fund_composition as fc')
        ->leftJoin('indices_composition as ic', function ($join) use ($request) {
          $join->on('fc.scrip_name', '=', 'ic.scrip_name')
            ->where('ic.entry_date', '=', $request->closestEntryDate)
            ->where('ic.indices_name', '=', $request->indicesName)
            ->where('ic.type', '=', 'Equity');
        })
        ->where('fc.category', 'Equity')
        ->where('fc.entry_date', '=', $request->closestEntryDate)
        ->where('fc.fund_code', '=', $request->fundCode)
        ->orderBy('fc.content_per', 'DESC')
        ->select('fc.scrip_name as show_name', 'fc.content_per as total_content_per', 'ic.percentage as total_percentage');

      // Modify query based on offset type
      if ($request->offset == 'eleven_to_twenty') {
        $query->offset(10)->limit(10);
      } elseif ($request->offset == 'top_ten') {
        $query->limit(10);
      } elseif ($request->offset == 'remaining') {
        $query->offset(20)->limit(PHP_INT_MAX);
      }

      $results = $query->get();

      return response()->json([
        'success' => true,
        'data' => $results
      ]);
    } elseif ($request->type == 'industry') {

      $query = 'WITH FundData AS (
        SELECT 
          fund_code,
          entry_date, 
          industry, 
          SUM(content_per) AS total_content_per, 
          COUNT(industry) AS fc_industry_count
        FROM mpx_fund_composition
        WHERE fund_code = ? AND entry_date = ? AND category = "Equity"
        GROUP BY fund_code, entry_date, industry
      ),
      IndexData AS (
        SELECT 
          entry_date, 
          industry, 
          SUM(percentage) AS total_percentage, 
          COUNT(industry) AS ic_industry_count
        FROM mpx_indices_composition
        WHERE entry_date = ? AND indices_name = ? AND `type` = "Equity"
        GROUP BY entry_date, industry
      )
      SELECT 
        fd.industry AS show_name,
        fd.total_content_per,
        COALESCE(id.total_percentage, 0) AS total_percentage
      FROM FundData fd
      LEFT JOIN IndexData id ON fd.entry_date = id.entry_date AND fd.industry = id.industry
      ORDER BY fd.total_content_per DESC';

      // Modify query based on offset type
      if ($request->offset == 'eleven_to_twenty') {
        $query .= ' LIMIT 10 OFFSET 10;';
      } elseif ($request->offset == 'top_ten') {
        $query .= ' LIMIT 10;';
      } elseif ($request->offset == 'remaining') {
        $query .= ' LIMIT ' . PHP_INT_MAX . ' OFFSET 20;';
      }

      // dd($query);

      // Execute the query
      $results = DB::select(DB::raw($query), [$request->fundCode, $request->closestEntryDate, $request->closestEntryDate,  $request->indicesName]);


      return response()->json([
        'success' => true,
        'data' => $results
      ]);
    }

    return response()->json([
      'success' => false,
      'data' => $results
    ]);
  }
}
