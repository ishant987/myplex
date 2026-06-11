<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BaseController;
use App\Models\CorpusEntry;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FundMaster;
use App\Models\FundType;
use App\Models\IndicesMaster;
use App\Models\CurrencyMaster;;

use App\Http\Controllers\Web\JensonsalphaAPIController;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use DB;
use App\Lib\Core\Useful;


class RatioReportController extends Controller
{
    public function __construct()
    {
        $this->Useful = new Useful;
    }

    public function stats(Request $request)
    {
        // dd('ok');

        $data = RatioController::loggedInUserData();
        // dd($userData);
        $jensonAlphaController = new JensonsalphaAPIController;
        $data['browser_title'] = 'Performance Ratios';
        $data['active_menu'] = 'dashboard';
        $data['all_funds'] = FundMaster::where('status', 1)->orderBy('fund_name', 'asc')->get();
        // dd($data['all_funds']);
        $data['all_fund_types'] = FundType::where('active_passive', 'A')->get();
        $data['quartile_set'] =  $request->quartile_set;
        // dd($request->all());
        //search block..........
        $quartile_result = [];
        //for searching with fund classification
        if ($request->has('Category') && $request->Category == 'by_category') {
            // dd('search_by_classification');
            //validation
            $request->validate(
                [
                    'ranking' => 'required'
                ],
                [
                    'ranking' . 'required' => 'Please Select Range Or As on for Searching'
                ]
            );

            if ($request->ranking == 'range') {
                //validation for range
                $request->validate(
                    [
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'fund_type_id' => 'required',
                        'report_category' => 'required',
                    ],
                    [
                        'ranking' . 'start_date' => 'Please Select the Start Date',
                        'ranking' . 'end_date' => 'Please Select the End Date',
                        'ranking' . 'fund_type_id' => 'Please Select the Fund Type',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                    ]
                );
                // dd($request->report_category);

                $data['fund_type_id'] = $request->fund_type_id;
                $fund_type = FundType::where('ft_id', $request->fund_type_id)->first();
                // dd($fund_type->name);
                $data['fund_type_name'] = $fund_type->name;
                // dd($data['fund_type']);


                if ($request->report_category == 'one_month_rolling_return') {

                    $data['start_date'] =  $start_date = date('Y-m-d', strtotime('-1 month', strtotime($request->end_date)));

                    $data['end_date'] =  $end_date = date('Y-m-d', strtotime($request->end_date));
                } else {

                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $data['start_date'] = $start_date;
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $data['end_date'] = $end_date;
                }




                $fund_type_id = $request->fund_type_id;
                $fund_code_in = FundMaster::where('fund_type_id', $fund_type_id)->get();
                $data['report_category'] = $request->report_category;


                if ($request->report_category == 'returns') {
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['fund_return_absolute'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'jensens_alpha') {
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['jensens_alpha'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'sharpe') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::sharpeApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['sharpe'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'treynor') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::treynorApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['treynor'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'information_ratio') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::informationRatioApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['information_ratio'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'beta') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::stbetaApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['beta'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'volatility') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::stvolatilityApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['volatility'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'tracking_error') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::sttrackingErrorApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['tracking_error'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'skewness') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::skewnessApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['skewness'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'kurtosis') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::kurtosisApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['kurtosis'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'r_square') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::r_squareApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['r_squere'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'r_square') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::r_squareApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['r_squere'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'r_square') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::r_squareApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['r_squere'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'one_month_rolling_return') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::oneMonthRollingReturnApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['one_month_interval_percentage_change'];
                            // dd($fund_absolute_return);
                        }
                    }
                }

                // dd($fund_absolute_return);
                // dd($quartile);
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
            } elseif ($request->ranking == 'as_on') {
                    // dd('category_as_on')
                ;
                $request->validate(
                    [
                        'as_on_date' => 'required',
                        'as_on_time_frame' => 'required',
                        'fund_type_id' => 'required',
                        'report_category' => 'required',
                    ],
                    [
                        'ranking' . 'as_on_date' => 'Please Select the Date',
                        'ranking' . 'as_on_time_frame' => 'Please Select the Time Period',
                        'ranking' . 'fund_type_id' => 'Please Select the Fund Type',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                    ]
                );

                $data['fund_type_id'] = $request->fund_type_id;
                $fund_type = FundType::where('ft_id', $request->fund_type_id)->first();
                // dd($fund_type->name);
                $data['fund_type_name'] = $fund_type->name;
                // dd($data['fund_type']);


                // $start_date = date('Y-m-d', strtotime($request->start_date));
                // $data['start_date'] = $start_date;
                // $end_date = date('Y-m-d', strtotime($request->end_date));
                // $data['end_date'] = $end_date;

                if ($request->report_category == 'one_month_rolling_return') {

                    $data['start_date'] =  $start_date =  date('Y-m-d', strtotime('-1 month', strtotime($request->as_on_date)));

                    $data['end_date'] =  $end_date = date('Y-m-d', strtotime($request->as_on_date));

                    $data['as_on_time_frame_data'] = $request->as_on_time_frame;
                } else {

                    $end_date = date('Y-m-d', strtotime($request->as_on_date));
                    $data['as_on_time_frame_data'] = $request->as_on_time_frame;

                    $data['end_date'] = $end_date;
                    // dd($request->as_on_time_frame);
                    switch ($request->as_on_time_frame) {
                        case '1_month':
                            $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                            break;
                        case '3_months':
                            $start_date = date('Y-m-d', strtotime('-3 months', strtotime($end_date)));
                            break;
                        case '6_months':
                            $start_date = date('Y-m-d', strtotime('-6 months', strtotime($end_date)));
                            break;
                        case '1_year':
                            $start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                            break;
                        case '2_year':
                            $start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));
                            break;
                        case '3_years':
                            $start_date = date('Y-m-d', strtotime('-3 years', strtotime($end_date)));
                            break;
                        case '5_years':
                            $start_date = date('Y-m-d', strtotime('-5 years', strtotime($end_date)));
                            break;
                        default:
                            // Handle unexpected values or set a default interval
                            // For example, set the start date to one month before by default
                            $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                            break;
                    }

                    $data['start_date'] = $start_date;
                }


