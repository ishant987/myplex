<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CorpusEntry;
use App\Models\User;
use App\Models\FundMaster;
use App\Models\FundType;
use App\Http\Controllers\Web\JensonsalphaAPIController;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use DB;
use App\Lib\Core\Useful;
use App\Models\FundComposition;
use App\Models\IndicesMaster;

class PredictiveController extends Controller
{

    public function __construct()
    {
        $this->Useful = new Useful;
    }

    public function index()
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'By Volatility';
        $data['active_menu'] = 'filters_list';

        return view('web.predictive.index', $data);
    }

    public function jensen_alpha(Request $request)
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'By Jensen Alpha';
        $data['active_menu'] = 'filters_list';
        $data['fundMasterData'] = FundMaster::where('status', 1)->orderBy('fund_name','asc')->get();
        $data['graph_date'] = [];
        $data['nav_value'] = [];
        $data['closing_value'] = [];

        if ($request->hasAny(['fund_id', 'expected_index', 'duration'])) {
            $validated = $request->validate([
                'fund_id' => 'required|integer',
                'expected_index' => 'required|numeric|min:0.01',
                'duration' => 'required|in:6,1',
                'current_date' => 'nullable|date',
            ], [
                'fund_id.required' => 'Please select a fund.',
                'expected_index.required' => 'Please enter the expected future index value.',
            ]);

            $data['getData'] = $request->all();
            $data['expected_index'] = (float) $validated['expected_index'];
            $fundDetails = FundMaster::where('status', 1)->where('fund_id', $validated['fund_id'])->firstOrFail();
            $indicesDetails = IndicesMaster::where('status', 1)
                ->where('name', $fundDetails->indices_name)
                ->first();

            $data['fund_details'] = $fundDetails;
            $data['indices_details'] = $indicesDetails;

            if (!$indicesDetails) {
                return back()->withInput()->withErrors([
                    'fund_id' => 'The selected fund does not have an active benchmark index.',
                ]);
            }

            $endDate = !empty($validated['current_date'])
                ? Carbon::parse($validated['current_date'])->toDateString()
                : (DB::table('fund_detail')->where('fund_code', $fundDetails->fund_code)->where('publish', 'y')->max('entry_date') ?: now()->toDateString());
            $pointCount = (int) $validated['duration'] === 1 ? 12 : 6;

            $navRows = DB::table('fund_detail')
                ->where('fund_code', $fundDetails->fund_code)
                ->where('publish', 'y')
                ->where('entry_date', '<=', $endDate)
                ->orderBy('entry_date', 'desc')
                ->limit($pointCount)
                ->get()
                ->sortBy('entry_date')
                ->values();

            $indexRows = DB::table('indices_detail')
                ->where('name', $indicesDetails->corelation)
                ->where('publish', 'y')
                ->where('holiday', 0)
                ->where('entry_date', '<=', $endDate)
                ->orderBy('entry_date', 'desc')
                ->limit($pointCount)
                ->get()
                ->sortBy('entry_date')
                ->keyBy('entry_date');

            $graphDates = [];
            $navValues = [];
            $indexValues = [];

            foreach ($navRows as $navRow) {
                $indexRow = $indexRows->get($navRow->entry_date);

                if (!$indexRow) {
                    continue;
                }

                $graphDates[] = $navRow->entry_date;
                $navValues[] = round((float) $navRow->closing_nav, 2);
                $indexValues[] = round((float) $indexRow->closing_value, 2);
            }

            if (count($graphDates) < 2) {
                return back()->withInput()->withErrors([
                    'fund_id' => 'At least two matching published NAV and benchmark points are required.',
                ]);
            }

            $alphaValues = [];
            for ($index = 1; $index < count($graphDates); $index++) {
                $previousNav = $navValues[$index - 1];
                $previousIndex = $indexValues[$index - 1];

                if ($previousNav == 0.0 || $previousIndex == 0.0) {
                    continue;
                }

                $fundReturn = (($navValues[$index] - $previousNav) / $previousNav) * 100;
                $benchmarkReturn = (($indexValues[$index] - $previousIndex) / $previousIndex) * 100;
                $alphaValues[] = $fundReturn - $benchmarkReturn;
            }

            $averageAlpha = count($alphaValues) > 0 ? array_sum($alphaValues) / count($alphaValues) : 0.0;
            $lastNav = (float) end($navValues);
            $lastIndex = (float) end($indexValues);
            $expectedIndex = (float) $validated['expected_index'];
            $expectedIndexReturn = $lastIndex != 0.0 ? (($expectedIndex - $lastIndex) / $lastIndex) * 100 : 0.0;
            $projectedNav = round(max(0, $lastNav * (1 + (($expectedIndexReturn + $averageAlpha) / 100))), 2);
            $projectionDate = Carbon::parse(end($graphDates))
                ->addMonths((int) $validated['duration'] === 1 ? 12 : 6)
                ->toDateString();

            $graphDates[] = $projectionDate;
            $navValues[] = $projectedNav;
            $indexValues[] = $expectedIndex;

            $data['graph_date'] = $graphDates;
            $data['nav_value'] = $navValues;
            $data['closing_value'] = $indexValues;
            $data['average_jensen_alpha'] = round($averageAlpha, 2);
        }

        $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();
        $data['disclaimer'] = $disclaimerQuery->disclaimer ?? 'Predictive values are illustrative and derived from historical local demo data.';

        return view('web.predictive.jensen_alpha', $data);
    }

    public function sharp_ratio(Request $request)
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title']  = 'By Volatility';
        $data['active_menu']    = 'filters_list';
        $data['fundMasterData'] = FundMaster::where('status', 1)->orderBy('fund_name','asc')->get();

        $getdata = $request->all();

        if (isset($getdata) && count($getdata) > 0) {

            // dd($getdata);

            $time_frame = intval($getdata['duration']);
            // $time_frame = 6;

            $request->validate(

                [
                    'fund_id'   => 'required',
                    'expected_index'   => 'required',
                ],
                [
                    'fund_id' . 'required' => 'Please Select Fund for Searching',
                    'expected_index' . 'required' => 'Please Select Year for Searching',
                ]

            );

            $data['getData'] = $request->all();

            $fund_id = $request->fund_id;

            $data['fund_details'] = $fund_details = FundMaster::where('status', 1)->where('fund_id', $fund_id)->first();

            $data['indices_details'] = $indices_details = IndicesMaster::where('status', 1)
                ->where('name', $fund_details->indices_name)->first();

            // $currentDate = date('Y-m-d');

            $currentDate = date('Y-m-d', strtotime($getdata['current_date']));

            // dd($currentDate);

            $date_array = [date('Y-m-d', strtotime($getdata['current_date']))];

            for ($i = 1; $i <= 4; $i++) {

                if ($time_frame == 6) {

                    $one_half_date = date('Y-m-d', strtotime('-45 days', strtotime($currentDate)));

                    array_push($date_array, $one_half_date);

                    $currentDate = $one_half_date;
                } else if ($time_frame == 1) {

                    $three_month_ago =  date('Y-m-d', strtotime('-3 months', strtotime($currentDate)));

                    array_push($date_array, $three_month_ago);

                    $currentDate = $three_month_ago;
                }
            }

            // echo"<pre>";print_r($date_array);


            sort($date_array);

            // echo"<pre>";print_r($date_array);

            $start_date = $date_array[0];
            $end_date = $date_array[1];

            $jenson_alpha_values = 0;
            $jenson_alpha_values_array = [];

            for ($j = 1; $j < count($date_array); $j++) {

                // echo $start_date." --".$end_date."<br>";

                // $fund_return = self::sharpeApi($fund_details->fund_code, $start_date, $end_date);
                $fund_return = QuartileDecileController::sharpeApi($fund_details->fund_code, $start_date, $end_date);
                // dd($fund_return);

                if (!empty($fund_return)) {
                    $jenson_alpha_values += floatval($fund_return['sharpe']);
                    array_push($jenson_alpha_values_array, $fund_return['sharpe']);
                }

                // echo floatval($fund_return['sharpe']) . "</br>" ;

                // echo $j."--".$date_array[$j]."<br>";

                $start_date = $end_date;
                if (isset($date_array[$j + 1])) {
                    $end_date = $date_array[$j + 1];
                } else {
                    break; // Exit the loop if the next end_date doesn't exist
                }
            }
            // die;
            // dd($jenson_alpha_values);
            $avg_jenson_alpha = ($jenson_alpha_values / 4);

            // dd($avg_jenson_alpha);

            $closing_nav_array = [];
            $closing_value_array = [];

            // dd($date_array);

            for ($c = 1; $c < count($date_array); $c++) {

                // Fetching the closing NAV for the given fund_code and entry_date
                $closing_nav = DB::table('fund_detail')
                    ->where('fund_code', $fund_details->fund_code)
                    ->where('entry_date', '<=', $date_array[$c])
                    ->orderBy('entry_date', 'desc')
                    ->first();

                // Fetching the closing value for the given indices name and entry_date
                $closing_value = DB::table('indices_detail')
                    ->select('indices_detail.*')
                    ->leftJoin('indices_master', 'indices_master.corelation', '=', 'indices_detail.correlation_new')
                    ->where('indices_master.name', $fund_details->indices_name)
                    ->where('indices_detail.entry_date', '<=', $date_array[$c])
                    ->orderBy('indices_detail.entry_date', 'desc')
                    ->first();

                // echo $date_array[$c] . '</br>';

                // echo "indices_name==".$fund_details->name;
                // echo "<pre>";
                // print_r($closing_nav);

                // echo "indices_name==".$fund_details->indices_name;
                // echo "<pre>";
                // print_r($closing_value);

                array_push($closing_nav_array, $closing_nav->closing_nav);
                array_push($closing_value_array, $closing_value->closing_value);
            }
            // die;

            $last_closing_val = end($closing_value_array);

            if ($last_closing_val > intval($request->expected_index)) {

                $diff_expected_index_and_last_closing_val = $last_closing_val -  intval($request->expected_index);

                $percentage_diff_expected_index_and_last_closing_val = ($diff_expected_index_and_last_closing_val * 100) / $last_closing_val;

                $percentage_of_avg_jnsnalpha = $percentage_diff_expected_index_and_last_closing_val * ($avg_jenson_alpha / 100);

                $added_percentage = $percentage_of_avg_jnsnalpha + $percentage_diff_expected_index_and_last_closing_val;

                $final_closing_nav = end($closing_nav_array) - ((end($closing_nav_array) * $added_percentage) / 100);

                $final_closing_nav = round($final_closing_nav, 2);
            } else if ($last_closing_val < intval($request->expected_index)) {

                $diff_expected_index_and_last_closing_val = intval($request->expected_index) -  $last_closing_val;

                $percentage_diff_expected_index_and_last_closing_val = ($diff_expected_index_and_last_closing_val * 100) / $last_closing_val;

                $percentage_of_avg_jnsnalpha = $percentage_diff_expected_index_and_last_closing_val * ($avg_jenson_alpha / 100);

                $added_percentage = $percentage_of_avg_jnsnalpha + $percentage_diff_expected_index_and_last_closing_val;

                $final_closing_nav = end($closing_nav_array) + ((end($closing_nav_array) * $added_percentage) / 100);

                $final_closing_nav = round($final_closing_nav, 2);
            }


            array_push($closing_nav_array, $final_closing_nav);

            $graph_date_array = array_slice($date_array, 1);

            if ($time_frame == 6) {

                $currentDate = date('Y-m-d', strtotime($getdata['current_date']));
                $dateupcoming = date('Y-m-d', strtotime('+6 months', strtotime($currentDate)));
            } else if ($time_frame == 1) {

                $currentDate = date('Y-m-d', strtotime($getdata['current_date']));
                $dateupcoming = date('Y-m-d', strtotime('+1 year', strtotime($currentDate)));
            }
            $data['expected_index'] = $request->expected_index;
            array_push($graph_date_array, $dateupcoming);
            array_push($closing_value_array, floatval($request->expected_index));

            $data['graph_date'] = $graph_date_array;
            $data['nav_value'] =  $closing_nav_array;
            $data['closing_value'] = $closing_value_array;

            // dd($data);
        }

        $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();

        // dd($disclaimerQuery->disclaimer);
    
        $data['disclaimer'] = $disclaimerQuery->disclaimer;

        return view('web.predictive.sharp_ratio', $data);
    }

    public function trenyor(Request $request)
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'By Volatility';
        $data['active_menu'] = 'filters_list';
        $data['fundMasterData'] = FundMaster::where('status', 1)->orderBy('fund_name','asc')->get();

        $getdata = $request->all();

        if (isset($getdata) && count($getdata) > 0) {

            // dd($getdata);

            $time_frame = intval($getdata['duration']);
            // $time_frame = 6;

            $request->validate(

                [
                    'fund_id'   => 'required',
                    'expected_index'   => 'required',
                ],
                [
                    'fund_id' . 'required' => 'Please Select Fund for Searching',
                    'expected_index' . 'required' => 'Please Select Year for Searching',
                ]

            );

            $data['getData'] = $request->all();

            $fund_id = $request->fund_id;

            $data['fund_details'] = $fund_details = FundMaster::where('status', 1)->where('fund_id', $fund_id)->first();

            $data['indices_details'] = $indices_details = IndicesMaster::where('status', 1)
                ->where('name', $fund_details->indices_name)->first();

            // $currentDate = date('Y-m-d');

            $currentDate = date('Y-m-d', strtotime($getdata['current_date']));

            // dd($currentDate);

            $date_array = [date('Y-m-d', strtotime($getdata['current_date']))];

            for ($i = 1; $i <= 4; $i++) {

                if ($time_frame == 6) {

                    $one_half_date = date('Y-m-d', strtotime('-45 days', strtotime($currentDate)));

                    array_push($date_array, $one_half_date);

                    $currentDate = $one_half_date;
                } else if ($time_frame == 1) {

                    $three_month_ago =  date('Y-m-d', strtotime('-3 months', strtotime($currentDate)));

                    array_push($date_array, $three_month_ago);

                    $currentDate = $three_month_ago;
                }
            }

            // echo"<pre>";print_r($date_array);


            sort($date_array);

            // echo"<pre>";print_r($date_array);

            $start_date = $date_array[0];
            $end_date = $date_array[1];

            $jenson_alpha_values = 0;
            $jenson_alpha_values_array = [];

            for ($j = 1; $j < count($date_array); $j++) {

                // echo $start_date." --".$end_date."<br>";

                // $fund_return = self::treynorApi($fund_details->fund_code, $start_date, $end_date);
                $fund_return = QuartileDecileController::treynorApi($fund_details->fund_code, $start_date, $end_date);
                // dd($fund_return);

                if (!empty($fund_return)) {
                    $jenson_alpha_values += floatval($fund_return['treynor']);
                    array_push($jenson_alpha_values_array, $fund_return['treynor']);
                }

                // echo $j."--".$date_array[$j]."<br>";

                $start_date = $end_date;
                if (isset($date_array[$j + 1])) {
                    $end_date = $date_array[$j + 1];
                } else {
                    break; // Exit the loop if the next end_date doesn't exist
                }
            }
            // die;
            // dd($jenson_alpha_values);
            $avg_jenson_alpha = ($jenson_alpha_values / 4);

            $closing_nav_array = [];
            $closing_value_array = [];

            // dd($date_array);

            for ($c = 1; $c < count($date_array); $c++) {

                // Fetching the closing NAV for the given fund_code and entry_date
                $closing_nav = DB::table('fund_detail')
                    ->where('fund_code', $fund_details->fund_code)
                    ->where('entry_date', '<=', $date_array[$c])
                    ->orderBy('entry_date', 'desc')
                    ->first();

                // Fetching the closing value for the given indices name and entry_date
                $closing_value = DB::table('indices_detail')
                    ->select('indices_detail.*')
                    ->leftJoin('indices_master', 'indices_master.corelation', '=', 'indices_detail.correlation_new')
                    ->where('indices_master.name', $fund_details->indices_name)
                    ->where('indices_detail.entry_date', '<=', $date_array[$c])
                    ->orderBy('indices_detail.entry_date', 'desc')
                    ->first();

                // echo $date_array[$c] . '</br>';

                // echo "indices_name==".$fund_details->name;
                // echo "<pre>";
                // print_r($closing_nav);

                // echo "indices_name==".$fund_details->indices_name;
                // echo "<pre>";
                // print_r($closing_value);

                array_push($closing_nav_array, $closing_nav->closing_nav);
                array_push($closing_value_array, $closing_value->closing_value);
            }
            // die;

            $last_closing_val = end($closing_value_array);

            if ($last_closing_val > intval($request->expected_index)) {

                $diff_expected_index_and_last_closing_val = $last_closing_val -  intval($request->expected_index);

                $percentage_diff_expected_index_and_last_closing_val = ($diff_expected_index_and_last_closing_val * 100) / $last_closing_val;

                $percentage_of_avg_jnsnalpha = $percentage_diff_expected_index_and_last_closing_val * ($avg_jenson_alpha / 100);

                $added_percentage = $percentage_of_avg_jnsnalpha + $percentage_diff_expected_index_and_last_closing_val;

                $final_closing_nav = end($closing_nav_array) - ((end($closing_nav_array) * $added_percentage) / 100);

                $final_closing_nav = round($final_closing_nav, 2);
            } else if ($last_closing_val < intval($request->expected_index)) {

                $diff_expected_index_and_last_closing_val = intval($request->expected_index) -  $last_closing_val;

                $percentage_diff_expected_index_and_last_closing_val = ($diff_expected_index_and_last_closing_val * 100) / $last_closing_val;

                $percentage_of_avg_jnsnalpha = $percentage_diff_expected_index_and_last_closing_val * ($avg_jenson_alpha / 100);

                $added_percentage = $percentage_of_avg_jnsnalpha + $percentage_diff_expected_index_and_last_closing_val;

                $final_closing_nav = end($closing_nav_array) + ((end($closing_nav_array) * $added_percentage) / 100);

                $final_closing_nav = round($final_closing_nav, 2);
            }


            array_push($closing_nav_array, $final_closing_nav);

            $graph_date_array = array_slice($date_array, 1);

            if ($time_frame == 6) {

                $currentDate = date('Y-m-d', strtotime($getdata['current_date']));
                $dateupcoming = date('Y-m-d', strtotime('+6 months', strtotime($currentDate)));
            } else if ($time_frame == 1) {

                $currentDate = date('Y-m-d', strtotime($getdata['current_date']));
                $dateupcoming = date('Y-m-d', strtotime('+1 year', strtotime($currentDate)));
            }
            $data['expected_index'] = $request->expected_index;
            array_push($graph_date_array, $dateupcoming);
            array_push($closing_value_array, floatval($request->expected_index));

            $data['graph_date'] = $graph_date_array;
            $data['nav_value'] =  $closing_nav_array;
            $data['closing_value'] = $closing_value_array;

            // dd($data);
        }

        $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();

        // dd($disclaimerQuery->disclaimer);
    
        $data['disclaimer'] = $disclaimerQuery->disclaimer;

        return view('web.predictive.trenyor', $data);
    }

    public function fund_details(Request $request)
    {
        if (isset($request['id'])) {
            $fund_detail = DB::table('fund_master')
                ->select('indices_detail.entry_date', 'indices_detail.closing_value', 'indices_master.name')
                ->join('indices_master', 'fund_master.indices_name', '=', 'indices_master.name')
                ->join('indices_detail', 'indices_master.corelation', '=', 'indices_detail.name')
                ->where('fund_master.fund_id', $request['id'])
                ->where('indices_detail.holiday', 0)
                ->where('indices_detail.publish', 'y')
                ->orderBy('indices_detail.entry_date', 'desc')
                ->first();

            if (!$fund_detail) {
                return response()->json([
                    'entry_date' => 'N/A',
                    'current_date' => null,
                    'closing_value' => 0.0,
                    'name' => 'N/A',
                ], 200);
            }

            return response()->json([
                'entry_date' => Carbon::parse($fund_detail->entry_date)->format('d-m-Y'),
                'current_date' => $fund_detail->entry_date,
                'closing_value' => round((float) $fund_detail->closing_value, 2),
                'name' => $fund_detail->name,
            ], 200);
        }
    }


    public static function jensenalphaApi($fund_code, $start_date, $end_date)
    {
        $baseUrl = URL::to('/');
        $endpoint = 'report-jensens-alpla-api-predictive';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,
            'search' => 'Search'
        ];

        // Send a GET request to the URL with the query parameters
        $response = Http::get($url, $params);

        // Check if the request was successful
        if ($response->successful()) {
            // Get the data from the response
            $ratioData = $response->json();
        } else {
            $ratioData = [];
        }
        return $ratioData;
    }


    public static function sharpeApi($fund_code, $start_date, $end_date)
    {
        $baseUrl = URL::to('/');
        $endpoint = 'report-sharpe-api';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,
            'search' => 'Search'
        ];

        // Send a GET request to the URL with the query parameters
        $response = Http::get($url, $params);

        // Check if the request was successful
        if ($response->successful()) {
            // Get the data from the response
            $ratioData = $response->json();
        } else {
            $ratioData = [];
        }
        return $ratioData;
    }

    public static function treynorApi($fund_code, $start_date, $end_date)
    {
        $baseUrl = URL::to('/');
        $endpoint = 'report-treynor-api';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,
            'search' => 'Search'
        ];

        // Send a GET request to the URL with the query parameters
        $response = Http::get($url, $params);

        // Check if the request was successful
        if ($response->successful()) {
            // Get the data from the response
            $ratioData = $response->json();
        } else {
            $ratioData = [];
        }
        return $ratioData;
    }
}
