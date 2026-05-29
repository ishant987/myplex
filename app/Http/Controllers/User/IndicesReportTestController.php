<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CorpusEntry;
use App\Models\User;
use App\Models\FundMaster;
use App\Models\FundType;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\IndicesDetail;
use App\Models\IndicesMaster;

// use DB;
use App\Lib\Core\Useful;
use App\Models\FundComposition;
use App\Models\FundDetail;

class IndicesReportTestController extends Controller
{
    public function indices_report()
    {
        // dd('hi');
        $data = RatioController::loggedInUserData();
        $data['active_menu']  = 'indices_report_list';

        // dd($data['active_menu']);
        return view('web.indices-reports.index', $data);
    }

    public function indices_history(Request $request)
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'Indices History';
        $data['active_menu'] = 'indices_report_list';
        $data['indices'] = IndicesMaster::where('status', 1)->get();
        $data['indices_vals'] = [];
        $data['request'] = $request->all();
        // dd($data);
        // Validate the request inputs
        // $request->validate([
        //     'indices' => 'required|array',
        //     'start_date' => 'required|date',
        //     'end_date' => 'required|date|after_or_equal:start_date',
        // ]);

        if (!empty($request->input('indices'))) {
            $indices = $request->input('indices');
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));

            foreach ($indices as $index) {
                $closingValues = IndicesDetail::where('correlation_new', $index)
                    ->whereBetween('entry_date', [$startDate, $endDate])
                    ->orderBy('entry_date')
                    ->pluck('closing_value', 'entry_date')
                    ->toArray();

                if (!empty($closingValues)) {
                    // Format data for Google Charts API
                    $chartData = [['Date', 'Closing Value']];
                    foreach ($closingValues as $date => $value) {
                        $chartData[] = [Carbon::parse($date)->toDateString(), (float) $value];
                    }

                    $data['indices_vals'][$index] = $chartData;
                } else {
                    // Handle case where no data is found
                    $data['indices_vals'][$index] = [['Date', 'Closing Value'], ['No data available', 0]];
                }
            }
        }
        // dd($data);
        // dd(count($data['indices_vals']));

        return view('web.indices-reports.indices-history', $data);
    }



    // public function indiceFetchData(Request $request)
    // {
    //     $indices = $request->input('indices');
    //     $startDate = Carbon::parse($request->input('start_date'));
    //     $endDate = Carbon::parse($request->input('end_date'));

    //     $data = IndicesDetail::whereIn('correlation_new', $indices)
    //                  ->whereBetween('entry_date', [$startDate, $endDate])
    //                  ->get();

    //     return response()->json($data);
    // }
    public function indiceFetchData(Request $request)
    {
        dd($request->all());
        // $request->validate([
        //     'indices' => 'required|array',
        //     'indices.*' => 'exists:indices_master,corelation',
        //     'start_date' => 'required|date',
        //     'end_date' => 'required|date|after_or_equal:start_date',
        // ]);


    }


    public function indices_composition()
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'Indices Composition';
        $data['active_menu'] = 'indices_report_list';

        return view('web.indices-reports.indices-composition', $data);
    }

    public function schemes_associated_with_index(Request $request)
    {
        $data = RatioController::loggedInUserData();

        $data['browser_title'] = 'Schemes Associated With Index';
        $data['active_menu'] = 'indices_report_list';
        $data['request'] = $request;
        $data['indices'] = IndicesMaster::where('status', 1)->get();
        // dd($data['indices']);
        $data['all_schemes'] = [];
        if (!empty($request->all())) {
            $date = date('Y-m-d', strtotime($request->date));
            $query = DB::select("SELECT `master`.*, `detail`.`closing_nav` FROM `mpx_fund_master` AS `master` INNER JOIN `mpx_fund_detail` AS `detail` ON `detail`.`fund_code`=`master`.`fund_code`  WHERE `master`.`indices_name`='$request->selected_index' AND `detail`.`entry_date`='$date'");

            // dd("SELECT `master`.*, `detail`.`closing_nav` FROM `mpx_fund_master` AS `master` INNER JOIN `mpx_fund_detail` AS `detail` ON `detail`.`fund_code`=`master`.`fund_code`  WHERE `master`.`indices_name`='$request->selected_index' AND `detail`.`entry_date`='$request->date'");

            // dd($query);
            $data['all_schemes'] = $query;
        }


        return view('web.indices-reports.schemes-associated-with-index', $data);
    }

    public function boomers(Request $request)
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'Boomers';
        $data['active_menu'] = 'indices_report_list';


        $getdata = $request->all();

        if (isset($getdata) && count($getdata) > 0) {

            $data['classification'] = $classification = $getdata['classification'];
            $data['month'] = $month = $getdata['month'];
            $data['year'] = $year = $getdata['year'];
            $data['month_second'] = $month_second = $getdata['month_second'];
            $data['year_second'] = $year_second = $getdata['year_second'];
            $data['limit'] = $limit = $getdata['limit'];

            $startDate = $this->getlastdate($month, $year);
            $endDate = $this->getlastdate($month_second, $year_second);

            $fund_code_array = [];

            if ($classification == 'classification') {

                $data['get_fund_type'] = $get_fund_type = $getdata['fund_type'];

                $type_wise_fund = FundMaster::where('status', 1)->where('fund_type_id', $get_fund_type)->get();

                foreach ($type_wise_fund as $val) {

                    // $fund_code_str = "".$val->fund_code."";
                    array_push($fund_code_array, $val->fund_code);
                }

                $data['fund_type_get_data'] = FundType::where('ft_id', $get_fund_type)->first();

                //    $results_classification = FundComposition::select([
                //     'fc1.scrip_name',
                //     'fc1.content_per as content_per_new',
                //     'fc2.content_per as content_per_old'
                // ])
                // ->join('fund_composition as fc2', 'fc1.scrip_name', '=', 'fc2.scrip_name')
                // ->whereIn('fc1.fund_code', $fund_code_array)
                // ->where('fc1.entry_date', 'LIKE', '%' . $endDate . '%')
                // ->where('fc2.entry_date', 'LIKE', '%' . $startDate . '%')
                // ->groupBy('fc1.scrip_name')
                // ->limit($limit)
                // ->get();


                /*--------for scrips--------*/

                $results_classification_scrips = DB::table('fund_composition as fc1')
                    ->join('fund_composition AS fc2', function ($join) {
                        $join->on('fc1.scrip_name', '=', 'fc2.scrip_name')
                            ->on('fc1.fund_code', '=', 'fc2.fund_code');
                    })
                    ->select(
                        'fc1.scrip_name',
                        'fc1.fund_code',
                        'fc1.content_per as content_per_new',
                        'fc2.content_per AS content_per_old'
                    )
                    ->whereIn('fc1.fund_code', $fund_code_array)
                    ->where('fc1.entry_date', '=', $endDate)
                    ->where('fc2.entry_date', '=', $startDate)
                    ->limit($limit)
                    ->get();

                /*--------for industry--------*/

                $results_classification_industry = DB::table('fund_composition as fc1')
                    ->join('fund_composition AS fc2', function ($join) {
                        $join->on('fc1.industry', '=', 'fc2.industry')
                            ->on('fc1.fund_code', '=', 'fc2.fund_code');
                    })
                    ->select(
                        'fc1.industry',
                        'fc1.fund_code',
                        'fc1.content_per as content_per_new',
                        'fc2.content_per AS content_per_old'
                    )
                    ->whereIn('fc1.fund_code', $fund_code_array)
                    ->where('fc1.entry_date', '=', $endDate)
                    ->where('fc2.entry_date', '=', $startDate)
                    ->limit($limit)
                    ->get();




                $data['results_scrips'] = $results_classification_scrips;

                $data['results_industry'] = $results_classification_industry;



                // $data['boomers_records'] = $results_classification;



            } else if ($classification == 'fund') {

                $data['get_fund_master'] = $get_fund_master = $getdata['fund_master'];

                /*--------for scrips--------*/

                $results_funds_scrips = DB::table('fund_composition as fc1')
                    ->join('fund_composition AS fc2', function ($join) {
                        $join->on('fc1.scrip_name', '=', 'fc2.scrip_name')
                            ->on('fc1.fund_code', '=', 'fc2.fund_code');
                    })
                    ->select(
                        'fc1.scrip_name',
                        'fc1.fund_code',
                        'fc1.content_per as content_per_new',
                        'fc2.content_per AS content_per_old'
                    )
                    ->where('fc1.fund_code', $get_fund_master)
                    ->where('fc1.entry_date', '=', $endDate)
                    ->where('fc2.entry_date', '=', $startDate)
                    ->limit($limit)
                    ->get();

                /*--------for industry--------*/

                $results_fund_industry = DB::table('fund_composition as fc1')
                    ->join('fund_composition AS fc2', function ($join) {
                        $join->on('fc1.industry', '=', 'fc2.industry')
                            ->on('fc1.fund_code', '=', 'fc2.fund_code');
                    })
                    ->select(
                        'fc1.industry',
                        'fc1.fund_code',
                        'fc1.content_per as content_per_new',
                        'fc2.content_per AS content_per_old'
                    )
                    ->where('fc1.fund_code', $get_fund_master)
                    ->where('fc1.entry_date', '=', $endDate)
                    ->where('fc2.entry_date', '=', $startDate)
                    ->limit($limit)
                    ->get();




                $data['results_scrips'] = $results_funds_scrips;

                $data['results_industry'] = $results_fund_industry;
            }

            // dd($data);

        }

        $months = [];
        $years = [];
        for ($i = 1; $i <= 12; $i++) {
            // $months_array = $i .'=>'. date('F', mktime(0, 0, 0, $i, 10));
            $months_array = $i;

            array_push($months, $months_array);
        }

        $start_year = intval(date('Y')) - 5;

        for ($i = $start_year; $i <= date('Y'); $i++) {
            $year_array = $i;
            array_push($years, $year_array);
        }

        $data['months'] = $months;
        $data['years'] = $years;

        $data['mpx_fund_scrips'] = DB::table('scrips')->groupBy('actual_scrip')->get();

        $data['fund_type'] = FundType::get();

        $data['fund_master'] = FundMaster::where('status', 1)->get();

        return view('web.indices-reports.boomers', $data);
    }

    public function busters(Request $request)
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'Busters';
        $data['active_menu'] = 'indices_report_list';

        $getdata = $request->all();

        if (isset($getdata) && count($getdata) > 0) {

            $data['classification'] = $classification = $getdata['classification'];
            $data['month'] = $month = $getdata['month'];
            $data['year'] = $year = $getdata['year'];
            $data['month_second'] = $month_second = $getdata['month_second'];
            $data['year_second'] = $year_second = $getdata['year_second'];
            $data['limit'] = $limit = $getdata['limit'];

            $startDate = $this->getlastdate($month, $year);
            $endDate = $this->getlastdate($month_second, $year_second);

            $fund_code_array = [];

            if ($classification == 'classification') {

                $data['get_fund_type'] = $get_fund_type = $getdata['fund_type'];

                $type_wise_fund = FundMaster::where('status', 1)->where('fund_type_id', $get_fund_type)->get();

                foreach ($type_wise_fund as $val) {

                    // $fund_code_str = "".$val->fund_code."";
                    array_push($fund_code_array, $val->fund_code);
                }

                $data['fund_type_get_data'] = FundType::where('ft_id', $get_fund_type)->first();

                //    $results_classification = FundComposition::select([
                //     'fc1.scrip_name',
                //     'fc1.content_per as content_per_new',
                //     'fc2.content_per as content_per_old'
                // ])
                // ->join('fund_composition as fc2', 'fc1.scrip_name', '=', 'fc2.scrip_name')
                // ->whereIn('fc1.fund_code', $fund_code_array)
                // ->where('fc1.entry_date', 'LIKE', '%' . $endDate . '%')
                // ->where('fc2.entry_date', 'LIKE', '%' . $startDate . '%')
                // ->groupBy('fc1.scrip_name')
                // ->limit($limit)
                // ->get();


                /*--------for scrips--------*/

                $results_classification_scrips = DB::table('fund_composition as fc1')
                    ->join('fund_composition AS fc2', function ($join) {
                        $join->on('fc1.scrip_name', '=', 'fc2.scrip_name')
                            ->on('fc1.fund_code', '=', 'fc2.fund_code');
                    })
                    ->select(
                        'fc1.scrip_name',
                        'fc1.fund_code',
                        'fc1.content_per as content_per_new',
                        'fc2.content_per AS content_per_old'
                    )
                    ->whereIn('fc1.fund_code', $fund_code_array)
                    ->where('fc1.entry_date', '=', $endDate)
                    ->where('fc2.entry_date', '=', $startDate)
                    ->limit($limit)
                    ->get();

                /*--------for industry--------*/

                $results_classification_industry = DB::table('fund_composition as fc1')
                    ->join('fund_composition AS fc2', function ($join) {
                        $join->on('fc1.industry', '=', 'fc2.industry')
                            ->on('fc1.fund_code', '=', 'fc2.fund_code');
                    })
                    ->select(
                        'fc1.industry',
                        'fc1.fund_code',
                        'fc1.content_per as content_per_new',
                        'fc2.content_per AS content_per_old'
                    )
                    ->whereIn('fc1.fund_code', $fund_code_array)
                    ->where('fc1.entry_date', '=', $endDate)
                    ->where('fc2.entry_date', '=', $startDate)
                    ->limit($limit)
                    ->get();




                $data['results_scrips'] = $results_classification_scrips;

                $data['results_industry'] = $results_classification_industry;



                // $data['boomers_records'] = $results_classification;



            } else if ($classification == 'fund') {

                $data['get_fund_master'] = $get_fund_master = $getdata['fund_master'];

                /*--------for scrips--------*/

                $results_funds_scrips = DB::table('fund_composition as fc1')
                    ->join('fund_composition AS fc2', function ($join) {
                        $join->on('fc1.scrip_name', '=', 'fc2.scrip_name')
                            ->on('fc1.fund_code', '=', 'fc2.fund_code');
                    })
                    ->select(
                        'fc1.scrip_name',
                        'fc1.fund_code',
                        'fc1.content_per as content_per_new',
                        'fc2.content_per AS content_per_old'
                    )
                    ->where('fc1.fund_code', $get_fund_master)
                    ->where('fc1.entry_date', '=', $endDate)
                    ->where('fc2.entry_date', '=', $startDate)
                    ->limit($limit)
                    ->get();

                /*--------for industry--------*/

                $results_fund_industry = DB::table('fund_composition as fc1')
                    ->join('fund_composition AS fc2', function ($join) {
                        $join->on('fc1.industry', '=', 'fc2.industry')
                            ->on('fc1.fund_code', '=', 'fc2.fund_code');
                    })
                    ->select(
                        'fc1.industry',
                        'fc1.fund_code',
                        'fc1.content_per as content_per_new',
                        'fc2.content_per AS content_per_old'
                    )
                    ->where('fc1.fund_code', $get_fund_master)
                    ->where('fc1.entry_date', '=', $endDate)
                    ->where('fc2.entry_date', '=', $startDate)
                    ->limit($limit)
                    ->get();




                $data['results_scrips'] = $results_funds_scrips;

                $data['results_industry'] = $results_fund_industry;
            }

            // dd($data);

        }

        $months = [];
        $years = [];
        for ($i = 1; $i <= 12; $i++) {
            // $months_array = $i .'=>'. date('F', mktime(0, 0, 0, $i, 10));
            $months_array = $i;

            array_push($months, $months_array);
        }

        $start_year = intval(date('Y')) - 5;

        for ($i = $start_year; $i <= date('Y'); $i++) {
            $year_array = $i;
            array_push($years, $year_array);
        }

        $data['months'] = $months;
        $data['years'] = $years;

        $data['mpx_fund_scrips'] = DB::table('scrips')->groupBy('actual_scrip')->get();

        $data['fund_type'] = FundType::get();

        $data['fund_master'] = FundMaster::where('status', 1)->get();

        return view('web.indices-reports.busters', $data);
    }

    public function index_vs_NAV(Request $request)
    {
        $data = RatioController::loggedInUserData();

        $data['browser_title'] = 'Index Vs NAV';
        $data['active_menu'] = 'indices_report_list';

        $data['indices'] = IndicesMaster::where('status', 1)->get();
        $data['indices_vals'] = [];
        $data['schemes'] = FundMaster::where('status', 1)->orderBy('fund_name', 'asc')->get();
        // dd($data);
        // dd($request->all());
        $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();

        // dd($disclaimerQuery->disclaimer);

        $data['disclaimer'] = $disclaimerQuery->disclaimer;
        $data['request'] = $request->all();
        // dd($data);
        // dd($request->main_select);
        if (!empty($request)) {
            $main_select = $request->main_select;
            // dd($main_select);
            if ($main_select == 'scheme') {
                $scheme_main = $request->input('scheme_main');
                // dd($scheme_main);
                $startDate = Carbon::parse($request->input('from_date'));
                $endDate = Carbon::parse($request->input('to_date'));


                $closingValues = FundDetail::where('fund_code', $scheme_main)
                    ->whereBetween('entry_date', [$startDate, $endDate])
                    ->orderBy('entry_date')
                    ->pluck('closing_nav', 'entry_date')
                    ->toArray();
                // dd($closingValues);
                $scheme_name = getNametable('fund_master', 'fund_name', 'fund_code', $scheme_main);
                if (!empty($closingValues)) {
                    // Format data for Google Charts API
                    // $chartData1 = [['Date', 'Closing Value']];
                    foreach ($closingValues as $date => $value) {
                        $chartData[] = [Carbon::parse($date)->toDateString(), (float) $value];
                    }

                    $data['indices_vals_1'][$scheme_name] = $chartData;
                    $data['indices_vals_2'][$scheme_name] = $chartData;
                    $data['indices_vals_3'][$scheme_name] = $chartData;
                    $data['indices_vals_4'][$scheme_name] = $chartData;
                    $data['indices_vals_5'][$scheme_name] = $chartData;
                    $data['indices_vals_6'][$scheme_name] = $chartData;
                } else {
                    // Handle case where no data is found
                    $data['indices_vals_1'][$scheme_name] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_2'][$scheme_name] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_3'][$scheme_name] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_4'][$scheme_name] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_5'][$scheme_name] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_6'][$scheme_name] = [['Date', 'Closing Value'], ['No data available', 0]];
                }
                // dd($data['indices_vals']);
            } else if ($main_select == 'index') {

                $index_main = $request->input('index_main');
                // dd($index_main);
                $startDate = Carbon::parse($request->input('from_date'));
                $endDate = Carbon::parse($request->input('to_date'));


                $closingValues = IndicesDetail::where('correlation_new', $index_main)
                    ->whereBetween('entry_date', [$startDate, $endDate])
                    ->orderBy('entry_date')
                    ->pluck('closing_value', 'entry_date')
                    ->toArray();
                // dd($closingValues);

                if (!empty($closingValues)) {
                    // Format data for Google Charts API
                    $chartData = [['Date', 'Closing Value']];
                    foreach ($closingValues as $date => $value) {
                        $chartData[] = [Carbon::parse($date)->toDateString(), (float) $value];
                    }

                    $data['indices_vals_1'][$index_main] = $chartData;
                    $data['indices_vals_2'][$index_main] = $chartData;
                    $data['indices_vals_3'][$index_main] = $chartData;
                    $data['indices_vals_4'][$index_main] = $chartData;
                    $data['indices_vals_5'][$index_main] = $chartData;
                    $data['indices_vals_6'][$index_main] = $chartData;
                } else {
                    // Handle case where no data is found
                    $data['indices_vals_1'][$index_main] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_2'][$index_main] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_3'][$index_main] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_4'][$index_main] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_5'][$index_main] = [['Date', 'Closing Value'], ['No data available', 0]];
                    $data['indices_vals_6'][$index_main] = [['Date', 'Closing Value'], ['No data available', 0]];
                }
                // dd($data['indices_vals']);

            }

            //1
            if (!empty($request->select_1)) {
                $select_1 = $request->select_1;
                if ($select_1 == 'scheme') {
                    $scheme_1 = $request->input('scheme_1');
                    // dd($scheme_1);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues1 = FundDetail::where('fund_code', $scheme_1)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_nav', 'entry_date')
                        ->toArray();
                    // dd($closingValues);
                    $scheme_name_1 = getNametable('fund_master', 'fund_name', 'fund_code', $scheme_1);
                    if (!empty($closingValues1)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues1 as $date => $value) {
                            $chartData1[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_1'][$scheme_name_1] = $chartData1;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals'][$scheme_name_1] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals']);
                } else if ($select_1 == 'index') {

                    $index_1 = $request->input('index_1');
                    // dd($index_1);
                    // dd($index_main);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues1 = IndicesDetail::where('correlation_new', $index_1)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_value', 'entry_date')
                        ->toArray();
                    // dd($closingValues);

                    if (!empty($closingValues1)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues1 as $date => $value) {
                            $chartData1[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_1'][$index_1] = $chartData1;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_1'][$index_1] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals']);

                }
            }

            //2
            if (!empty($request->select_2)) {
                $select_2 = $request->select_2;
                // dd($select_2);
                if ($select_2 == 'scheme') {
                    $scheme_2 = $request->input('scheme_2');
                    // dd($scheme_2);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues2 = FundDetail::where('fund_code', $scheme_2)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_nav', 'entry_date')
                        ->toArray();
                    // dd($closingValues1);
                    $scheme_name_2 = getNametable('fund_master', 'fund_name', 'fund_code', $scheme_2);
                    if (!empty($closingValues2)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues2 as $date => $value) {
                            $chartData2[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_2'][$scheme_name_2] = $chartData2;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_2'][$scheme_name_2] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals']);
                } else if ($select_2 == 'index') {

                    $index_2 = $request->input('index_2');
                    // dd($index_1);
                    // dd($index_main);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues2 = IndicesDetail::where('correlation_new', $index_2)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_value', 'entry_date')
                        ->toArray();
                    // dd($closingValues);

                    if (!empty($closingValues2)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues2 as $date => $value) {
                            $chartData2[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_2'][$index_2] = $chartData2;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_2'][$index_2] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals']);

                }
            }

            //3
            if (!empty($request->select_3)) {
                $select_3 = $request->select_3;
                // dd($select_3);
                if ($select_3 == 'scheme') {
                    $scheme_3 = $request->input('scheme_3');
                    // dd($scheme_3);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues3 = FundDetail::where('fund_code', $scheme_3)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_nav', 'entry_date')
                        ->toArray();
                    // dd($closingValues3);
                    $scheme_name_3 = getNametable('fund_master', 'fund_name', 'fund_code', $scheme_3);
                    // dd($scheme_name_3);
                    if (!empty($closingValues3)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues3 as $date => $value) {
                            $chartData3[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }
                        // dd($chartData3);
                        $data['indices_vals_3'][$scheme_name_3] = $chartData3;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_3'][$scheme_name_3] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals'][$scheme_name_3]);
                } else if ($select_3 == 'index') {

                    $index_3 = $request->input('index_3');
                    // dd($index_1);
                    // dd($index_main);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues3 = IndicesDetail::where('correlation_new', $index_3)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_value', 'entry_date')
                        ->toArray();
                    // dd($closingValues);

                    if (!empty($closingValues3)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues3 as $date => $value) {
                            $chartData3[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_3'][$index_3] = $chartData3;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_3'][$index_3] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals']);

                }
            }

            //4
            if (!empty($request->select_4)) {
                $select_4 = $request->select_4;
                // dd($select_4);
                if ($select_4 == 'scheme') {
                    $scheme_4 = $request->input('scheme_4');
                    // dd($scheme_4);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues4 = FundDetail::where('fund_code', $scheme_4)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_nav', 'entry_date')
                        ->toArray();
                    // dd($closingValues4);
                    $scheme_name_4 = getNametable('fund_master', 'fund_name', 'fund_code', $scheme_4);
                    if (!empty($closingValues4)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues4 as $date => $value) {
                            $chartData4[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_4'][$scheme_name_4] = $chartData4;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_4'][$scheme_4] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals_3']);
                } else if ($select_4 == 'index') {

                    $index_4 = $request->input('index_4');
                    // dd($index_1);
                    // dd($index_main);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues4 = IndicesDetail::where('correlation_new', $index_4)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_value', 'entry_date')
                        ->toArray();
                    // dd($closingValues);

                    if (!empty($closingValues4)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues4 as $date => $value) {
                            $chartData4[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_4'][$index_4] = $chartData4;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_4'][$index_4] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals']);

                }
            }

            //5
            if (!empty($request->select_5)) {
                $select_5 = $request->select_5;
                if ($select_5 == 'scheme') {
                    $scheme_5 = $request->input('scheme_5');
                    // dd($scheme_1);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues5 = FundDetail::where('fund_code', $scheme_5)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_nav', 'entry_date')
                        ->toArray();
                    // dd($closingValues);
                    $scheme_name_5 = getNametable('fund_master', 'fund_name', 'fund_code', $scheme_5);
                    if (!empty($closingValues5)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues5 as $date => $value) {
                            $chartData5[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_5'][$scheme_name_5] = $chartData5;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_5'][$scheme_name_5] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals']);
                } else if ($select_5 == 'index') {

                    $index_5 = $request->input('index_5');
                    // dd($index_1);
                    // dd($index_main);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues5 = IndicesDetail::where('correlation_new', $index_5)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_value', 'entry_date')
                        ->toArray();
                    // dd($closingValues);

                    if (!empty($closingValues5)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues5 as $date => $value) {
                            $chartData5[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_5'][$index_5] = $chartData5;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_5'][$index_5] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals']);

                }
            }

            //6
            if (!empty($request->select_6)) {
                $select_6 = $request->select_6;
                // dd($select_6);
                if ($select_6 == 'scheme') {
                    $scheme_6 = $request->input('scheme_6');
                    // dd($scheme_6);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues6 = FundDetail::where('fund_code', $scheme_6)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_nav', 'entry_date')
                        ->toArray();
                    // dd($closingValues6);
                    $scheme_name_6 = getNametable('fund_master', 'fund_name', 'fund_code', $scheme_6);
                    // dd($scheme_name_6);
                    if (!empty($closingValues6)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues6 as $date => $value) {
                            $chartData6[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_6'][$scheme_name_6] = $chartData6;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_6'][$scheme_name_6] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals_6']);
                } else if ($select_6 == 'index') {

                    $index_6 = $request->input('index_6');
                    // dd($index_6);
                    // dd($index_main);
                    $startDate = Carbon::parse($request->input('from_date'));
                    $endDate = Carbon::parse($request->input('to_date'));


                    $closingValues6 = IndicesDetail::where('correlation_new', $index_6)
                        ->whereBetween('entry_date', [$startDate, $endDate])
                        ->orderBy('entry_date')
                        ->pluck('closing_value', 'entry_date')
                        ->toArray();
                    // dd($closingValues);

                    if (!empty($closingValues6)) {
                        // Format data for Google Charts API
                        // $chartData1 = [['Date', 'Closing Value']];
                        foreach ($closingValues6 as $date => $value) {
                            $chartData6[] = [Carbon::parse($date)->toDateString(), (float) $value];
                        }

                        $data['indices_vals_6'][$index_6] = $chartData6;
                    } else {
                        // Handle case where no data is found
                        $data['indices_vals_6'][$index_6] = [['Date', 'Closing Value'], ['No data available', 0]];
                    }
                    // dd($data['indices_vals']);

                }
            }
            // dd($data);


        }
        // if (!empty($request->input('scheme_main')) || !empty($request->input('index_main'))) {
        //     $scheme = $request->input('scheme_main');
        //     // dd($index);
        //     $startDate = Carbon::parse($request->input('start_date'));
        //     $endDate = Carbon::parse($request->input('end_date'));


        //     $closingValues = IndicesDetail::where('correlation_new', $index)
        //                     ->whereBetween('entry_date', [$startDate, $endDate])
        //                     ->orderBy('entry_date')
        //                     ->pluck('closing_value', 'entry_date')
        //                     ->toArray();
        //     // dd($closingValues);

        //     if (!empty($closingValues)) {
        //         // Format data for Google Charts API
        //         $chartData = [['Date', 'Closing Value']];
        //         foreach ($closingValues as $date => $value) {
        //             $chartData[] = [Carbon::parse($date)->toDateString(), (float) $value];
        //         }

        //         $data['indices_vals'][$index] = $chartData;
        //     } else {
        //         // Handle case where no data is found
        //         $data['indices_vals'][$index] = [['Date', 'Closing Value'], ['No data available', 0]];
        //     }
        // }

        return view('web.indices-reports.index-vs-NAV', $data);
    }

    function getlastdate($month, $year)
    {
        $date = Carbon::create($year, $month, 1);

        // Get the last day of the month
        $lastDayOfMonth = $date->endOfMonth()->toDateString();

        return  date('Y-m-d', strtotime($lastDayOfMonth));
    }
}