                $fund_type_id = $request->fund_type_id;
                $fund_code_in = FundMaster::where('fund_type_id', $fund_type_id)->get();
                $data['report_category'] = $request->report_category;

                if ($request->report_category == 'returns') {
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['fund_return_absolute'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'jensens_alpha') {
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::jensenalphaApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['jensens_alpha'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'sharpe') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::sharpeApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['sharpe'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'treynor') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::treynorApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['treynor'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'information_ratio') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::informationRatioApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['information_ratio'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'beta') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::stbetaApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['beta'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'volatility') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::stvolatilityApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['volatility'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'tracking_error') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::sttrackingErrorApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['tracking_error'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'skewness') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::skewnessApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['skewness'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'kurtosis') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::kurtosisApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['kurtosis'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'r_square') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::r_squareApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['r_squere'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'one_month_rolling_return') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::oneMonthRollingReturnApi($fund_individual->fund_code, $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['one_month_interval_percentage_change'];
                            // dd($fund_absolute_return);
                        }
                    }
                }
                // dd($fund_absolute_return);
                // dd($quartile);
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
            }
        }
        // dd($quartile_result);
        if ($request->has('Category') && $request->Category == 'by_fund') {
            // dd('search by fund');
            //validation
            $request->validate(
                [
                    'ranking' => 'required'
                ],
                [
                    'ranking' . 'required' => 'Please Select Range Or As on for Searching'
                ]
            );

            if ($request->ranking == 'range') {
                //validation for range
                $request->validate(
                    [
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'fund_id' => 'required',
                        'report_category' => 'required',
                    ],
                    [
                        'ranking' . 'start_date' => 'Please Select the Start Date',
                        'ranking' . 'end_date' => 'Please Select the End Date',
                        'ranking' . 'fund_id' => 'Please Select the Fund',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                    ]
                );



                // dd($data['fund_id']);

                $fundMaterData = FundMaster::whereIn('fund_id', $request->fund_id)->get();
                // dd($fundMaterData);
                // $fund_type_id = $fundMaterData->fund_type_id;
                // $fund_code = $fundMaterData->fund_code;

                $fund_type_id = [];
                $fund_code = [];
                $fund_id = [];

                $fund_code_id_arra = [];
                $fund_name_array = [];


                foreach ($fundMaterData as $funds) {

                    array_push($fund_id, $funds->fund_id);
                    array_push($fund_name_array, $funds->fund_name);
                    array_push($fund_type_id, $funds->fund_type_id);
                    array_push($fund_code, $funds->fund_code);

                    // $fund_code_id_arra['fund_id'] = $funds->fund_id;
                    // $fund_code_id_arra['fund_code'] = $funds->fund_code;

                    $fund_code_id = array(
                        'fund_id' => $funds->fund_id,
                        'fund_code' => $funds->fund_code
                    );

                    array_push($fund_code_id_arra, $fund_code_id);
                }

                $data['fund_id'] = $fund_id;

                $fund_type = FundType::whereIn('ft_id', $fund_type_id)->get();

                $fund_type_name_arr = [];

                foreach ($fund_type as $f_type) {
                    array_push($fund_type_name_arr, $f_type->name);
                }
                $data['fund_type_name'] = $fund_type_name_arr;

                //test end
                if ($request->report_category == 'one_month_rolling_return') {

                    $data['start_date'] =  $start_date = date('Y-m-d', strtotime('-1 month', strtotime($request->end_date)));

                    $data['end_date'] =  $end_date = date('Y-m-d', strtotime($request->end_date));
                } else {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $data['start_date'] = $start_date;
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $data['end_date'] = $end_date;
                }



                $data['report_category'] = $request->report_category;

                if ($request->report_category == 'returns') {
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::jensenalphaApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['fund_return_absolute'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'jensens_alpha') {
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::jensenalphaApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['jensens_alpha'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'sharpe') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::sharpeApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['sharpe'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'treynor') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::treynorApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['treynor'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'information_ratio') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::informationRatioApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['information_ratio'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'beta') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::stbetaApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['beta'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'volatility') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::stvolatilityApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['volatility'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'tracking_error') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::sttrackingErrorApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['tracking_error'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'skewness') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::skewnessApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['skewness'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'kurtosis') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::kurtosisApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['kurtosis'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'r_square') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::r_squareApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['r_squere'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'one_month_rolling_return') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::oneMonthRollingReturnApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['one_month_interval_percentage_change'];
                            // dd($fund_absolute_return);
                        }
                    }
                }
                //dd($fund_absolute_return);
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
            } elseif ($request->ranking == 'as_on') {
                // dd($as_on);
                $request->validate(
                    [
                        'as_on_date' => 'required',
                        'as_on_time_frame' => 'required',
                        'fund_id' => 'required',
                        'report_category' => 'required',
                    ],
                    [
                        'ranking' . 'as_on_date' => 'Please Select the Date',
                        'ranking' . 'as_on_time_frame' => 'Please Select the Time Period',
                        'ranking' . 'fund_id' => 'Please Select the Fund',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                    ]
                );


                $data['fund_id'] = $request->fund_id;

                // dd($data['fund_id']);

                $fundMaterData = FundMaster::whereIn('fund_id', $request->fund_id)->get();


                $fund_type_id = [];
                $fund_code = [];
                $fund_id = [];

                $fund_code_id_arra = [];
                $fund_name_array = [];
                foreach ($fundMaterData as $funds) {

                    array_push($fund_id, $funds->fund_id);
                    array_push($fund_name_array, $funds->fund_name);

                    array_push($fund_type_id, $funds->fund_type_id);
                    array_push($fund_code, $funds->fund_code);

                    $fund_code_id = array(
                        'fund_id' => $funds->fund_id,
                        'fund_code' => $funds->fund_code
                    );

                    array_push($fund_code_id_arra, $fund_code_id);
                }

                // dd($fund_type_id);
                $fund_type = FundType::whereIn('ft_id', $fund_type_id)->get();
                // dd($fund_type->name);
                $fund_type_name_arr = [];

                foreach ($fund_type as $f_type) {
                    array_push($fund_type_name_arr, $f_type->name);
                }
                $data['fund_type_name'] = $fund_type_name_arr;





                if ($request->report_category == 'one_month_rolling_return') {

                    $data['start_date'] =  $start_date =  date('Y-m-d', strtotime('-1 month', strtotime($request->as_on_date)));

                    $data['end_date'] =  $end_date = date('Y-m-d', strtotime($request->as_on_date));
                } else {
                    $end_date = date('Y-m-d', strtotime($request->as_on_date));
                    $data['as_on_time_frame_data'] = $request->as_on_time_frame;

                    $data['end_date'] = $end_date;
                    // dd($request->as_on_time_frame);
                    switch ($request->as_on_time_frame) {
                        case '1_month':
                            $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                            break;
                        case '3_months':
                            $start_date = date('Y-m-d', strtotime('-3 months', strtotime($end_date)));
                            break;
                        case '6_months':
                            $start_date = date('Y-m-d', strtotime('-6 months', strtotime($end_date)));
                            break;
                        case '1_year':
                            $start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                            break;
                        case '2_year':
                            $start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));
                            break;
                        case '3_years':
                            $start_date = date('Y-m-d', strtotime('-3 years', strtotime($end_date)));
                            break;
                        case '5_years':
                            $start_date = date('Y-m-d', strtotime('-5 years', strtotime($end_date)));
                            break;
                        default:
                            // Handle unexpected values or set a default interval
                            // For example, set the start date to one month before by default
                            $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                            break;
                    }

                    $data['start_date'] = $start_date;
                }

                $data['start_date'] = $start_date;

                // dd($start_date."---".$end_date);

                $data['report_category'] = $request->report_category;


                $fund_return = self::jensenalphaApi($fund_code, $start_date, $end_date);
                // dd($call_sp);
                if ($request->report_category == 'returns') {
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::jensenalphaApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['fund_return_absolute'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'jensens_alpha') {
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::jensenalphaApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['jensens_alpha'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'sharpe') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::sharpeApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['sharpe'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'treynor') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::treynorApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['treynor'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'information_ratio') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::informationRatioApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['information_ratio'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'beta') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::stbetaApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['beta'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'volatility') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::stvolatilityApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['volatility'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'tracking_error') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::sttrackingErrorApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['tracking_error'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'skewness') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::skewnessApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['skewness'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'kurtosis') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::kurtosisApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['kurtosis'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'r_square') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::r_squareApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['r_squere'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'one_month_rolling_return') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::oneMonthRollingReturnApi($fund_individual['fund_code'], $start_date, $end_date);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['one_month_interval_percentage_change'];
                            // dd($fund_absolute_return);
                        }
                    }
                }

                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
            }
            // dd($quartile_result);
            $data['fund_names'] = implode(", ", $fund_name_array);
        }

        // Pass the request parameters back to the view for form repopulation
        $data['request'] = $request;
        $data['stat_result'] = $quartile_result;

        $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();

        // dd($disclaimerQuery->disclaimer);

        $data['disclaimer'] = $disclaimerQuery->disclaimer;

        // dd($data);
        return view('web.ratio-reports.stats', $data);
    }

    public function r_square_comparison(Request $request)
    {
        // dd('ok');
        $dataArr = $FundMasterDataArr = $IndicesMasterDataArr = $responseArr = $filterArr = [];
        $data = RatioController::loggedInUserData();
        // dd($userData);

        $data['browser_title'] = 'r-Square Ratio Report';
        $data['active_menu'] = 'dashboard';

        // Pass the request parameters back to the view for form repopulation
        $data['request'] = $request;

        $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();
        $data['disclaimer'] = $disclaimerQuery->disclaimer;


        $filterArr['with'] = array(
            'fundtype' => function ($query) {
                $query->select(['ft_id', 'name']);
            },
            'fundterm' => function ($query) {
                $query->select('ftm_id', 'term');
            },
        );

        $FundMasterDataArr = FundMaster::where('status', 1)->orderBy('fund_name', 'asc')->get();

        $IndicesMasterDataArr = IndicesMaster::select('idc_id', 'name')->where('status', 1)->get();
        $CurrencyMasterDataArr = CurrencyMaster::select('name', 'cm_id', 'is_comodity')->where('status', 1)->get();

        $data['funds'] = $FundMasterDataArr;
        $data['indices'] = $IndicesMasterDataArr;
        $data['currencies'] = $CurrencyMasterDataArr;


        // dd( $data['indices']);

        // dd($request);
        $quartile_result = [];
        $fund_type_id = [];
        $fund_code = [];
        $fund_id = [];

        $fund_code_id_arra = [];
        $fund_name_array = [];
        $schemeMaterData = [];
        
        if ($request->scheme_id) {
            $request->validate(
                [
                    'ranking' => 'required'
                ],
                [
                    'ranking' . 'required' => 'Please Select Range Or As on for Searching'
                ]
            );

            if ($request->ranking == 'range') {
                //validation for range
                $request->validate(
                    [
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'report_category' => 'required',
                    ],
                    [
                        'ranking' . 'start_date' => 'Please Select the Start Date',
                        'ranking' . 'end_date' => 'Please Select the End Date',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                    ]
                );

                //test end
                $start_date = date('Y-m-d', strtotime($request->start_date));
                $data['start_date'] = $start_date;
                $end_date = date('Y-m-d', strtotime($request->end_date));
                $data['end_date'] = $end_date;
            } elseif ($request->ranking == 'as_on') {
                // dd($as_on);
                $request->validate(
                    [
                        'as_on_date' => 'required',
                        'as_on_time_frame' => 'required',
                        'report_category' => 'required',
                    ],
                    [
                        'ranking' . 'as_on_date' => 'Please Select the Date',
                        'ranking' . 'as_on_time_frame' => 'Please Select the Time Period',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                    ]
                );

                $end_date = date('Y-m-d', strtotime($request->as_on_date));
                $data['as_on_time_frame_data'] = $request->as_on_time_frame;

                $data['end_date'] = $end_date;
                // dd($request->as_on_time_frame);
                switch ($request->as_on_time_frame) {
                    case '1_month':
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                    case '3_months':
                        $start_date = date('Y-m-d', strtotime('-3 months', strtotime($end_date)));
                        break;
                    case '6_months':
                        $start_date = date('Y-m-d', strtotime('-6 months', strtotime($end_date)));
                        break;
                    case '1_year':
                        $start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                        break;
                    case '2_year':
                        $start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));
                        break;
                    case '3_years':
                        $start_date = date('Y-m-d', strtotime('-3 years', strtotime($end_date)));
                        break;
                    case '5_years':
                        $start_date = date('Y-m-d', strtotime('-5 years', strtotime($end_date)));
                        break;
                    default:
                        // Handle unexpected values or set a default interval
                        // For example, set the start date to one month before by default
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                }

                $data['start_date'] = $start_date;
            }


            // dd($data['fund_id']);

            $schemeMaterData = FundMaster::where('fund_id', $request->scheme_id)->get()->first();
            // dd($schemeMaterData);
            $primaryNavByDate = DB::table('fund_detail')
                ->where('fund_code', $schemeMaterData->fund_code)
                ->whereBetween('entry_date', [$start_date, $end_date])
                ->orderBy('entry_date')
                ->pluck('closing_nav', 'entry_date') // KEY IMPORTANT
                ->toArray();

            

            if ($request->compare_type=='Scheme') {
                $data['fund_id'] = $request->fund_id;
                
                $fundMaterData = FundMaster::whereIn('fund_id', $request->fund_id)->get();
                foreach ($fundMaterData as $funds) {

                    array_push($fund_id, $funds->fund_id);
                    array_push($fund_name_array, $funds->fund_name);

                    array_push($fund_type_id, $funds->fund_type_id);
                    array_push($fund_code, $funds->fund_code);

                    $fund_code_id = array(
                        'fund_id' => $funds->fund_id,
                        'fund_code' => $funds->fund_code
                    );

                    array_push($fund_code_id_arra, $fund_code_id);
                }

                // dd($fund_type_id);
                $fund_type = FundType::whereIn('ft_id', $fund_type_id)->get();
                // dd($fund_type->name);
                $fund_type_name_arr = [];

                foreach ($fund_type as $f_type) {
                    array_push($fund_type_name_arr, $f_type->name);
                }
                $data['fund_type_name'] = $fund_type_name_arr;


                foreach ($fund_code_id_arra as $fund_individual) {
                    $secondaryNavByDate = DB::table('fund_detail')
                        ->where('fund_code', $fund_individual['fund_code'])
                        ->whereBetween('entry_date', [$start_date, $end_date])
                        ->orderBy('entry_date')
                        ->pluck('closing_nav', 'entry_date')
                        ->toArray();

                    $primaryAligned = [];
                    $secondaryAligned = [];

                    // keep only COMMON DATES
                    foreach ($primaryNavByDate as $date => $primaryNav) {
                        if (isset($secondaryNavByDate[$date])) {
                            $primaryAligned[]   = (float)$primaryNav;
                            $secondaryAligned[] = (float)$secondaryNavByDate[$date];
                        }
                    }

                    // minimum data safety
                    if (count($primaryAligned) > 2) {
                        $r2 = calculateRSquared($primaryAligned, $secondaryAligned);
                        $fund_absolute_return[$fund_individual['fund_id']] = $r2;
                        // dd($primaryNavByDate, $secondaryNavByDate,$primaryAligned, $secondaryAligned,$r2);
                    }
                }

                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
            }else if($request->compare_type=='Index'){
                $data['index_id'] = $request->index_id;
                $fundMaterData = IndicesMaster::whereIn('idc_id', $request->index_id)->get();
                foreach ($fundMaterData as $funds) {                    
                    array_push($fund_name_array, $funds->name);                    
                    array_push($fund_code, $funds->name);
                    $fund_code_id = array(
                        'idc_id' => $funds->idc_id,
                        'name' => $funds->name
                    );
                    array_push($fund_code_id_arra, $fund_code_id);
                }

                foreach ($fund_code_id_arra as $fund_individual) {
                    $secondaryNavByDate = DB::table('indices_detail')
                        ->where('name', $fund_individual['name'])
                        ->whereBetween('entry_date', [$start_date, $end_date])
                        ->orderBy('entry_date')
                        ->pluck('closing_value', 'entry_date')
                        ->toArray();

                    $primaryAligned = [];
                    $secondaryAligned = [];

                    // keep only COMMON DATES
                    foreach ($primaryNavByDate as $date => $primaryNav) {
                        if (isset($secondaryNavByDate[$date])) {
                            $primaryAligned[]   = (float)$primaryNav;
                            $secondaryAligned[] = (float)$secondaryNavByDate[$date];
                        }
                    }

                    // minimum data safety
                    if (count($primaryAligned) > 2) {
                        $r2 = calculateRSquared($primaryAligned, $secondaryAligned);
                        $fund_absolute_return[$fund_individual['idc_id']] = $r2;
                        // dd($primaryNavByDate, $secondaryNavByDate,$primaryAligned, $secondaryAligned,$r2);
                    }
                }

                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
                

                
            }else if($request->compare_type=='Currency'){
                $data['currency_id'] = $request->currency_id;
                $fundMaterData = CurrencyMaster::whereIn('cm_id', $request->currency_id)->get();
                foreach ($fundMaterData as $funds) {                    
                    array_push($fund_name_array, $funds->name);                    
                    array_push($fund_code, $funds->name);
                    $fund_code_id = array(
                        'cm_id' => $funds->cm_id,
                        'name' => $funds->name
                    );
                    array_push($fund_code_id_arra, $fund_code_id);
                }

                foreach ($fund_code_id_arra as $fund_individual) {
                    $secondaryNavByDate = DB::table('currency_detail')
                        ->where('cm_id', $fund_individual['cm_id'])
                        ->whereBetween('entry_date', [$start_date, $end_date])
                        ->orderBy('entry_date')
                        ->pluck('entry_value', 'entry_date')
                        ->toArray();

                    $primaryAligned = [];
                    $secondaryAligned = [];

                    // keep only COMMON DATES
                    foreach ($primaryNavByDate as $date => $primaryNav) {
                        if (isset($secondaryNavByDate[$date])) {
                            $primaryAligned[]   = (float)$primaryNav;
                            $secondaryAligned[] = (float)$secondaryNavByDate[$date];
                        }
                    }

                    // minimum data safety
                    if (count($primaryAligned) > 2) {
                        $r2 = calculateRSquared($primaryAligned, $secondaryAligned);
                        $fund_absolute_return[$fund_individual['cm_id']] = $r2;
                        // dd($primaryNavByDate, $secondaryNavByDate,$primaryAligned, $secondaryAligned,$r2);
                    }
                }

                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
                

                
            }else if($request->compare_type=='Commodity'){
                $data['commodity_id'] = $request->commodity_id;
                $fundMaterData = CurrencyMaster::whereIn('cm_id', $request->commodity_id)->get();
                foreach ($fundMaterData as $funds) {                    
                    array_push($fund_name_array, $funds->name);                    
                    array_push($fund_code, $funds->name);
                    $fund_code_id = array(
                        'cm_id' => $funds->cm_id,
                        'name' => $funds->name
                    );
                    array_push($fund_code_id_arra, $fund_code_id);
                }

                foreach ($fund_code_id_arra as $fund_individual) {
                    $secondaryNavByDate = DB::table('currency_detail')
                        ->where('cm_id', $fund_individual['cm_id'])
                        ->whereBetween('entry_date', [$start_date, $end_date])
                        ->orderBy('entry_date')
                        ->pluck('entry_value', 'entry_date')
                        ->toArray();

                    $primaryAligned = [];
                    $secondaryAligned = [];

                    // keep only COMMON DATES
                    foreach ($primaryNavByDate as $date => $primaryNav) {
                        if (isset($secondaryNavByDate[$date])) {
                            $primaryAligned[]   = (float)$primaryNav;
                            $secondaryAligned[] = (float)$secondaryNavByDate[$date];
                        }
                    }

                    // minimum data safety
                    if (count($primaryAligned) > 2) {
                        $r2 = calculateRSquared($primaryAligned, $secondaryAligned);
                        $fund_absolute_return[$fund_individual['cm_id']] = $r2;
                        // dd($primaryNavByDate, $secondaryNavByDate,$primaryAligned, $secondaryAligned,$r2);
                    }
                }

                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
                

                
            }



            $data['report_category'] = $request->report_category;



        }
        // dd($quartile_result);
        $data['fund_names'] = implode(", ", $fund_name_array);

        $data['stat_result'] = $quartile_result;
        $data['schemeMaterData'] = $schemeMaterData;



        return view('web.ratio-reports.r_square_comparison', $data);
    }


    public function risk_ratio(Request $request)
    {
        // dd('risk');
        $data = RatioController::loggedInUserData();
        $data['browser_title']  = 'Risk Ratio';
        $data['active_menu']  = 'ratio_analysis_list';
        // dd($userData);
        $jensonAlphaController = new JensonsalphaAPIController;
        $data['all_funds'] = FundMaster::where('status', 1)->orderBy('fund_name', 'asc')->get();
        // dd($data['all_funds']);
        $data['all_fund_types'] = FundType::where('active_passive', 'A')->get();
        $data['quartile_set'] =  $request->quartile_set;

        $data['indices'] = DB::table('indices_master')->whereNotIn('name', ['Gold', 'S&P 500 Index', 'MSCI Emerging Market'])->where('status', 1)->get();

        // dd($request->all());
        //search block..........
        $quartile_result = [];
        //for searching with fund classification
        // dd($request->Category);
        if ($request->has('Category') && $request->Category == 'by_category') {
            // dd('search_by_classification');
            //validation
            $request->validate(
                [
                    'ranking' => 'required'
                ],
                [
                    'ranking' . 'required' => 'Please Select Range Or As on for Searching'
                ]
            );

            if ($request->ranking == 'range') {
                //validation for range
                $request->validate(
                    [
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'fund_type_id' => 'required',
                        'report_category' => 'required',
                        'index_id'  =>  'required'
                    ],
                    [
                        'ranking' . 'start_date' => 'Please Select the Start Date',
                        'ranking' . 'end_date' => 'Please Select the End Date',
                        'ranking' . 'fund_type_id' => 'Please Select the Fund Type',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                        'ranking' . 'index_id' => 'Please Select an index',

                    ]
                );
                // dd($request->report_category);

                $data['fund_type_id'] = $request->fund_type_id;
                $fund_type = FundType::where('ft_id', $request->fund_type_id)->first();
                // dd($fund_type->name);
                $data['fund_type_name'] = $fund_type->name;
                // dd($data['fund_type']);

                $index_id = $request->index_id;

                $data['index_name'] = DB::table('indices_master')->select('name')->where('idc_id', $request->index_id)->where('status', 1)->first();

                $start_date = date('Y-m-d', strtotime($request->start_date));
                $data['start_date'] = $start_date;
                $end_date = date('Y-m-d', strtotime($request->end_date));
                $data['end_date'] = $end_date;
                $fund_type_id = $request->fund_type_id;
                $fund_code_in = FundMaster::where('fund_type_id', $fund_type_id)->get();
                $data['report_category'] = $request->report_category;


                if ($request->report_category == 'beta') {
                    // dd($request->report_category);
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::betaApi($fund_individual->fund_code, $start_date, $end_date, $index_id);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['beta'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'volatility') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::volatilityApi($fund_individual->fund_code, $start_date, $end_date, $index_id);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['volatility'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'tracking_error') {
                    // dd('information_ratio');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::trackingErrorApi($fund_individual->fund_code, $start_date, $end_date, $index_id);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['tracking_error'];
                            // dd($fund_absolute_return);
                        }
                    }
                }

                // dd($fund_absolute_return);
                // dd($quartile);
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
            } elseif ($request->ranking == 'as_on') {
                    // dd('category_as_on');
                ;
                $request->validate(
                    [
                        'as_on_date' => 'required',
                        'as_on_time_frame' => 'required',
                        'fund_type_id' => 'required',
                        'report_category' => 'required',
                        'index_id' => 'required',

                    ],
                    [
                        'ranking' . 'as_on_date' => 'Please Select the Date',
                        'ranking' . 'as_on_time_frame' => 'Please Select the Time Period',
                        'ranking' . 'fund_type_id' => 'Please Select the Fund Type',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                        'ranking' . 'index_id' => 'Please Select an index',

                    ]
                );

                $data['fund_type_id'] = $request->fund_type_id;
                $fund_type = FundType::where('ft_id', $request->fund_type_id)->first();
                // dd($fund_type->name);
                $data['fund_type_name'] = $fund_type->name;
                // dd($data['fund_type']);
                $data['index_name'] = DB::table('indices_master')->select('name')->where('idc_id', $request->index_id)->where('status', 1)->first();

                $index_id = $request->index_id;


                // $start_date = date('Y-m-d', strtotime($request->start_date));
                // $data['start_date'] = $start_date;
                // $end_date = date('Y-m-d', strtotime($request->end_date));
                // $data['end_date'] = $end_date;

                $end_date = date('Y-m-d', strtotime($request->as_on_date));
                $data['end_date'] = $end_date;
                $data['as_on_time_frame_data'] = $request->as_on_time_frame;
                // dd($request->as_on_time_frame);
                switch ($request->as_on_time_frame) {
                    case '1_month':
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                    case '3_months':
                        $start_date = date('Y-m-d', strtotime('-3 months', strtotime($end_date)));
                        break;
                    case '6_months':
                        $start_date = date('Y-m-d', strtotime('-6 months', strtotime($end_date)));
                        break;
                    case '1_year':
                        $start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                        break;
                    case '2_year':
                        $start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));
                        break;
                    case '3_years':
                        $start_date = date('Y-m-d', strtotime('-3 years', strtotime($end_date)));
                        break;
                    case '5_years':
                        $start_date = date('Y-m-d', strtotime('-5 years', strtotime($end_date)));
                        break;
                    default:
                        // Handle unexpected values or set a default interval
                        // For example, set the start date to one month before by default
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                }

                $data['start_date'] = $start_date;


                $fund_type_id = $request->fund_type_id;
                $fund_code_in = FundMaster::where('fund_type_id', $fund_type_id)->get();
                $data['report_category'] = $request->report_category;

                if ($request->report_category == 'beta') {
                    // dd('beta');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::betaApi($fund_individual->fund_code, $start_date, $end_date, $index_id);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['beta'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'volatility') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::volatilityApi($fund_individual->fund_code, $start_date, $end_date, $index_id);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['volatility'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'tracking_error') {
                    // dd('sharpe');
                    foreach ($fund_code_in as $fund_individual) {
                        $fund_return = self::trackingErrorApi($fund_individual->fund_code, $start_date, $end_date, $index_id);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual->fund_id] = $fund_return['tracking_error'];
                            // dd($fund_absolute_return);
                        }
                    }
                }
                // dd($fund_absolute_return);
                // dd($quartile);
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
            }
        }
        // dd($quartile_result);
        if ($request->has('Category') && $request->Category == 'by_fund') {
            // dd('search by fund');
            //validation
            $request->validate(
                [
                    'ranking' => 'required'
                ],
                [
                    'ranking' . 'required' => 'Please Select Range Or As on for Searching'
                ]
            );

            if ($request->ranking == 'range') {
                //validation for range
                $request->validate(
                    [
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'fund_id' => 'required',
                        'report_category' => 'required',
                        'index_id' => 'required',

                    ],
                    [
                        'ranking' . 'start_date' => 'Please Select the Start Date',
                        'ranking' . 'end_date' => 'Please Select the End Date',
                        'ranking' . 'fund_id' => 'Please Select the Fund',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                        'ranking' . 'index_id' => 'Please Select an index',

                    ]
                );



                // dd($data['fund_id']);

                $fundMaterData = FundMaster::whereIn('fund_id', $request->fund_id)->get();
                // dd($fundMaterData);
                // $fund_type_id = $fundMaterData->fund_type_id;
                // $fund_code = $fundMaterData->fund_code;

                $data['index_name'] = DB::table('indices_master')->select('name')->where('idc_id', $request->index_id)->where('status', 1)->first();

                $index_id = $request->index_id;

                $fund_type_id = [];
                $fund_code = [];
                $fund_id = [];

                $fund_code_id_arra = [];
                $fund_name_array = [];

                foreach ($fundMaterData as $funds) {

                    array_push($fund_id, $funds->fund_id);
                    array_push($fund_name_array, $funds->fund_name);

                    array_push($fund_type_id, $funds->fund_type_id);
                    array_push($fund_code, $funds->fund_code);

                    // $fund_code_id_arra['fund_id'] = $funds->fund_id;
                    // $fund_code_id_arra['fund_code'] = $funds->fund_code;

                    $fund_code_id = array(
                        'fund_id' => $funds->fund_id,
                        'fund_code' => $funds->fund_code
                    );

                    array_push($fund_code_id_arra, $fund_code_id);
                }

                $data['fund_id'] = $fund_id;

                $fund_type = FundType::whereIn('ft_id', $fund_type_id)->get();

                $fund_type_name_arr = [];

                foreach ($fund_type as $f_type) {
                    array_push($fund_type_name_arr, $f_type->name);
                }
                $data['fund_type_name'] = $fund_type_name_arr;

                //test end
                $start_date = date('Y-m-d', strtotime($request->start_date));
                $data['start_date'] = $start_date;
                $end_date = date('Y-m-d', strtotime($request->end_date));
                $data['end_date'] = $end_date;
                $data['report_category'] = $request->report_category;
                // dd($request->report_category);

                if ($request->report_category == 'beta') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::betaApi($fund_individual['fund_code'], $start_date, $end_date, $index_id);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['beta'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'volatility') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::volatilityApi($fund_individual['fund_code'], $start_date, $end_date, $index_id);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['volatility'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'tracking_error') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::trackingErrorApi($fund_individual['fund_code'], $start_date, $end_date, $index_id);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['tracking_error'];
                            // dd($fund_absolute_return);
                        }
                    }
                }
                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
            } elseif ($request->ranking == 'as_on') {
                // dd('as_on');
                $request->validate(
                    [
                        'as_on_date' => 'required',
                        'as_on_time_frame' => 'required',
                        'fund_id' => 'required',
                        'report_category' => 'required',
                        'index_id' => 'required',

                    ],
                    [
                        'ranking' . 'as_on_date' => 'Please Select the Date',
                        'ranking' . 'as_on_time_frame' => 'Please Select the Time Period',
                        'ranking' . 'fund_id' => 'Please Select the Fund',
                        'ranking' . 'report_category' => 'Please Select the Report Category',
                        'ranking' . 'index_id' => 'Please Select an index',

                    ]
                );


                $data['fund_id'] = $request->fund_id;

                // dd($data['fund_id']);

                $fundMaterData = FundMaster::whereIn('fund_id', $request->fund_id)->get();

                $data['index_name'] = DB::table('indices_master')->select('name')->where('idc_id', $request->index_id)->where('status', 1)->first();

                $index_id = $request->index_id;


                $fund_type_id = [];
                $fund_code = [];
                $fund_id = [];

                $fund_code_id_arra = [];
                $fund_name_array = [];

                foreach ($fundMaterData as $funds) {

                    array_push($fund_id, $funds->fund_id);
                    array_push($fund_name_array, $funds->fund_name);


                    array_push($fund_type_id, $funds->fund_type_id);
                    array_push($fund_code, $funds->fund_code);

                    $fund_code_id = array(
                        'fund_id' => $funds->fund_id,
                        'fund_code' => $funds->fund_code
                    );

                    array_push($fund_code_id_arra, $fund_code_id);
                }

                // dd($fund_type_id);
                $fund_type = FundType::whereIn('ft_id', $fund_type_id)->get();
                // dd($fund_type->name);
                $fund_type_name_arr = [];

                foreach ($fund_type as $f_type) {
                    array_push($fund_type_name_arr, $f_type->name);
                }
                $data['fund_type_name'] = $fund_type_name_arr;





                $end_date = date('Y-m-d', strtotime($request->as_on_date));
                $data['end_date'] = $end_date;

                $data['as_on_time_frame_data'] = $request->as_on_time_frame;

                switch ($request->as_on_time_frame) {
                    case '1_month':
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                    case '3_months':
                        $start_date = date('Y-m-d', strtotime('-3 months', strtotime($end_date)));
                        break;
                    case '6_months':
                        $start_date = date('Y-m-d', strtotime('-6 months', strtotime($end_date)));
                        break;
                    case '1_year':
                        $start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                        break;
                    case '2_year':
                        $start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));
                        break;
                    case '3_years':
                        $start_date = date('Y-m-d', strtotime('-3 years', strtotime($end_date)));
                        break;
                    case '5_years':
                        $start_date = date('Y-m-d', strtotime('-5 years', strtotime($end_date)));
                        break;
                    default:
                        // Handle unexpected values or set a default interval
                        // For example, set the start date to one month before by default
                        $start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));
                        break;
                }

                $data['start_date'] = $start_date;

                // dd($start_date."---".$end_date);

                $data['report_category'] = $request->report_category;


                // $fund_return = self::jensenalphaApi($fund_code, $start_date, $end_date);
                // dd($call_sp);
                if ($request->report_category == 'beta') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::betaApi($fund_individual['fund_code'], $start_date, $end_date, $index_id);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['beta'];
                            // dd($fund_absolute_return);
                        }
                    }
                    // dd($fund_absolute_return);
                } elseif ($request->report_category == 'volatility') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::volatilityApi($fund_individual['fund_code'], $start_date, $end_date, $index_id);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['volatility'];
                            // dd($fund_absolute_return);
                        }
                    }
                } elseif ($request->report_category == 'tracking_error') {
                    // dd('sharpe');
                    foreach ($fund_code_id_arra as $fund_individual) {
                        $fund_return = self::trackingErrorApi($fund_individual['fund_code'], $start_date, $end_date, $index_id);
                        // dd($call_sp);
                        // dd($fund_return);
                        if (!empty($fund_return)) {
                            $fund_absolute_return[$fund_individual['fund_id']] = $fund_return['tracking_error'];
                            // dd($fund_absolute_return);
                        }
                    }
                }

                // dd($fund_absolute_return);

                $quartile_result['fund_absolute_return'] = isset($fund_absolute_return) && count($fund_absolute_return) > 0 ? $fund_absolute_return : [];
            }
            // dd($quartile_result);

            $data['fund_names'] = implode(", ", $fund_name_array);
        }

        // Pass the request parameters back to the view for form repopulation
        $data['request'] = $request;
        $data['stat_result'] = $quartile_result;

        // dd($data['stat_result']);

        $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();

        // dd($disclaimerQuery->disclaimer);

        $data['disclaimer'] = $disclaimerQuery->disclaimer;

        return view('web.auth.ratio_analysis.risk_ratio', $data);
    }



    public static function jensenalphaApi($fund_code, $start_date, $end_date)
    {
        $baseUrl = URL::to('/');
        $endpoint = 'report-jensens-alpla-api';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,
            'search' => 'Search'
        ];

        // dd($params);
        // dd($url);
        $fullUrl = $url . '?' . http_build_query($params);
        // dd($fullUrl);
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


    public static function informationRatioApi($fund_code, $start_date, $end_date)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-information-ratio-api';

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


    public static function betaApi($fund_code, $start_date, $end_date, $index_id)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-beta-api-mar';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;
        // dd($url);

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,
            'search_index'   => $index_id,
            'search' => 'Search'
        ];
        $fullUrl = $url . '?' . http_build_query($params);
        // dd($fullUrl);
        // Send a GET request to the URL with the query parameters
        $response = Http::get($url, $params);
        // dd($response);
        //   if($fund_code == 'INF959L01CF0'){
        // dd($response->json());
        //   }
        // Check if the request was successful
        if ($response->successful()) {
            // Get the data from the response
            $ratioData = $response->json();
        } else {
            $ratioData = [];
        }
        return $ratioData;
    }


    public static function stbetaApi($fund_code, $start_date, $end_date)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-beta-api';

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
        //   if($fund_code == 'INF959L01CF0'){
        // dd($response->json());
        //   }
        // Check if the request was successful
        if ($response->successful()) {
            // Get the data from the response
            $ratioData = $response->json();
        } else {
            $ratioData = [];
        }
        return $ratioData;
    }

    public static function volatilityApi($fund_code, $start_date, $end_date, $index_id)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-volatility-api-mar';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;
        // dd($url);

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,
            'search_index'   => $index_id,

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


    public static function stvolatilityApi($fund_code, $start_date, $end_date)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-volatility-api';

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

    public static function trackingErrorApi($fund_code, $start_date, $end_date, $index_id)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-tracking-error-api-mar';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;
        // dd($url);

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,
            'search_index'   => $index_id,

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


    public static function sttrackingErrorApi($fund_code, $start_date, $end_date)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-tracking-error-api';

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

    public static function skewnessApi($fund_code, $start_date, $end_date)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-skewness-api';

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

    public static function kurtosisApi($fund_code, $start_date, $end_date)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-kurtosis-api';

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

    public static function oneMonthRollingReturnApi($fund_code, $start_date, $end_date)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-rolling-return-api';

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
}
