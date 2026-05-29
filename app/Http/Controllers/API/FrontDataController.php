<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use DB;
use App\Models\FundMaster;
use App\Models\IndicesMaster;
use App\Models\CurrencyMaster;
use App\Models\FundType;
use App\Models\FundComposition;
use App\Models\IndicesComposition;
use App\Models\CorpusEntry;
use App\Models\MonthlyRatioCalculation;
use App\Models\FundDetail;
use App\Models\IndicesDetail;
use App\Models\FundMan;
use App\Models\CurrencyDetail;
use App\Models\RiskTolerancePortfolio;
use App\Models\FundWatchNew;
use Carbon\Carbon;

use App\Lib\Core\Useful;
use App\Lib\Admin\App;
use App\Lib\Core\MailPS;
use Validator;
use Illuminate\Support\Str;
use Storage;
use Exception;

class FrontDataController extends BaseController
{
    public function getFundHouses()
    {
        $responseArr = [];
        $dataArr = FundMaster::select('fund_house')->groupby('fund_house')->get();
        $responseArr = $dataArr;
        return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }
    public function getIndices()
    {
        $responseArr = [];
        $dataArr = IndicesMaster::select('name')->where('status', 1)->get();
        $responseArr = $dataArr;
        return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }
    public function getCurrencies()
    {
        $responseArr = [];
        $dataArr = CurrencyMaster::select('name', 'cm_id', 'is_comodity')->where('status', 1)->get();
        $responseArr = $dataArr;
        return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }

    public function getFundClassifications()
    {
        $responseArr = [];
        $dataArr = FundType::select(['name', 'ft_id'])->where('active_passive', 'A')->get();
        $responseArr = $dataArr;
        return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }
    public function getFunds(Request $request)
    {
        $dataArr = $responseArr = $filterArr = [];

        $filterArr['fund_house'] = (isset($request->fund_house)) ? $request->fund_house : '';
        $filterArr['fund_type_id'] = (isset($request->fund_type_id)) ? $request->fund_type_id : '';
        $filterArr['classification'] = (isset($request->fund_classification)) ? $request->fund_classification : '';
        $filterArr['with'] = array(
            'fundtype' => function ($query) {
                $query->select(['ft_id', 'name']);
            },
            'fundterm' => function ($query) {
                $query->select('ftm_id', 'term');
            },
        );

        $dataArr = FundMaster::list($filterArr, ['fund_id', 'fund_name', 'fund_code', 'fund_opened', 'fund_manager', 'face_value', 'risk_free_return', 'indices_name', 'fund_type_id', 'fund_term_id', 'classification'], 'fund_name', 'ASC', false);
        $dataArr->setAppends(['opening_date']);

        $responseArr = $dataArr;
        return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }

    public function getFundComposition(Request $request)
    {
        $dataArr = $responseArr = $filterArr = [];

        $fund_code = (isset($request->fund_code)) ? $request->fund_code : '';

        $last_entry = FundComposition::select('entry_date')->where('fund_code', $fund_code)->where('publish', 'y')->orderBy('entry_date', 'desc')->first();
        if (!empty($last_entry)) {
            $month = Carbon::parse($last_entry->entry_date)->format('m');
            $year = Carbon::parse($last_entry->entry_date)->format('Y');
            $dataArr = DB::select('CALL sp_fund_composition_snapshot(' . $month . ', ' . $year . ', "' . $fund_code . '")');
        }
        $responseArr['portfolio'] = $dataArr;
        $responseArr['total_amount'] = count($dataArr) ? sprintf('%0.3f', $dataArr[0]->corpus_entry) : 0;
        $responseArr['month'] = Carbon::parse($last_entry->entry_date)->format('F');
        $responseArr['year'] = Carbon::parse($last_entry->entry_date)->format('Y');

        return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }

    public function getSnapshotDates(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $date = date("Y-m-d");
        if ($request->type == 'weekly') {
            $weekday = date('l', strtotime($date));
            // if ($weekday == 'Monday') {
            //     $start_date = date('Y-m-d', strtotime('-2 days'));
            //     $end_date = date('Y-m-d', strtotime('-8 days'));
            // }
            // if ($weekday == 'Tuesday') {
            //     $start_date = date('Y-m-d', strtotime('-3 days'));
            //     $end_date = date('Y-m-d', strtotime('-9 days'));
            // }
            // if ($weekday == 'Wednesday') {
            //     // dd('Wed');
            //     $start_date = date('Y-m-d', strtotime('-4 days'));
            //     $end_date = date('Y-m-d', strtotime('-10 days'));
            // }
            // if ($weekday == 'Thursday') {
            //     $start_date = date('Y-m-d', strtotime('-5 days'));
            //     $end_date = date('Y-m-d', strtotime('-11 days'));
            // }
            // if ($weekday == 'Friday') {
            //     $start_date = date('Y-m-d', strtotime('-6 days'));
            //     $end_date = date('Y-m-d', strtotime('-12 days'));
            // }
            // if ($weekday == 'Saturday') {
            //     $start_date = date('Y-m-d', strtotime('-0 days'));
            //     $end_date = date('Y-m-d', strtotime('-6 days'));
            // }
            // if ($weekday == 'Sunday') {
            //     $start_date = date('Y-m-d', strtotime('-1 days'));
            //     $end_date = date('Y-m-d', strtotime('-7 days'));
            // }

            //changed logic for the last date to be friday instead of saturday...
            if ($weekday == 'Monday') {
                $start_date = date('Y-m-d', strtotime('-3 days'));
                $end_date = date('Y-m-d', strtotime('-9 days'));
            }
            if ($weekday == 'Tuesday') {
                $start_date = date('Y-m-d', strtotime('-4 days'));
                $end_date = date('Y-m-d', strtotime('-10 days'));
            }
            if ($weekday == 'Wednesday') {
                // dd('Wed');
                $start_date = date('Y-m-d', strtotime('-5 days'));
                $end_date = date('Y-m-d', strtotime('-11 days'));
            }
            if ($weekday == 'Thursday') {
                $start_date = date('Y-m-d', strtotime('-6 days'));
                $end_date = date('Y-m-d', strtotime('-12 days'));
            }
            if ($weekday == 'Friday') {
                $start_date = date('Y-m-d', strtotime('-0 days'));
                $end_date = date('Y-m-d', strtotime('-6 days'));
            }
            if ($weekday == 'Saturday') {
                $start_date = date('Y-m-d', strtotime('-1 days'));
                $end_date = date('Y-m-d', strtotime('-7 days'));
            }
            if ($weekday == 'Sunday') {
                $start_date = date('Y-m-d', strtotime('-2 days'));
                $end_date = date('Y-m-d', strtotime('-8 days'));
            }
        } else {
            $start_date = date('Y-m-d', mktime(0, 0, 0, date("m"), 0));
            $end_date = date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
        }
        $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
        $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));
        return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }

    public function getFundCompositionSnapshot(Request $request, $type_id)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        try {
            $dataArr = DB::select('CALL sp_fund_composition_classification(' . $type_id . ')');
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        //$dataArr = DB::select('CALL sp_fund_composition_classification_testcd('.$type_id.')');
        if (count($dataArr)) {
            $responseArr['composition_snapshot'] = $dataArr;
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
            //return json_encode($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getWeeklyBestFunds(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $date = date("Y-m-d");
        $weekday = date('l', strtotime($date));
        if ($weekday == 'Monday') {
            $start_date = date('Y-m-d', strtotime('-3 days'));
            $end_date = date('Y-m-d', strtotime('-10 days'));
        }
        if ($weekday == 'Tuesday') {
            $start_date = date('Y-m-d', strtotime('-4 days'));
            $end_date = date('Y-m-d', strtotime('-11 days'));
        }
        if ($weekday == 'Wednesday') {
            $start_date = date('Y-m-d', strtotime('-5 days'));
            $end_date = date('Y-m-d', strtotime('-12 days'));
        }
        if ($weekday == 'Thursday') {
            $start_date = date('Y-m-d', strtotime('-6 days'));
            $end_date = date('Y-m-d', strtotime('-13 days'));
        }
        if ($weekday == 'Friday') {
            $start_date = date('Y-m-d', strtotime('-0 days'));
            $end_date = date('Y-m-d', strtotime('-7 days'));
        }
        if ($weekday == 'Saturday') {
            $start_date = date('Y-m-d', strtotime('-1 days'));
            $end_date = date('Y-m-d', strtotime('-8 days'));
        }
        if ($weekday == 'Sunday') {
            $start_date = date('Y-m-d', strtotime('-2 days'));
            $end_date = date('Y-m-d', strtotime('-9 days'));
        }
        $weekly_best_funds = DB::select('CALL sp_snapshot_weekly_fund("' . $start_date . '")');
        if (count($weekly_best_funds)) {
            $responseArr['weekly_best_funds'] = $weekly_best_funds;

            $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getMonthlyBestFunds(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $start_date = date('Y-m-d', mktime(0, 0, 0, date("m"), 0));
        $end_date = date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
        $weekly_best_funds = DB::select('CALL sp_snapshot_monthly_best_fund("' . $start_date . '")');
        if (count($weekly_best_funds)) {
            $responseArr['monthly_best_funds'] = $weekly_best_funds;
            $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getWeeklyChangesFundType(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $date = date("Y-m-d");
        $weekday = date('l', strtotime($date));
        if ($weekday == 'Monday') {
            $start_date = date('Y-m-d', strtotime('-3 days'));
            $end_date = date('Y-m-d', strtotime('-9 days'));
        }
        if ($weekday == 'Tuesday') {
            $start_date = date('Y-m-d', strtotime('-4 days'));
            $end_date = date('Y-m-d', strtotime('-10 days'));
        }
        if ($weekday == 'Wednesday') {
            $start_date = date('Y-m-d', strtotime('-5 days'));
            $end_date = date('Y-m-d', strtotime('-11 days'));
        }
        if ($weekday == 'Thursday') {
            $start_date = date('Y-m-d', strtotime('-6 days'));
            $end_date = date('Y-m-d', strtotime('-12 days'));
        }
        if ($weekday == 'Friday') {
            $start_date = date('Y-m-d', strtotime('-0 days'));
            $end_date = date('Y-m-d', strtotime('-6 days'));
        }
        if ($weekday == 'Saturday') {
            $start_date = date('Y-m-d', strtotime('-1 days'));
            $end_date = date('Y-m-d', strtotime('-7 days'));
        }
        if ($weekday == 'Sunday') {
            // dd('sunday');
            $start_date = date('Y-m-d', strtotime('-2 days'));
            $end_date = date('Y-m-d', strtotime('-8 days'));
        }
        $weekly_benchmark = DB::select('CALL sp_snapshot_weekly_benchmark("' . $start_date . '")');
        // dd($start_date);
        if (count($weekly_benchmark)) {
            $responseArr['changes_fund_type'] = $weekly_benchmark;
            $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getMonthlyChangesFundType(Request $request)
    {
        // dd($request->date);
        if ($request->date != null) {
            // dd('date found: '.$request->date);
            $end_date = $request->date;
            // dd($end_date);
            $dateStr = preg_replace('/ GMT \d{4} \(.*\)$/', '', $end_date);
            // Create a Carbon instance from the simplified date string
            $date = Carbon::parse($dateStr);

            // Format the date as "DD.MM.YYYY"
            $end_date = $date->format('Y-m-d');
            // dd($end_date);
            $start_date = Carbon::parse($end_date)->subMonth()->format('Y-m-d');
            // dd($start_date);
            $dataArr = $responseArr = [];
            $message = __('message');
        } else {
            $start_date = date('Y-m-d', mktime(0, 0, 0, date("m"), 0));
            // dd($start_date);
            $end_date = date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
            // dd($end_date);
            $dataArr = $responseArr = [];
            $message = __('message');
        }

        // $start_date= date('Y-m-d', mktime(0, 0, 0, date("m"), 0));
        // dd($start_date);
        // $end_date= date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
        // dd($end_date);
        $monthly_benchmark = DB::select('CALL sp_snapshot_monthly_benchmark("' . $start_date . '")');
        if (count($monthly_benchmark)) {
            $responseArr['changes_fund_type'] = $monthly_benchmark;

            $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));


            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getChangesFund(Request $request)
    {
        // dd($request->all());
        $dataArr = $responseArr = [];
        $message = __('message');
        $date = date("Y-m-d");
        $type_id = isset($request->fund_type_id) ? $request->fund_type_id : '';
        if ($request->type == 'weekly') {
            $weekday = date('l', strtotime($date));
            if ($weekday == 'Monday') {
                $start_date = date('Y-m-d', strtotime('-3 days'));
                $end_date = date('Y-m-d', strtotime('-9 days'));
            }
            if ($weekday == 'Tuesday') {
                $start_date = date('Y-m-d', strtotime('-4 days'));
                $end_date = date('Y-m-d', strtotime('-10 days'));
            }
            if ($weekday == 'Wednesday') {
                $start_date = date('Y-m-d', strtotime('-5 days'));
                $end_date = date('Y-m-d', strtotime('-11 days'));
            }
            if ($weekday == 'Thursday') {
                $start_date = date('Y-m-d', strtotime('-6 days'));
                $end_date = date('Y-m-d', strtotime('-12 days'));
            }
            if ($weekday == 'Friday') {
                $start_date = date('Y-m-d', strtotime('-0 days'));
                $end_date = date('Y-m-d', strtotime('-6 days'));
            }
            if ($weekday == 'Saturday') {
                $start_date = date('Y-m-d', strtotime('-1 days'));
                $end_date = date('Y-m-d', strtotime('-7 days'));
            }
            if ($weekday == 'Sunday') {
                $start_date = date('Y-m-d', strtotime('-2 days'));
                $end_date = date('Y-m-d', strtotime('-8 days'));
            }
            $days = 6;
            $query = 'CALL sp_snapshot_fund_change_val("' . $start_date . '","' . $type_id . '","' . $days . '","weekly")';
        } else {
            $start_date = date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
            $end_date = date('Y-m-d', mktime(0, 0, 0, date("m"), 0));
            // dd($end_date);
            // $days = strtotime($start_date) - strtotime($end_date);
            // $days = (int)round($days / (60 * 60 * 24))+1;
            // $days = 30;
            // dd(date('d', strtotime($end_date)));
            $end_days = date('d', strtotime($end_date));
            if ($end_days == 31) {
                // dd('31');
                $days = 30;
            } elseif ($end_days == 30) {
                $days = 29;
            } elseif ($end_days == 29) {
                $days = 28;
            } elseif ($end_days == 28) {
                $days = 27;
            }
            //  dd($days.'-final');
            $query = 'CALL sp_snapshot_fund_change_val("' . $end_date . '","' . $type_id . '","' . $days . '","monthly")';
        }

        // dd($start_date);
        // dd($type_id);
        // dd($days);
        // $changes_fund = DB::select('CALL sp_snapshot_fund_change_val("'.$start_date.'","'.$type_id.'",'.$days.')');
        // dd($changes_fund);
        // dd($days);
        // $query = 'CALL sp_snapshot_fund_change_val("'.$start_date.'","'.$type_id.'","'.$days.'","")';
        // dd($query);
        $changes_fund = DB::select($query);
        // Print the SQL query
        // echo $query;

        if (count($changes_fund)) {
            $responseArr['changes_fund'] = $changes_fund;
            $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getChangesIndex(Request $request)
    {
        // dd($request->all());
        $dataArr = $responseArr = [];
        $message = __('message');
        if (!empty($request->from_date)) {
            $date = date("Y-m-d", strtotime($request->from_date));
        } else {
            $date = date("Y-m-d");
        }
        // dd($date);

        if ($request->type == 'weekly') {
            // dd('weekly');
            $weekday = date('l', strtotime($date));
            if ($weekday == 'Monday') {
                $start_date = date('Y-m-d', strtotime('-3 days'));
                $end_date = date('Y-m-d', strtotime('-9 days'));
                // dd("Monday Start Date: ".$start_date." End Date: ".$end_date); 
            }
            if ($weekday == 'Tuesday') {
                $start_date = date('Y-m-d', strtotime('-4 days'));
                $end_date = date('Y-m-d', strtotime('-10 days'));
            }
            if ($weekday == 'Wednesday') {
                $start_date = date('Y-m-d', strtotime('-5 days'));
                $end_date = date('Y-m-d', strtotime('-11 days'));
                // dd("Start Date: ".$start_date." End Date: ".$end_date);
            }
            if ($weekday == 'Thursday') {
                $start_date = date('Y-m-d', strtotime('-6 days'));
                $end_date = date('Y-m-d', strtotime('-12 days'));
            }
            if ($weekday == 'Friday') {
                $start_date = date('Y-m-d', strtotime('-0 days'));
                $end_date = date('Y-m-d', strtotime('-6 days'));
            }
            if ($weekday == 'Saturday') {
                $start_date = date('Y-m-d', strtotime('-1 days'));
                $end_date = date('Y-m-d', strtotime('-7 days'));
            }
            if ($weekday == 'Sunday') {
                $start_date = date('Y-m-d', strtotime('-2 days'));
                $end_date = date('Y-m-d', strtotime('-8 days'));
            }
            $days = 6;

            // dd("Start Date: ".$start_date." End Date: ".$end_date);
            // dd($end_date);
            $changes_indices = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_INDICES","' . $start_date . '",' . $days . ')');
            if (count($changes_indices)) {
                // dd($changes_indices);
                $responseArr['changes_index'] = $changes_indices;
                $responseArr['from_date'] = $start_date;
                $responseArr['to_date'] = $end_date;
                return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
            }
        } else {
            $start_date = Carbon::parse($date)->subMonth()->format('Y-m-d');
            $end_date = $date;
            // dd('start_date: '.$start_date." End Date:".$end_date);
            // $end_date= date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
            $days = strtotime($end_date) - strtotime($start_date);
            // dd($days);
            $days = (int)round($days / (60 * 60 * 24));
            // $days = 30;
            // dd($days);
            // dd("Start Date: ".$start_date." End Date: ".$end_date);
            // dd("Start Date: ".$start_date." End Date: ".$end_date);
            // dd($end_date);
            $changes_indices = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_INDICES","' . $end_date . '",' . $days . ')');
            // dd('CALL sp_snapshot_indices_currency_commodity("GET_INDICES","'.$end_date.'",'.$days.')');
            if (count($changes_indices)) {
                // dd($changes_indices);
                $responseArr['changes_index'] = $changes_indices;
                $responseArr['from_date'] = $start_date;
                $responseArr['to_date'] = $end_date;
                return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
            }
        }

        return $this->sendError($message['data_not_available'], '');
    }
    public function getChangesCurrency(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $date = date("Y-m-d");
        if ($request->type == 'weekly') {
            $weekday = date('l', strtotime($date));
            if ($weekday == 'Monday') {
                $start_date = date('Y-m-d', strtotime('-3 days'));
                $end_date = date('Y-m-d', strtotime('-9 days'));
            }
            if ($weekday == 'Tuesday') {
                $start_date = date('Y-m-d', strtotime('-4 days'));
                $end_date = date('Y-m-d', strtotime('-10 days'));
            }
            if ($weekday == 'Wednesday') {
                $start_date = date('Y-m-d', strtotime('-5 days'));
                $end_date = date('Y-m-d', strtotime('-11 days'));
            }
            if ($weekday == 'Thursday') {
                $start_date = date('Y-m-d', strtotime('-6 days'));
                $end_date = date('Y-m-d', strtotime('-12 days'));
            }
            if ($weekday == 'Friday') {
                $start_date = date('Y-m-d', strtotime('-0 days'));
                $end_date = date('Y-m-d', strtotime('-6 days'));
            }
            if ($weekday == 'Saturday') {
                $start_date = date('Y-m-d', strtotime('-1 days'));
                $end_date = date('Y-m-d', strtotime('-7 days'));
            }
            if ($weekday == 'Sunday') {
                $start_date = date('Y-m-d', strtotime('-2 days'));
                $end_date = date('Y-m-d', strtotime('-8 days'));
            }
            $days = 6;
        } else {
            $start_date = date('Y-m-d', mktime(0, 0, 0, date("m"), 0));
            $end_date = date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
            $days = strtotime($start_date) - strtotime($end_date);
            $days = (int)round($days / (60 * 60 * 24));
        }

        $changes_currency = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_CURRENCY","' . $start_date . '",' . $days . ')');
        if (count($changes_currency)) {
            $responseArr['changes_currency'] = $changes_currency;
            $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getPerformanceSynopsis(Request $request)
    {
        $responseArr = [];
        $message = __('message');
        $data = [];
        $one = $two = $three = $four = 0;
        $start_date = $last_date = "";

        // $dataArr = FundMaster::selectRaw('COUNT(fund_code) as total_fund')->selectRaw('fund_house')->where('fund_house', $request->fund_house)->groupby('fund_house')->orderBy('fund_house', 'ASC')->get(); before one commented by codtrees
        $dataArr = FundMaster::selectRaw('COUNT(fund_code) as total_fund')->selectRaw('fund_house')->groupby('fund_house')->orderBy('fund_house', 'ASC')->get();
        //echo '<pre>';
        //print_r($dataArr);
        //dd($dataArr);
        /*$dataArr = FundMaster::selectRaw('COUNT(fund_code) as total_fund')->selectRaw('fund_house')->groupby('fund_house')->orderBy('fund_house', 'ASC')->limit(1)->get();*/

        //dd($dataArr);


        if (!empty($dataArr)) {
            foreach ($dataArr as $key => $item) {
                $data[$key]['total_scheme'] = $item->total_fund;
                $data[$key]['fund_house'] = $item->fund_house;

                $fund_codes = FundMaster::select('fund_code', 'fund_type_id')->where('fund_house', $item->fund_house)->where('status', 1)->get();

                //dd($fund_codes);

                if (!empty($fund_codes)) {
                    foreach ($fund_codes as $fundcode) {
                        $last_date = FundDetail::getLastPublishedDate($fundcode->fund_code);

                        $start_date = date('Y-m-d', strtotime($last_date . ' - 6 months'));

                        //echo 'CALL sp_fund_search_scheme_ret("' . $last_date . '","' . $fundcode . '")';

                        $return_scheme = DB::select('CALL sp_fund_search_scheme_ret("' . $last_date . '","' . $fundcode->fund_code . '")');

                        //dd($return_scheme);

                        $dataLagardLeader = DB::select('CALL sp_get_cagr_quartile_ps("' . $start_date . '","' . $last_date . '","' . $fundcode->fund_code . '","' . $fundcode->fund_type_id . '")');

                        /*if($dataLagardLeader[0]->leader || $dataLagardLeader[0]->laggard)
						{
							echo $dataLagardLeader[0]->leader.' ## '.$dataLagardLeader[0]->laggard;
						}*/

                        if (!empty($dataLagardLeader)) {
                            $quartile = $this->getQuartile($return_scheme[0]->SIXMONTHS, $dataLagardLeader[0]->leader, $dataLagardLeader[0]->laggard);

                            switch ($quartile) {
                                case 1:
                                    $one++;
                                    break;

                                case 2:
                                    $two++;
                                    break;

                                case 3:
                                    $three++;
                                    break;

                                case 4:
                                    $four++;
                                    break;
                            }
                        }
                    }

                    $data[$key]['one'] = $one;
                    $data[$key]['two'] = $two;
                    $data[$key]['three'] = $three;
                    $data[$key]['four'] = $four;
                }
            }

            //dd($data);

            $response['data'] = $data;
            $response['start_date'] = date('d-m-Y', strtotime($start_date));
            $response['last_date'] = date('d-m-Y', strtotime($last_date));

            return $this->sendResponse($response, __('api.success.api_dt_rtrv'));
        }

        return $this->sendError($message['data_not_available'], '');
    }
    public function getQuartile($scheme_return_sixmonths, $leader, $lagard)
    {
        $quartile_class_gap = number_format(((number_format($leader, 2) - number_format($lagard, 2)) / 4), 3);

        $first_value = number_format($leader, 2);
        $second_value = $first_value - $quartile_class_gap;
        $third_value = 0;
        $num_val = 0;
        $scheme_return_sixmonths = $scheme_return_sixmonths != 0 ? number_format($scheme_return_sixmonths, 2) : 0;

        if ($scheme_return_sixmonths == 0) {
            return 0;
        }

        if ($second_value <= $scheme_return_sixmonths &&  $scheme_return_sixmonths <= $first_value) {
            $num_val = 1;
        } else {

            for ($i = 2; $i <= 4; $i++) {
                $third_value = $second_value;
                $first_value = $third_value;
                $second_value = ($first_value - $quartile_class_gap);
                $third_value = 0;

                if ($second_value <= $scheme_return_sixmonths &&  $scheme_return_sixmonths <= $first_value) {
                    $num_val = $i;
                }
            }
        }

        return $num_val;
    }
    public function getChangesCommodity(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $date = date("Y-m-d");
        if ($request->type == 'weekly') {
            $weekday = date('l', strtotime($date));
            if ($weekday == 'Monday') {
                $start_date = date('Y-m-d', strtotime('-3 days'));
                $end_date = date('Y-m-d', strtotime('-9 days'));
            }
            if ($weekday == 'Tuesday') {
                $start_date = date('Y-m-d', strtotime('-4 days'));
                $end_date = date('Y-m-d', strtotime('-10 days'));
            }
            if ($weekday == 'Wednesday') {
                $start_date = date('Y-m-d', strtotime('-5 days'));
                $end_date = date('Y-m-d', strtotime('-11 days'));
            }
            if ($weekday == 'Thursday') {
                $start_date = date('Y-m-d', strtotime('-6 days'));
                $end_date = date('Y-m-d', strtotime('-12 days'));
            }
            if ($weekday == 'Friday') {
                $start_date = date('Y-m-d', strtotime('-0 days'));
                $end_date = date('Y-m-d', strtotime('-6 days'));
            }
            if ($weekday == 'Saturday') {
                $start_date = date('Y-m-d', strtotime('-1 days'));
                $end_date = date('Y-m-d', strtotime('-7 days'));
            }
            if ($weekday == 'Sunday') {
                $start_date = date('Y-m-d', strtotime('-2 days'));
                $end_date = date('Y-m-d', strtotime('-8 days'));
            }
            $days = 6;
        } else {
            $start_date = date('Y-m-d', mktime(0, 0, 0, date("m"), 0));
            $end_date = date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
            $days = strtotime($start_date) - strtotime($end_date);
            $days = (int)round($days / (60 * 60 * 24));
        }

        $changes_currency = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_COMMODITY","' . $start_date . '",' . $days . ')');
        if (count($changes_currency)) {
            $responseArr['changes_commodity'] = $changes_currency;


            $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));


            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getMonthlyRankingDate(Request $request)
    {
        $dataArr = $responseArr = [];
        $dataArr = MonthlyRatioCalculation::first();
        if (!empty($dataArr)) {
            $responseArr['date_month'] = date('F', strtotime($dataArr->end_date));
            $responseArr['date_year'] = date('Y', strtotime($dataArr->end_date));
        }
        return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }
    public function monthlyRanking(Request $request, $type_id)
    {
        // dd($type_id);
        \Log::debug('Type ID', [$type_id]);
        $dataArr = $responseArr = [];


        // $end_date = CorpusEntry::getLastPublishedDate();
        // $start_date = Carbon::parse($end_date)->subMonths(12)->addDay()->format('Y-m-d');
        // $first_period_start_date = Carbon::parse($end_date)->subMonths(3)->format('Y-m-d');
        // $first_period_end_date = $end_date;

        // $second_period_start_date = Carbon::parse($first_period_start_date)->subMonths(3)->format('Y-m-d');
        // $second_period_end_date = Carbon::parse($first_period_start_date)->subDay()->format('Y-m-d');

        // $third_period_start_date = Carbon::parse($second_period_start_date)->subMonths(3)->format('Y-m-d');
        // $third_period_end_date = Carbon::parse($second_period_start_date)->subDay()->format('Y-m-d');

        // $fourth_period_start_date = Carbon::parse($third_period_start_date)->subMonths(3)->format('Y-m-d');
        // $fourth_period_end_date = Carbon::parse($third_period_start_date)->subDay()->format('Y-m-d');
        // dd([
        //     $first_period_start_date,$first_period_end_date,
        //     $second_period_start_date,$second_period_end_date,
        //     $third_period_start_date,$third_period_end_date,
        //     $fourth_period_start_date,$fourth_period_end_date,
        // ]);
        $dataArr = MonthlyRatioCalculation::list(['fund_type_id' => $type_id]);
        // dd($dataArr);
        // echo "<pre>";print_r($dataArr);die;
        // \Log::debug('data_array', [$dataArr]);
        // print_r($dataArr);die;
        $volatalityArr = $betaArr = $jensenAlphaArr = [];
        if (count($dataArr) > 0) {
            // dd('if');
            foreach ($dataArr as $fund) {
                if ($fund->p1_volatality !== null && $fund->p2_volatality !== null && $fund->p3_volatality !== null && $fund->p4_volatality !== null) {
                    $volatalityArr[0][$fund->fund_code] = $fund->p1_volatality;
                    $volatalityArr[1][$fund->fund_code] = $fund->p2_volatality;
                    $volatalityArr[2][$fund->fund_code] = $fund->p3_volatality;
                    $volatalityArr[3][$fund->fund_code] = $fund->p4_volatality;
                }
                if ($fund->p1_beta !== null && $fund->p2_beta !== null && $fund->p3_beta !== null && $fund->p4_beta !== null) {
                    $betaArr[0][$fund->fund_code] = $fund->p1_beta;
                    $betaArr[1][$fund->fund_code] = $fund->p2_beta;
                    $betaArr[2][$fund->fund_code] = $fund->p3_beta;
                    $betaArr[3][$fund->fund_code] = $fund->p4_beta;
                }
                if ($fund->p1_jensen_alpha !== null && $fund->p2_jensen_alpha !== null && $fund->p3_jensen_alpha !== null && $fund->p4_jensen_alpha !== null) {
                    $jensenAlphaArr[0][$fund->fund_code] = $fund->p1_jensen_alpha;
                    $jensenAlphaArr[1][$fund->fund_code] = $fund->p2_jensen_alpha;
                    $jensenAlphaArr[2][$fund->fund_code] = $fund->p3_jensen_alpha;
                    $jensenAlphaArr[3][$fund->fund_code] = $fund->p4_jensen_alpha;
                }
            }


            foreach ($dataArr as $index => $fund) {
                \Log::debug('fund', [$fund->fund_code]);
                $dataArr[$index]['volatality'] = $dataArr[$index]['market_risk'] = $dataArr[$index]['return_quality'] = null;
                if ($fund->p1_volatality !== null && $fund->p2_volatality !== null && $fund->p3_volatality !== null && $fund->p4_volatality !== null) {
                    // dd($fund->fund_code.'-------'.$volatalityArr);
                    $dataArr[$index]['volatality'] = $this->gtRiskRatiosval($fund->fund_code, $volatalityArr);
                }
                // dd($dataArr[$index]['volatality']);
                if ($fund->p1_beta !== null && $fund->p2_beta !== null && $fund->p3_beta !== null && $fund->p4_beta !== null) {
                    $dataArr[$index]['market_risk'] = $this->gtRiskRatiosval($fund->fund_code, $betaArr);
                }
                if ($fund->p1_jensen_alpha !== null && $fund->p2_jensen_alpha !== null && $fund->p3_jensen_alpha !== null && $fund->p4_jensen_alpha !== null) {
                    $dataArr[$index]['return_quality'] = $this->gtReturnQualityval($fund->fund_code, $jensenAlphaArr);
                }
                $unset_array = array("p1_volatality", "p2_volatality", "p3_volatality", "p4_volatality", 'p1_beta', 'p2_beta', 'p3_beta', 'p4_beta', 'p1_jensen_alpha', 'p2_jensen_alpha', 'p3_jensen_alpha', 'p4_jensen_alpha');
                foreach ($unset_array as $key) {
                    unset($dataArr[$index][$key]);
                }
            }
            $responseArr['monthly_ranking'] = $dataArr;
            // $dataArr[0]['end_date'] = '2024-01-31';
            // $dataArr[0]['start_date'] = '2023-12-01';
            $responseArr['from_date'] = date('d/m/Y', strtotime($dataArr[0]['start_date']));
            $responseArr['to_date'] = date('d/m/Y', strtotime($dataArr[0]['end_date']));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        } else {
            // dd('else');
            $responseArr['monthly_ranking'] = $dataArr;
            // $dataArr[0]['end_date'] = '2024-01-31';
            // $dataArr[0]['start_date'] = '2023-12-01';
            $responseArr['from_date'] = '';
            $responseArr['to_date'] = '';

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
    }
    //Volatility and Market Risk avg
    public function gtRiskRatiosval($fund_code, $ratioArr)
    {
        // dd($ratioArr);
        $calArr = [];
        foreach ($ratioArr as $key => $dataArr) {
            $dataArr = array_filter($dataArr, fn($value) => !is_null($value) && $value !== '');
            arsort($dataArr);
            // dd(max($dataArr));
            // dd($dataArr);
            $value_vol = (max($dataArr) - min($dataArr)) / 5;
            $value_1_vol = max($dataArr);
            // dd($value_1_vol);
            $value_2_vol = $value_1_vol - $value_vol;
            $value_3_vol = $value_2_vol - $value_vol;
            $value_4_vol = $value_3_vol - $value_vol;
            $value_5_vol = $value_4_vol - $value_vol;
            $value_6_vol = min($dataArr);
            // dd($value_1_vol.'|'.$value_2_vol.'|'.$value_3_vol.'|'.$value_4_vol.'|'.$value_5_vol.'|'.$value_6_vol);

            //\log::debug('values - '.$key, [$value_1_vol,$value_2_vol,$value_3_vol,$value_4_vol,$value_5_vol,$value_6_vol]);

            $final_val_vol = $dataArr[$fund_code];
            // dd($final_val_vol);
            //\log::debug('final_val_vol - '.$key, [$fund_code,$dataArr[$fund_code]]);
            /*
            old logic
            if ($final_val_vol <= $value_1_vol && $final_val_vol >= $value_2_vol) {
                $param_vol = 1;
            } elseif ($final_val_vol <= $value_2_vol && $final_val_vol >= $value_3_vol) {
                $param_vol = 2;
            } elseif ($final_val_vol <= $value_3_vol && $final_val_vol >= $value_4_vol) {
                $param_vol = 3;
            } elseif ($final_val_vol <= $value_4_vol && $final_val_vol >= $value_5_vol) {
                $param_vol = 4;
            } else {
                $param_vol = 5;
            }
            */

            //new logic 07.03.2024 changed by : Saikat Banerjee
            if ($final_val_vol >= $value_2_vol && $final_val_vol <= $value_1_vol) {
                $param_vol = 5;
            } elseif ($final_val_vol >= $value_3_vol && $final_val_vol <= $value_2_vol) {
                $param_vol = 4;
            } elseif ($final_val_vol >= $value_4_vol && $final_val_vol <= $value_3_vol) {
                $param_vol = 3;
            } elseif ($final_val_vol >= $value_5_vol && $final_val_vol <= $value_4_vol) {
                $param_vol = 2;
            } elseif ($final_val_vol >= $value_6_vol && $final_val_vol <= $value_5_vol) {
                $param_vol = 1;
            } else {
                $param_vol = 0;
            }
            // dd($param_vol);
            //\log::debug('param_vol - '.$key, [$fund_code,$param_vol]);

            $calArr[$key] = $param_vol;
        }
        $avgva = array_sum($calArr) / 4;
        // dd(round($avgva));
        // return round($avgva,2);
        // return round($avgva);
        if ($avgva <= 5 && $avgva > 4) {
            return 5;
        } elseif ($avgva <= 4 && $avgva > 3) {
            return 4;
        } elseif ($avgva <= 3 && $avgva > 2) {
            return 3;
        } elseif ($avgva <= 2 && $avgva > 1) {
            return 2;
        } elseif ($avgva <= 1 && $avgva > 0) {
            return 1;
        }
    }
    //Return Quality avg
    public function gtReturnQualityval($fund_code, $sdArr)
    {
        $calArr = [];
        foreach ($sdArr as $key => $dataArr) {
            $dataArr = array_filter($dataArr, fn($value) => !is_null($value) && $value !== '');
            arsort($dataArr);
            $value_vol = (max($dataArr) - min($dataArr)) / 5;
            $value_1_vol = min($dataArr);
            $value_2_vol = $value_1_vol + $value_vol;
            $value_3_vol = $value_2_vol + $value_vol;
            $value_4_vol = $value_3_vol + $value_vol;
            $value_5_vol = $value_4_vol + $value_vol;
            $value_6_vol = max($dataArr);

            //\log::debug('values - '.$key, [$value_1_vol,$value_2_vol,$value_3_vol,$value_4_vol,$value_5_vol,$value_6_vol]);

            $final_val_vol = $dataArr[$fund_code];
            //\log::debug('final_val_vol - '.$key, [$fund_code,$dataArr[$fund_code]]);

            if ($final_val_vol >= $value_1_vol && $final_val_vol < $value_2_vol) {
                $param_vol = 1;
            } elseif ($final_val_vol >= $value_2_vol && $final_val_vol < $value_3_vol) {
                $param_vol = 2;
            } elseif ($final_val_vol >= $value_3_vol && $final_val_vol < $value_4_vol) {
                $param_vol = 3;
            } elseif ($final_val_vol >= $value_4_vol && $final_val_vol < $value_5_vol) {
                $param_vol = 4;
            } else {
                $param_vol = 5;
            }
            //\log::debug('param_vol - '.$key, [$fund_code,$param_vol]);

            $calArr[$key] = $param_vol;
        }
        $avgva = array_sum($calArr) / 4;
        // return round($avgva);
        // return $avgva;
        if ($avgva <= 5 && $avgva > 4) {
            return 5;
        } elseif ($avgva <= 4 && $avgva > 3) {
            return 4;
        } elseif ($avgva <= 3 && $avgva > 2) {
            return 3;
        } elseif ($avgva <= 2 && $avgva > 1) {
            return 2;
        } elseif ($avgva <= 1 && $avgva > 0) {
            return 1;
        }
    }
    public function fundDetails(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        if ($fund_code) {
            $fund = FundMaster::where('fund_code', $request->fund_code)->first();
            $fund_detail = FundDetail::where('fund_code', $request->fund_code)->where('publish', 'y')->orderBy('entry_date', 'DESC')->first();
            // $index_detail = IndicesDetail::where('name', $fund->indices_name)->where('publish', 'y')->orderBy('entry_date', 'DESC')->first();
            // dd($index_detail);
            $indicesName = $fund->indices_name;

            $query = "
                SELECT * 
                FROM mpx_indices_detail 
                WHERE (
                    name = (SELECT corelation FROM mpx_indices_corelation WHERE name = :indicesName1) 
                    OR 
                    name = (SELECT corelation FROM mpx_indices_master WHERE name = :indicesName2)
                ) 
                AND publish = 'y' 
                ORDER BY entry_date DESC 
                LIMIT 1
            ";

            $results = DB::select($query, [
                'indicesName1' => $indicesName,
                'indicesName2' => $indicesName,
            ]);
            $arrayResults = json_decode(json_encode($results), true);
            // dd($arrayResults);
            $index_detail = $arrayResults[0];
            // dd($index_detail);
            $corpus_detail = CorpusEntry::where('fund_code', $fund->fund_code)->where('publish', 'y')->orderBy('entry_date', 'DESC')->first();
            $no_of_schemes = FundMaster::where('fund_type_id', $fund->fund_type_id)->count();

            $dataArr['benchmark'] = $fund->indices_name;
            $dataArr['benchmark_closing_value'] = \Arr::get($index_detail, 'closing_value', '');
            $dataArr['benchmark_entry_date'] =  date('d-m-Y', strtotime(\Arr::get($index_detail, 'entry_date', '')));
            $dataArr['category'] = $fund->classification;
            $dataArr['fund_house'] = $fund->fund_house;
            $dataArr['fund_code'] = $fund->fund_code;
            $dataArr['fund_opened'] = date('d-m-Y', strtotime($fund->fund_opened));
            $dataArr['fund_man'] = $fund->fund_manager;
            $dataArr['nav'] = \Arr::get($fund_detail, 'closing_nav', '');
            $dataArr['nav_entry_date'] = date('d-m-Y', strtotime(\Arr::get($fund_detail, 'entry_date', '')));
            $dataArr['aaum'] = \Arr::get($corpus_detail, 'corpus_entry', '');
            $dataArr['no_of_schemes'] = $no_of_schemes;

            $responseArr['fund_details'] = $dataArr;
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function fundReturnScheme(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        if ($fund_code) {
            $last_date = FundDetail::getLastPublishedDate($fund_code);
            //dd($last_date);
            try {
                $return_scheme = DB::select('CALL sp_fund_search_scheme_ret("' . $last_date . '","' . $fund_code . '")');
                //dd($return_scheme);
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            if (count($return_scheme)) {
                $responseArr['return_scheme'] = $return_scheme[0];
                $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));
                return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
            }
        }
        return $this->sendError($message['data_not_available'], '');
    }
    
    public function fundReturnSchemeDis(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        if ($fund_code) {
            $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
            $updated_at = date('Y-m-d',strtotime($fundWatch->published_date));
            $last_date = FundDetail::select('entry_date')->where('fund_code', $fund_code)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first()->entry_date;
            
            //$last_date = FundDetail::getLastPublishedDate($fund_code);

            // dd($last_date);
            $last_dateone1 = date('Y-m-d', strtotime($last_date . ' - 6 months'));
            // dd($last_dateone1);
            $last_dateone = date('Y-m-d', strtotime($last_dateone1 . ' -1 day'));
            $last_datetwo1 = date('Y-m-d', strtotime($last_dateone . ' - 1 year'));
            $last_datetwo = date('Y-m-d', strtotime($last_datetwo1 . ' -1 day'));


            //dd($last_date.'--------'.$last_dateone1.'--------'.$last_dateone.'--------'.$last_datetwo1.'--------'.$last_datetwo);
            try {
                $return_scheme = DB::select('CALL sp_fund_search_scheme_ret("' . $last_date . '","' . $fund_code . '")');
                $return_scheme2 = DB::select('CALL sp_fund_search_scheme_ret("' . $last_dateone . '","' . $fund_code . '")');
                $return_scheme3 = DB::select('CALL sp_fund_search_scheme_ret("' . $last_datetwo . '","' . $fund_code . '")');

                $return_scheme[0]->ODDONEYEAR = $return_scheme2[0]->ONEYEAR;
                $return_scheme[0]->ODDTWOYEAR = $return_scheme3[0]->TWOYEAR;

                //dd($return_scheme);
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            if (count($return_scheme)) {
                $responseArr['return_scheme'] = $return_scheme[0];
                $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));
                return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
            }
        }
        return $this->sendError($message['data_not_available'], '');
    }
    /*  public function fundReturnBenchmark(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        $indices_name = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();

        if ($fund_code && !empty($indices_name)) {
            $last_date = FundDetail::getLastPublishedDate($fund_code);

            $return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret("'.$last_date.'","'.$indices_name->indices_name.'","'.$fund_code.'")');
            if (count($return_benchmark)) {
                $responseArr['return_benchmark'] = $return_benchmark[0];
                $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));
                return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
            }
        }
        return $this->sendError($message['data_not_available'], '');
    } */
    public function fundReturnBenchmark(Request $request)
    {
        // dd($request->all());
        $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        // dd($fund_code);
        $indices_name = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();

        if ($fund_code && !empty($indices_name)) {
            //$last_date = IndicesDetail::getLastPublishedDate($indices_name->indices_name);
            $last_date = IndicesDetail::select('entry_date')->where('name', $indices_name->indices_name)->orderBy('idcd_id', 'desc')->first()->entry_date;
            // dd($indices_name->indices_name);
            // dd($last_date);
            
            //$return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret("' . $last_date . '","' . $indices_name->indices_name . '","' . $fund_code . '")');
            $return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret_new("' . $last_date . '","' . $indices_name->indices_name . '","' . $fund_code . '")');
            // dd($return_benchmark);
            if (count($return_benchmark)) {
                $responseArr['return_benchmark'] = $return_benchmark[0];
                $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));
                return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
            }
        }
        return $this->sendError($message['data_not_available'], '');
    }

    public function fundReturnBenchmarkDis(Request $request)
    {
        // dd($request->all());
        $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        // dd($fund_code);
        $indices_name = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();
        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
        $updated_at = date('Y-m-d',strtotime($fundWatch->published_date));
        
        if ($fund_code && !empty($indices_name)) {
            //$last_date = IndicesDetail::getLastPublishedDate($indices_name->indices_name);
            $last_date = IndicesDetail::select('entry_date')->where('name', $indices_name->indices_name)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->orderBy('idcd_id', 'desc')->first()->entry_date;
            // dd($indices_name->indices_name);
            // dd($last_date);
            
            $last_dateone1 = date('Y-m-d', strtotime($last_date . ' - 6 months'));
            $last_dateone = date('Y-m-d', strtotime($last_dateone1 . ' -1 day'));
            $last_datetwo1 = date('Y-m-d', strtotime($last_dateone . ' - 1 year'));
            $last_datetwo = date('Y-m-d', strtotime($last_datetwo1 . ' -1 day'));



            //$return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret("' . $last_date . '","' . $indices_name->indices_name . '","' . $fund_code . '")');
            $return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret_new2("' . $last_date . '","' . $indices_name->indices_name . '","' . $fund_code . '")');
            $return_benchmark2 = DB::select('CALL sp_fund_search_benchmark_ret_new2("' . $last_dateone . '","' . $indices_name->indices_name . '","' . $fund_code . '")');
            $return_benchmark3 = DB::select('CALL sp_fund_search_benchmark_ret_new2("' . $last_datetwo . '","' . $indices_name->indices_name . '","' . $fund_code . '")');

            //dd($last_date.'--------'.$last_dateone1.'--------'.$last_dateone.'--------'.$last_datetwo1.'--------'.$last_datetwo);
            //dd($return_benchmark3);



            $return_benchmark[0]->ODDONEYEAR = $return_benchmark2[0]->ONEYEAR;
            $return_benchmark[0]->ODDTWOYEAR = $return_benchmark3[0]->TWOYEAR;
            if (count($return_benchmark)) {
                $responseArr['return_benchmark'] = $return_benchmark[0];
                $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));
                return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
            }
        }
        return $this->sendError($message['data_not_available'], '');
    }


    public function fundPerformanceCompareToCategory(Request $request)
    {
        // dd($request->all());
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        $fund_type_id = FundMaster::select('fund_type_id')->where('fund_code', $fund_code)->first();
        if ($fund_code && !empty($fund_type_id)) {
            $last_date = FundDetail::getLastPublishedDate($fund_code);

            //dd($nlastdate);


            try {
                // echo date('Y-m-d', strtotime($last_date. ' - 7 days'));die;
                // echo $last_date;die;
                // echo $fund_code;die;
                // echo $fund_type_id->fund_type_id;die;
                // echo "First Date : ".date('Y-m-d', strtotime($last_date. ' - 1 year'))." Last Date : ".$last_date;die;
                // DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 6 days')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');

                $dataArr['SEVENDAYS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 6 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                // dd($dataArr['SEVENDAYS'][0]);
                if (!empty($dataArr['SEVENDAYS'])) {
                    $sevenDays_cagr = $dataArr['SEVENDAYS'][0]->cagr_value;
                    $sevenDays_quartile_sp = DB::select('CALL sp_calculate_quartile("' . date('Y-m-d', strtotime($last_date . ' - 6 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $sevenDays_cagr . '")');
                    // dd($sevenDays_quartile_sp[0]->quartile);
                    $sevenDays_quartile = $sevenDays_quartile_sp[0]->quartile;
                    $dataArr['SEVENDAYS'][0]->quartile = $sevenDays_quartile;
                    // dd($sevenDays_quartile);
                    $sevenDays_decile_sp = DB::select('CALL sp_calculate_decile("' . date('Y-m-d', strtotime($last_date . ' - 6 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $sevenDays_cagr . '")');
                    // dd($sevenDays_decile_sp[0]->decile);
                    $sevenDays_decile = $sevenDays_decile_sp[0]->decile;
                    // dd($sevenDays_decile);
                    $dataArr['SEVENDAYS'][0]->decile = $sevenDays_decile;
                    // dd($dataArr['SEVENDAYS'][0]);
                }
                //$dataArr['THIRTYDAYS'] = DB::select('CALL sp_get_cagr_quartile_decile_new("'.date('Y-m-d', strtotime($last_date. ' - 30 days')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');
                // DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 1 month')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');
                $dataArr['THIRTYDAYS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 30 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                $thirtyDays_cagr = $dataArr['THIRTYDAYS'][0]->cagr_value;
                if (!empty($dataArr['THIRTYDAYS'])) {
                    // Calculate quartile using the 30-day CAGR value and fund information
                    $thirtyDays_quartile_sp = DB::select('CALL sp_calculate_quartile("' . date('Y-m-d', strtotime($last_date . ' - 30 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $thirtyDays_cagr . '")');

                    // Extract and assign the quartile value for 30 days
                    $thirtyDays_quartile = $thirtyDays_quartile_sp[0]->quartile;
                    $dataArr['THIRTYDAYS'][0]->quartile = $thirtyDays_quartile;

                    // Calculate decile using the 30-day CAGR value and fund information
                    $thirtyDays_decile_sp = DB::select('CALL sp_calculate_decile("' . date('Y-m-d', strtotime($last_date . ' - 30 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $thirtyDays_cagr . '")');

                    // Extract and assign the decile value for 30 days
                    $thirtyDays_decile = $thirtyDays_decile_sp[0]->decile;
                    $dataArr['THIRTYDAYS'][0]->decile = $thirtyDays_decile;
                    // dd($dataArr['THIRTYDAYS'][0]);    
                }

                //$dataArr['NINTYDAYS'] = DB::select('CALL sp_get_cagr_quartile_decile_new("'.date('Y-m-d', strtotime($last_date. ' - 90 days')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');
                // DB::select('CALL sp_get_cagr_test("' . date('Y-m-d', strtotime($last_date . ' - 3 months')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');

                $dataArr['NINTYDAYS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 90 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                if (!empty($dataArr['NINTYDAYS'])) {
                    $nintyDays_cagr = $dataArr['NINTYDAYS'][0]->cagr_value;
                    $nintyDays_quartile_sp = DB::select('CALL sp_calculate_quartile("' . date('Y-m-d', strtotime($last_date . ' - 90 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $nintyDays_cagr . '")');
                    $nintyDays_quartile = $nintyDays_quartile_sp[0]->quartile;
                    $dataArr['NINTYDAYS'][0]->quartile = $nintyDays_quartile;
                    $nintyDays_decile_sp = DB::select('CALL sp_calculate_decile("' . date('Y-m-d', strtotime($last_date . ' - 90 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $nintyDays_cagr . '")');
                    $nintyDays_decile = $nintyDays_decile_sp[0]->decile;
                    $dataArr['NINTYDAYS'][0]->decile = $nintyDays_decile;
                    // dd($dataArr['NINTYDAYS'][0]);
                }
                // $dataArr['SIXMONTHS'] = DB::select('CALL sp_get_cagr_quartile_decile_new("'.date('Y-m-d', strtotime($last_date. ' - 183 days')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');
                // DB::select('CALL sp_get_cagr_test("' . date('Y-m-d', strtotime($last_date . ' - 6 months')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');

                $dataArr['SIXMONTHS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 182 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                if (!empty($dataArr['SIXMONTHS'])) {
                    $sixMonths_cagr = $dataArr['SIXMONTHS'][0]->cagr_value;
                    $sixMonths_quartile_sp = DB::select('CALL sp_calculate_quartile("' . date('Y-m-d', strtotime($last_date . ' - 182 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $sixMonths_cagr . '")');
                    $sixMonths_quartile = $sixMonths_quartile_sp[0]->quartile;
                    $dataArr['SIXMONTHS'][0]->quartile = $sixMonths_quartile;
                    $sixMonths_decile_sp = DB::select('CALL sp_calculate_decile("' . date('Y-m-d', strtotime($last_date . ' - 182 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $sixMonths_cagr . '")');
                    $sixMonths_decile = $sixMonths_decile_sp[0]->decile;
                    $dataArr['SIXMONTHS'][0]->decile = $sixMonths_decile;
                    // dd($dataArr['SIXMONTHS'][0]);
                }
                // DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 1 year')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');
                $dataArr['ONEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 366 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                if (!empty($dataArr['ONEYEAR'])) {
                    $oneYear_cagr = $dataArr['ONEYEAR'][0]->cagr_value;
                    $oneYear_quartile_sp = DB::select('CALL sp_calculate_quartile("' . date('Y-m-d', strtotime($last_date . ' - 366 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $oneYear_cagr . '")');
                    $oneYear_quartile = $oneYear_quartile_sp[0]->quartile;
                    $dataArr['ONEYEAR'][0]->quartile = $oneYear_quartile;
                    $oneYear_decile_sp = DB::select('CALL sp_calculate_decile("' . date('Y-m-d', strtotime($last_date . ' - 366 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $oneYear_cagr . '")');
                    $oneYear_decile = $oneYear_decile_sp[0]->decile;
                    $dataArr['ONEYEAR'][0]->decile = $oneYear_decile;
                    // dd($dataArr['ONEYEAR'][0]);   
                }
                // DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 2 year')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');

                $dataArr['TWOYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 731 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                if (!empty($dataArr['TWOYEAR'])) {
                    $twoYear_cagr = $dataArr['TWOYEAR'][0]->cagr_value;
                    $twoYear_quartile_sp = DB::select('CALL sp_calculate_quartile("' . date('Y-m-d', strtotime($last_date . ' - 731 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $twoYear_cagr . '")');
                    $twoYear_quartile = $twoYear_quartile_sp[0]->quartile;
                    $dataArr['TWOYEAR'][0]->quartile = $twoYear_quartile;
                    $twoYear_decile_sp = DB::select('CALL sp_calculate_decile("' . date('Y-m-d', strtotime($last_date . ' - 731 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $twoYear_cagr . '")');
                    $twoYear_decile = $twoYear_decile_sp[0]->decile;
                    $dataArr['TWOYEAR'][0]->decile = $twoYear_decile;
                    // dd($dataArr['TWOYEAR'][0]);
                }
                // DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 3 year')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');

                $dataArr['THREEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 1096 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                if (!empty($dataArr['THREEYEAR'])) {
                    $threeYear_cagr = $dataArr['THREEYEAR'][0]->cagr_value;
                    $threeYear_quartile_sp = DB::select('CALL sp_calculate_quartile("' . date('Y-m-d', strtotime($last_date . ' - 1096 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $threeYear_cagr . '")');
                    $threeYear_quartile = $threeYear_quartile_sp[0]->quartile;
                    $dataArr['THREEYEAR'][0]->quartile = $threeYear_quartile;
                    $threeYear_decile_sp = DB::select('CALL sp_calculate_decile("' . date('Y-m-d', strtotime($last_date . ' - 1096 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $threeYear_cagr . '")');
                    $threeYear_decile = $threeYear_decile_sp[0]->decile;
                    $dataArr['THREEYEAR'][0]->decile = $threeYear_decile;
                    // dd($dataArr['THREEYEAR'][0]);
                }

                // DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 5 year')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');

                $dataArr['FIVEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 1827 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                if (!empty($dataArr['FIVEYEAR'])) {
                    $fiveYear_cagr = $dataArr['FIVEYEAR'][0]->cagr_value;
                    $fiveYear_quartile_sp = DB::select('CALL sp_calculate_quartile("' . date('Y-m-d', strtotime($last_date . ' - 1827 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $fiveYear_cagr . '")');
                    $fiveYear_quartile = $fiveYear_quartile_sp[0]->quartile;
                    $dataArr['FIVEYEAR'][0]->quartile = $fiveYear_quartile;
                    $fiveYear_decile_sp = DB::select('CALL sp_calculate_decile("' . date('Y-m-d', strtotime($last_date . ' - 1827 days')) . '","' . $last_date . '","' . $fund_type_id->fund_type_id . '","' . $fiveYear_cagr . '")');
                    $fiveYear_decile = $fiveYear_decile_sp[0]->decile;
                    $dataArr['FIVEYEAR'][0]->decile = $fiveYear_decile;
                    // dd($dataArr['FIVEYEAR'][0]);
                }
                // echo "<pre>";print_r($dataArr);die;
                $finalArr = [];
                /*foreach ($dataArr as $key => $data) {
                if (count($data)) {
                    $finalArr[$key] = $data[0];
                } else {
                    $finalArr[$key] = [];
                }
            }*/

                $i = 0;
                $fund_nameld = "";
                $fund_name = "";
                $leadername = "";
                $laggername = "";
                $fund_nameldc = "";
                $fund_name1 = "";
                foreach ($dataArr as $key => $data) {
                    if (count($data)) {
                        switch ($key) {
                            case 'SEVENDAYS':
                                $start = date('Y-m-d', strtotime($last_date . ' - 7 days'));
                                break;
                            case 'THIRTYDAYS':
                                $start = date('Y-m-d', strtotime($last_date . ' - 30 days'));
                                break;
                            case 'NINTYDAYS':
                                $start = date('Y-m-d', strtotime($last_date . ' - 3 months'));
                                break;
                            case 'SIXMONTHS':
                                $start = date('Y-m-d', strtotime($last_date . ' - 6 months'));
                                break;
                            case 'ONEYEAR':
                                $start = date('Y-m-d', strtotime($last_date . ' - 1 year'));
                                break;
                            case 'TWOYEAR':
                                $start = date('Y-m-d', strtotime($last_date . ' - 2 year'));
                                break;
                            case 'THREEYEAR':
                                $start = date('Y-m-d', strtotime($last_date . ' - 3 year'));
                                break;
                            case 'FIVEYEAR':
                                $start = date('Y-m-d', strtotime($last_date . ' - 5 year'));
                                break;
                        }
                        $leader = number_format((float)$data[0]->leader, 2, '.');
                        $conditions = [
                            ["cagr_value", 'LIKE', "%{$leader}%"],
                            ["fund_type_id", '=', $fund_type_id->fund_type_id],
                            ["start_date", '=', $start]
                        ];
                        $fund_name = DB::table('cagrs')->select("fund_code")->where($conditions)->get();
                        if (!$fund_name->isEmpty()) {
                            $leaderfc = $fund_name[0]->fund_code;
                            $fund_nameld = DB::table('fund_master')->select("fund_name")->where("fund_code", $leaderfc)->get();
                        }
                        if ($fund_nameld != "") {
                            $leadername = $fund_nameld[0]->fund_name;
                        }
                        $lagger = number_format((float)$data[0]->laggard, 2, '.');
                        $conditions1 = [
                            ["cagr_value", 'LIKE', "%{$lagger}%"],
                            ["fund_type_id", '=', $fund_type_id->fund_type_id],
                            ["start_date", '=', $start]
                        ];
                        $fund_name1 = DB::table('cagrs')->select("fund_code")->where($conditions1)->get();
                        if (!$fund_name1->isEmpty()) {
                            $laggerfc = $fund_name1[0]->fund_code;
                            $fund_nameldc = DB::table('fund_master')->select("fund_name")->where("fund_code", 'LIKE', "%{$laggerfc}%")->get();
                        }
                        if ($fund_nameldc != "") {
                            $laggername = $fund_nameldc[0]->fund_name;
                        }
                        $finalArr[$key] = $data[0];
                        if ($leadername) {
                            $finalArr[$key . "" . $i] = $leadername;
                        }
                        if ($laggername) {
                            $finalArr[$key . "" . $i . "c"] = $laggername;
                        }
                    } else {
                        $finalArr[$key] = [];
                    }
                    $i++;
                }
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            $responseArr['category_compare_data'] = $finalArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

            //dd($finalArr);

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function fundPerformanceCompareToCategory2(Request $request)
    {
        // dd($request->all());
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        $fund_type_id = FundMaster::select('fund_type_id')->where('fund_code', $fund_code)->first();
        if ($fund_code && !empty($fund_type_id)) {
            //$last_date = FundDetail::getLastPublishedDate($fund_code);
            $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
            $updated_at = date('Y-m-d',strtotime($fundWatch->published_date));
            $last_date = FundDetail::select('entry_date')->where('fund_code', $fund_code)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first()->entry_date;

            //dd($nlastdate);


            try {
                $dataArr['SIXMONTHS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 6 months')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                $dataArr['ONEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 1 year')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                $dataArr['TWOYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 2 year')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                $dataArr['THREEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 3 year')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                $dataArr['FIVEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 5 year')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                

                $i = 0;
                foreach ($dataArr as $key => $data) {
                    if (count($data)) {
                        $finalArr[$key] = $data[0];
                    } else {
                        $finalArr[$key] = [];
                    }
                    $i++;
                }
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            $responseArr['category_compare_data'] = $finalArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

            //dd($finalArr);

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function fundPerformanceCompareToCategoryNew(Request $request)
    {
        // dd($request->all());
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        $fund_type_id = FundMaster::select('fund_type_id')->where('fund_code', $fund_code)->first();
        $fund_details = FundMaster::where('fund_code', $fund_code)->first();
        if ($fund_code && !empty($fund_type_id)) {
            $last_date = FundDetail::getLastPublishedDate($fund_code);

            //dd($nlastdate);


            try {
                // echo date('Y-m-d', strtotime($last_date. ' - 7 days'));die;
                // echo $last_date;die;
                // echo $fund_code;die;
                // echo $fund_type_id->fund_type_id;die;
                // echo "First Date : ".date('Y-m-d', strtotime($last_date. ' - 1 year'))." Last Date : ".$last_date;die;
                // DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 6 days')).'","'.$last_date.'","'.$fund_code.'","'.$fund_type_id->fund_type_id.'")');

                $all_fund_return = self::all_returns_by_fund_type($fund_details->fund_type_id, date('Y-m-d', strtotime($last_date . ' - 7 days')), $last_date);
                $fund_returns = [];
                foreach ($all_fund_return as $fundId => $fundValue) {
                    $fund_returns[$fundId] = $fundValue['fund_return_absolute'];
                }
                $decile = self::decile_calc($fund_returns, $fund_details->fund_id);
                $quartile = self::quartile_calc($fund_returns, $fund_details->fund_id);
                $dataArr['SEVENDAYS']['decile'] = $decile;
                $dataArr['SEVENDAYS']['quartile'] = $quartile;

                //dd($all_fund_return);

                $all_fund_return = self::all_returns_by_fund_type($fund_details->fund_type_id, date('Y-m-d', strtotime($last_date . ' - 30 days')), $last_date);
                $fund_returns = [];
                foreach ($all_fund_return as $fundId => $fundValue) {
                    $fund_returns[$fundId] = $fundValue['fund_return_absolute'];
                }
                $decile = self::decile_calc($fund_returns, $fund_details->fund_id);
                $quartile = self::quartile_calc($fund_returns, $fund_details->fund_id);
                $dataArr['THIRTYDAYS']['decile'] = $decile;
                $dataArr['THIRTYDAYS']['quartile'] = $quartile;

                $all_fund_return = self::all_returns_by_fund_type($fund_details->fund_type_id, date('Y-m-d', strtotime($last_date . ' - 3 months')), $last_date);
                $fund_returns = [];
                foreach ($all_fund_return as $fundId => $fundValue) {
                    $fund_returns[$fundId] = $fundValue['fund_return_absolute'];
                }
                $decile = self::decile_calc($fund_returns, $fund_details->fund_id);
                $quartile = self::quartile_calc($fund_returns, $fund_details->fund_id);
                $dataArr['NINTYDAYS']['decile'] = $decile;
                $dataArr['NINTYDAYS']['quartile'] = $quartile;

                $all_fund_return = self::all_returns_by_fund_type($fund_details->fund_type_id, date('Y-m-d', strtotime($last_date . ' - 6 months')), $last_date);
                $fund_returns = [];
                foreach ($all_fund_return as $fundId => $fundValue) {
                    $fund_returns[$fundId] = $fundValue['fund_return_absolute'];
                }
                $decile = self::decile_calc($fund_returns, $fund_details->fund_id);
                $quartile = self::quartile_calc($fund_returns, $fund_details->fund_id);
                $dataArr['SIXMONTHS']['decile'] = $decile;
                $dataArr['SIXMONTHS']['quartile'] = $quartile;

                $all_fund_return = self::all_returns_by_fund_type($fund_details->fund_type_id, date('Y-m-d', strtotime($last_date . ' - 1 year')), $last_date);
                $fund_returns = [];
                foreach ($all_fund_return as $fundId => $fundValue) {
                    $fund_returns[$fundId] = $fundValue['fund_return_absolute'];
                }
                $decile = self::decile_calc($fund_returns, $fund_details->fund_id);
                $quartile = self::quartile_calc($fund_returns, $fund_details->fund_id);
                $dataArr['ONEYEAR']['decile'] = $decile;
                $dataArr['ONEYEAR']['quartile'] = $quartile;


                $all_fund_return = self::all_returns_by_fund_type($fund_details->fund_type_id, date('Y-m-d', strtotime($last_date . ' - 2 year')), $last_date);
                $fund_returns = [];
                foreach ($all_fund_return as $fundId => $fundValue) {
                    $fund_returns[$fundId] = $fundValue['fund_return_absolute'];
                }
                $decile = self::decile_calc($fund_returns, $fund_details->fund_id);
                $quartile = self::quartile_calc($fund_returns, $fund_details->fund_id);
                $dataArr['TWOYEAR']['decile'] = $decile;
                $dataArr['TWOYEAR']['quartile'] = $quartile;

                $all_fund_return = self::all_returns_by_fund_type($fund_details->fund_type_id, date('Y-m-d', strtotime($last_date . ' - 3 year')), $last_date);
                $fund_returns = [];
                foreach ($all_fund_return as $fundId => $fundValue) {
                    $fund_returns[$fundId] = $fundValue['fund_return_absolute'];
                }
                $decile = self::decile_calc($fund_returns, $fund_details->fund_id);
                $quartile = self::quartile_calc($fund_returns, $fund_details->fund_id);
                $dataArr['THREEYEAR']['decile'] = $decile;
                $dataArr['THREEYEAR']['quartile'] = $quartile;

                $all_fund_return = self::all_returns_by_fund_type($fund_details->fund_type_id, date('Y-m-d', strtotime($last_date . ' - 5 year')), $last_date);
                $fund_returns = [];
                foreach ($all_fund_return as $fundId => $fundValue) {
                    $fund_returns[$fundId] = $fundValue['fund_return_absolute'];
                }
                $decile = self::decile_calc($fund_returns, $fund_details->fund_id);
                $quartile = self::quartile_calc($fund_returns, $fund_details->fund_id);
                $dataArr['FIVEYEAR']['decile'] = $decile;
                $dataArr['FIVEYEAR']['quartile'] = $quartile;


                // $finalArr = [];

                // $i = 0;
                // foreach ($dataArr as $key => $data) {
                //     if (count($data)) {
                //         $finalArr[$key] = $data[0];
                //     } else {
                //         $finalArr[$key] = [];
                //     }
                //     $i++;
                // }
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            $responseArr['category_compare_data'] = $dataArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

            //dd($finalArr);

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
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
    public static function all_returns_by_fund_type($fund_type_id, $start_date, $end_date)
    {
        $all_funds = FundMaster::where('fund_type_id', $fund_type_id)->get();
        $all_fund_all_return = [];
        foreach ($all_funds as $fund) {
            $individual_fund_code = $fund->fund_code;
            $individual_fund_return = self::jensenalphaApi($individual_fund_code, $start_date, $end_date);
            // array_push($all_fund_all_return, $individual_fund_return);
            $all_fund_all_return[$fund->fund_id] = $individual_fund_return;
        }
        return $all_fund_all_return;
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
        $params['selected_fund_return'] = $fund_returns[$fundID];
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
    public function fundPerformanceCompareToCategorydis(Request $request)
    {
        // echo "hi";die;
        try {
            $dataArr = $responseArr = [];
            $message = __('message');
            $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
            $fund_type_id = FundMaster::select('fund_type_id')->where('fund_code', $fund_code)->first();

            if ($fund_code && !empty($fund_type_id)) {
                //$last_date = FundDetail::getLastPublishedDate($fund_code);
                $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
                $updated_at = date('Y-m-d',strtotime($fundWatch->published_date));
                $last_date = FundDetail::select('entry_date')->where('fund_code', $fund_code)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first()->entry_date;

                // dd($last_date);
                $last_dateone1 = date('Y-m-d', strtotime($last_date . ' - 6 months'));
                // dd($last_dateone1);
                $last_dateone = date('Y-m-d', strtotime($last_dateone1 . ' -1 day'));
                $last_datetwo1 = date('Y-m-d', strtotime($last_dateone . ' - 1 year'));
                $last_datetwo = date('Y-m-d', strtotime($last_datetwo1 . ' -1 day'));



                //dd(date('Y-m-d', strtotime($last_date . ' - 6 months')),$last_date,date('Y-m-d', strtotime($last_dateone . ' - 1 year')),$last_dateone,$last_datetwo,date('Y-m-d', strtotime($last_datetwo . ' - 2 year')));

                $dataArr['SIXMONTHS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 6 months')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                // dd('CALL sp_get_cagr_quartile_decile_new("' . date('Y-m-d', strtotime($last_date . ' - 6 months')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                // return date('Y-m-d', strtotime($last_date . ' - 6 months'));die;
                $dataArr['ONEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_dateone . ' - 1 year')) . '","' . $last_dateone . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                //    dd('CALL sp_get_cagr_quartile_decile_new("' . date('Y-m-d', strtotime($last_dateone . ' - 1 year')) . '","' . $last_dateone . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                $dataArr['TWOYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_datetwo . ' - 2 year')) . '","' . $last_datetwo . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                // dd('CALL sp_get_cagr_quartile_decile_new("' . date('Y-m-d', strtotime($last_datetwo . ' - 2 year')) . '","' . $last_datetwo . '","' . $fund_code . '","' . $fund_type_id->fund_type_id . '")');
                $finalArr = [];
                foreach ($dataArr as $key => $data) {
                    if (count($data)) {
                        $finalArr[$key] = $data[0];
                    } else {
                        $finalArr[$key] = [];
                    }
                }

                $responseArr['category_compare_data'] = $finalArr;
                $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

                return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function fundPerformanceJensenalphaBetaVolatility(Request $request)
    {
        // return 'true';exit;
        // dd('api reached');
        // echo "api reached";die;
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        // dd($fund_code);
        if ($fund_code) {
            $last_date = FundDetail::getLastPublishedDate($fund_code);
            // dd($last_date);
            // return $this->sendResponse($last_date, __('api.success.api_dt_rtrv'));
            $dataArr['SEVENDAYS'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 6 days')) . '","' . $last_date . '","' . $fund_code . '")');
            // dd($dataArr['SEVENDAYS']);
            $dataArr['THIRTYDAYS'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 30 days')) . '","' . $last_date . '","' . $fund_code . '")');
            $dataArr['NINTYDAYS'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 90 days')) . '","' . $last_date . '","' . $fund_code . '")');
            $dataArr['SIXMONTHS'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 180 days')) . '","' . $last_date . '","' . $fund_code . '")');
            $dataArr['ONEYEAR'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 365 days')) . '","' . $last_date . '","' . $fund_code . '")');
            $dataArr['TWOYEAR'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 730 days')) . '","' . $last_date . '","' . $fund_code . '")');
            $dataArr['THREEYEAR'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 1095 days')) . '","' . $last_date . '","' . $fund_code . '")');
            $dataArr['FIVEYEAR'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 1825 days')) . '","' . $last_date . '","' . $fund_code . '")');
            // return $dataArr;
            $finalArr = [];
            foreach ($dataArr as $key => $data) {
                if (count($data)) {
                    // echo ($data[0]->start_date);
                    $data[0]->start_date = date('d-m-Y', strtotime($data[0]->start_date));
                    $data[0]->end_date = date('d-m-Y', strtotime($data[0]->end_date));
                    $finalArr[$key] = $data[0];
                    // echo $key.'------------'.$data[0]."<br>";
                } else {
                    $finalArr[$key] = [];
                }
            }
            // die;
            // echo "<pre>";print_r($finalArr);die;
            $responseArr['jensenalpha_beta_volatility_data'] = $finalArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function fundPerformanceJensenalphaBetaVolatilityNew(Request $request)
    {
        // return 'true';exit;
        // dd('api reached');
        // echo "api reached";die;
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        // dd($fund_code);
        if ($fund_code) {
            //$last_date_1 = FundDetail::getLastPublishedDate($fund_code);
            $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
            $updated_at = date('Y-m-d',strtotime($fundWatch->published_date));
            $last_date_1 = FundDetail::select('entry_date')->where('fund_code', $fund_code)->whereRaw(" DATE(entry_date) <= '".$updated_at."' ")->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first()->entry_date;

            $last_date_2 = date('Y-m-d', strtotime($last_date_1 . ' - 6 month'));
            $last_date_3 = date('Y-m-d', strtotime($last_date_1 . ' - 1 year'));
            $last_date_4 = date('Y-m-d', strtotime($last_date_1 . ' - 2 year'));
            // dd($last_date_1."||||".$last_date_2."||||".$last_date_3);

            $sixmonths = DB::select('CALL sp_fund_ratios("' . $last_date_2 . '","' . $last_date_1 . '","' . $fund_code . '")');
            $sixmonthsjensenalpha =  self::jensenalphaApi($fund_code, $last_date_2, $last_date_1);
            $sixmonthsjensenalpha['volatality'] = $sixmonths[0]->volatality;
            $sixmonthsjensenalpha['jensen_alpha'] = $sixmonthsjensenalpha['jensens_alpha'];
            $sixmonthsjensenalpha['start_date'] = date('d-m-Y', strtotime($sixmonths[0]->start_date));
            $sixmonthsjensenalpha['end_date'] = date('d-m-Y', strtotime($sixmonths[0]->end_date));
            $finalArr['SIXMONTHS_1'] = $sixmonthsjensenalpha;


            $sixmonths2 = DB::select('CALL sp_fund_ratios("' . $last_date_3 . '","' . $last_date_1 . '","' . $fund_code . '")');
            $sixmonthsjensenalpha2 =  self::jensenalphaApi($fund_code, $last_date_3, $last_date_1);
            $sixmonthsjensenalpha2['volatality'] = $sixmonths2[0]->volatality;
            $sixmonthsjensenalpha2['jensen_alpha'] = $sixmonthsjensenalpha2['jensens_alpha'];
            $sixmonthsjensenalpha2['start_date'] = date('d-m-Y', strtotime($sixmonths2[0]->start_date));
            $sixmonthsjensenalpha2['end_date'] = date('d-m-Y', strtotime($sixmonths2[0]->end_date));
            $finalArr['SIXMONTHS_2'] = $sixmonthsjensenalpha2;

            $sixmonths3 = DB::select('CALL sp_fund_ratios("' . $last_date_4 . '","' . $last_date_1 . '","' . $fund_code . '")');
            $sixmonthsjensenalpha3 =  self::jensenalphaApi($fund_code, $last_date_4, $last_date_1);
            $sixmonthsjensenalpha3['volatality'] = $sixmonths3[0]->volatality;
            $sixmonthsjensenalpha3['jensen_alpha'] = $sixmonthsjensenalpha3['jensens_alpha'];
            $sixmonthsjensenalpha3['start_date'] = date('d-m-Y', strtotime($sixmonths3[0]->start_date));
            $sixmonthsjensenalpha3['end_date'] = date('d-m-Y', strtotime($sixmonths3[0]->end_date));
            $finalArr['SIXMONTHS_3'] = $sixmonthsjensenalpha3;



            //dd($finalArr);

            /*$dataArr['SIXMONTHS_1'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . $last_date_2 . '","' . $last_date_1 . '","' . $fund_code . '")');
            // dd($dataArr['SIXMONTHS_1']);
            $dataArr['SIXMONTHS_2'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . $last_date_3 . '","' . $last_date_2 . '","' . $fund_code . '")');
            $dataArr['SIXMONTHS_3'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date_1 . ' - 547 days')) . '","' . date('Y-m-d', strtotime($last_date_1 . ' - 366 days')) . '","' . $fund_code . '")');
            // dd('CALL sp_fund_jensenalpha_beta_volatility("'.date('Y-m-d', strtotime($last_date_1. ' - 547 days')).'","'.date('Y-m-d', strtotime($last_date_1. ' - 366 days')).'","'.$fund_code.'")');
            // return $dataArr;
            $finalArr = [];
            foreach ($dataArr as $key => $data) {
                if (count($data)) {
                    // echo ($data[0]->start_date);
                    $data[0]->start_date = date('d-m-Y', strtotime($data[0]->start_date));
                    $data[0]->end_date = date('d-m-Y', strtotime($data[0]->end_date));
                    $finalArr[$key] = $data[0];
                    // echo $key.'------------'.$data[0]."<br>";
                } else {
                    $finalArr[$key] = [];
                }
            }*/
            // die;
            // echo "<pre>";print_r($finalArr);die;
            $responseArr['jensenalpha_beta_volatility_data'] = $finalArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date_1));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }


    



    public function fundPerformanceJensenalphaBetaVolatilityoneYeartwoYear(Request $request)
    {
        // return 'true';exit;
        // dd('api reached');
        // echo "api reached";die;
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        // dd($fund_code);
        if ($fund_code) {
            $last_date = FundDetail::getLastPublishedDate($fund_code);
            // dd($last_date);
            // return $this->sendResponse($last_date, __('api.success.api_dt_rtrv'));
            // $dataArr['SEVENDAYS'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("'.date('Y-m-d', strtotime($last_date. ' - 6 days')).'","'.$last_date.'","'.$fund_code.'")');
            // // dd($dataArr['SEVENDAYS']);
            // $dataArr['THIRTYDAYS'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("'.date('Y-m-d', strtotime($last_date. ' - 30 days')).'","'.$last_date.'","'.$fund_code.'")');
            // $dataArr['NINTYDAYS'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("'.date('Y-m-d', strtotime($last_date. ' - 90 days')).'","'.$last_date.'","'.$fund_code.'")');
            // $dataArr['SIXMONTHS'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("'.date('Y-m-d', strtotime($last_date. ' - 180 days')).'","'.$last_date.'","'.$fund_code.'")');
            $dataArr['ONEYEAR'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 366 days')) . '","' . $last_date . '","' . $fund_code . '")');
            // dd($dataArr['ONEYEAR']);
            $dataArr['TWOYEAR'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("' . date('Y-m-d', strtotime($last_date . ' - 731 days')) . '","' . $last_date . '","' . $fund_code . '")');
            // dd($dataArr['TWOYEAR']);
            // $dataArr['THREEYEAR'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("'.date('Y-m-d', strtotime($last_date. ' - 1095 days')).'","'.$last_date.'","'.$fund_code.'")');
            // $dataArr['FIVEYEAR'] = DB::select('CALL sp_fund_jensenalpha_beta_volatility("'.date('Y-m-d', strtotime($last_date. ' - 1825 days')).'","'.$last_date.'","'.$fund_code.'")');
            // return $dataArr;
            $finalArr = [];
            foreach ($dataArr as $key => $data) {
                if (count($data)) {
                    // echo ($data[0]->start_date);
                    $data[0]->start_date = date('d-m-Y', strtotime($data[0]->start_date));
                    $data[0]->end_date = date('d-m-Y', strtotime($data[0]->end_date));
                    $finalArr[$key] = $data[0];
                    // echo $key.'------------'.$data[0]."<br>";
                } else {
                    $finalArr[$key] = [];
                }
            }
            // die;
            // echo "<pre>";print_r($finalArr);die;
            $responseArr['jensenalpha_beta_volatility_data'] = $finalArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function fundPerformanceSchemeSIP(Request $request)
    {
        // dd('fundPerformanceSchemeSIP');
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        $fund_type_id = FundMaster::select('fund_type_id')->where('fund_code', $fund_code)->first();
        $fund_opening_details = fundDetail::select('entry_date')->where('fund_code', $fund_code)->first();

        if ($fund_code && !empty($fund_type_id)) {
            $last_date = FundDetail::getLastPublishedDate($fund_code);
            // $one_month_before = Carbon::parse($last_date)->subMonth()->toDateString();
            $backdates = [
                'ONEMONTH' => Carbon::parse($last_date)->subMonth()->toDateString(),
                'THREEMONTHS' => Carbon::parse($last_date)->subMonths(3)->toDateString(),
                'SIXMONTHS' => Carbon::parse($last_date)->subMonths(6)->toDateString(),
                'ONEYEAR' => Carbon::parse($last_date)->subYear()->toDateString(),
                'TWOYEAR' => Carbon::parse($last_date)->subYears(2)->toDateString(),
                'THREEYEAR' => Carbon::parse($last_date)->subYears(3)->toDateString(),
                'FIVEYEAR' => Carbon::parse($last_date)->subYears(5)->toDateString(),
            ];
            // dd($backdates['ONEMONTH']);
            // dd($fund_opening_date);
            $fund_opening_date = Carbon::createFromFormat('Y-m-d', $fund_opening_details->entry_date)->toDateString();
            // dd($fund_opening_date);
            if ($fund_opening_date < $backdates['ONEMONTH']) {
                // dd('One month data Found');
                $dataArr['ONEMONTH'] = DB::select('CALL sp_SIP_calc(1,"' . $fund_code . '",1000)');
                // dd($dataArr['ONEMONTH']);
            } else {
                $dataArr['ONEMONTH'] = [];
            }

            if ($fund_opening_date < $backdates['THREEMONTHS']) {
                // dd('One month data Found');
                $dataArr['THREEMONTHS'] = DB::select('CALL sp_SIP_calc(3,"' . $fund_code . '",1000)');
                // dd($dataArr['ONEMONTH']);
            } else {
                $dataArr['THREEMONTHS'] = [];
            }

            if ($fund_opening_date < $backdates['SIXMONTHS']) {
                // dd('One month data Found');
                $dataArr['SIXMONTHS'] = DB::select('CALL sp_SIP_calc(6,"' . $fund_code . '",1000)');
                // dd($dataArr['ONEMONTH']);
            } else {
                $dataArr['SIXMONTHS'] = [];
            }

            if ($fund_opening_date < $backdates['ONEYEAR']) {
                // dd('One month data Found');
                $dataArr['ONEYEAR'] = DB::select('CALL sp_SIP_calc(12,"' . $fund_code . '",1000)');
                // dd($dataArr['ONEMONTH']);
            } else {
                $dataArr['ONEYEAR'] = [];
            }

            if ($fund_opening_date < $backdates['TWOYEAR']) {
                // dd('One month data Found');
                $dataArr['TWOYEAR'] = DB::select('CALL sp_SIP_calc(24,"' . $fund_code . '",1000)');
                // dd($dataArr['ONEMONTH']);
            } else {
                $dataArr['TWOYEAR'] = [];
            }

            if ($fund_opening_date < $backdates['THREEYEAR']) {
                // dd('One month data Found');
                $dataArr['THREEYEAR'] = DB::select('CALL sp_SIP_calc(36,"' . $fund_code . '",1000)');
                // dd($dataArr['ONEMONTH']);
            } else {
                $dataArr['THREEYEAR'] = [];
            }

            if ($fund_opening_date < $backdates['FIVEYEAR']) {
                // dd('One month data Found');
                $dataArr['FIVEYEAR'] = DB::select('CALL sp_SIP_calc(60,"' . $fund_code . '",1000)');
                // dd($dataArr['ONEMONTH']);
            } else {
                $dataArr['FIVEYEAR'] = [];
            }

            // dd($dataArr['ONEMONTH']);
            // return $dataArr['ONEMONTH'];
            $finalArr = [];
            foreach ($dataArr as $key => $data) {
                if (count($data)) {
                    $finalArr[$key] = $data[0];
                } else {
                    $finalArr[$key] = [];
                }
            }

            // return $dataArr;

            $responseArr['scheme_sip_data'] = $finalArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function fundPerformanceBenchmarkSIP(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        $indices_name = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();

        if ($fund_code && !empty($indices_name)) {
            $last_date = IndicesDetail::getLastPublishedDate($indices_name->indices_name);

            $dataArr['SIXMONTHS'] = DB::select('CALL sp_SIP_calc_ben(6,"' . $indices_name->indices_name . '",1000)');
            $dataArr['ONEYEAR'] = DB::select('CALL sp_SIP_calc_ben(12,"' . $indices_name->indices_name . '",1000)');
            $dataArr['TWOYEAR'] = DB::select('CALL sp_SIP_calc_ben(24,"' . $indices_name->indices_name . '",1000)');
            $dataArr['THREEYEAR'] = DB::select('CALL sp_SIP_calc_ben(36,"' . $indices_name->indices_name . '",1000)');
            $dataArr['FIVEYEAR'] = DB::select('CALL sp_SIP_calc_ben(60,"' . $indices_name->indices_name . '",1000)');

            $finalArr = [];
            foreach ($dataArr as $key => $data) {
                if (count($data)) {
                    $finalArr[$key] = $data[0];
                } else {
                    $finalArr[$key] = [];
                }
            }

            $responseArr['benchmark_sip_data'] = $finalArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function fundPerformanceSchemeHighLow(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';

        if ($fund_code) {
            $last_date = FundDetail::getLastPublishedDate($fund_code);

            $dataArr['SEVENDAYS'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",7)');
            $dataArr['THIRTYDAYS'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",30)');
            $dataArr['NINTYDAYS'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",90)');
            $dataArr['SIXMONTHS'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",180)');
            $dataArr['ONEYEAR'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",365)');
            $dataArr['TWOYEAR'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",730)');
            $dataArr['THREEYEAR'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",1095)');
            $dataArr['FIVEYEAR'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",1825)');

            $finalArr = [];
            foreach ($dataArr as $key => $data) {
                if (count($data)) {
                    $finalArr[$key] = $data[0];
                } else {
                    $finalArr[$key] = [];
                }
            }

            $responseArr['scheme_high_low_data'] = $finalArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function fundPerformanceBenchmarkHighLow(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        $indices_name = FundMaster::select('indices_name')->where('fund_code', $fund_code)->first();

        if ($fund_code && !empty($indices_name)) {
            $last_date = IndicesDetail::getLastPublishedDate($indices_name->indices_name);

            //old method
            // $dataArr['SEVENDAYS'] = DB::select('CALL sp_fund_search_ben_high_low("'.$last_date.'","'.$indices_name->indices_name.'",7)');
            // $dataArr['THIRTYDAYS'] = DB::select('CALL sp_fund_search_ben_high_low("'.$last_date.'","'.$indices_name->indices_name.'",30)');
            // $dataArr['NINTYDAYS'] = DB::select('CALL sp_fund_search_ben_high_low("'.$last_date.'","'.$indices_name->indices_name.'",90)');
            // $dataArr['SIXMONTHS'] = DB::select('CALL sp_fund_search_ben_high_low("'.$last_date.'","'.$indices_name->indices_name.'",180)');
            // $dataArr['ONEYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("'.$last_date.'","'.$indices_name->indices_name.'",365)');
            // $dataArr['TWOYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("'.$last_date.'","'.$indices_name->indices_name.'",730)');
            // $dataArr['THREEYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("'.$last_date.'","'.$indices_name->indices_name.'",1095)');
            // $dataArr['FIVEYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("'.$last_date.'","'.$indices_name->indices_name.'",1825)');

            //new method
            $dataArr['SEVENDAYS'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indices_name->indices_name . '",6)');
            $dataArr['THIRTYDAYS'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indices_name->indices_name . '",30)');
            $dataArr['NINTYDAYS'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indices_name->indices_name . '",90)');
            $dataArr['SIXMONTHS'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indices_name->indices_name . '",182)');
            $dataArr['ONEYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indices_name->indices_name . '",366)');
            $dataArr['TWOYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indices_name->indices_name . '",731)');
            $dataArr['THREEYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indices_name->indices_name . '",1096)');
            $dataArr['FIVEYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indices_name->indices_name . '",1827)');

            $finalArr = [];
            foreach ($dataArr as $key => $data) {
                if (count($data)) {
                    $finalArr[$key] = $data[0];
                } else {
                    $finalArr[$key] = [];
                }
            }

            $responseArr['benchmark_high_low_data'] = $finalArr;
            $responseArr['to_date'] = date('d/m/Y', strtotime($last_date));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getFundIndexCurrency(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';

        if ($fund_code) {
            $days = (isset($request->days) && $request->days) ? $request->days : 365;
            $end_date = FundDetail::getLastPublishedDate($fund_code);
            $start_date = Carbon::parse($end_date)->subDays($days)->format('Y-m-d');

            $dataArr = DB::select('CALL sp_fund_index_currency("GRAPH_FUND","' . $start_date . '","' . $end_date . '",0,"' . $fund_code . '","","",0)');
            $responseArr['nav_data'] = $dataArr;
            $responseArr['from_date'] = date('d/m/Y', strtotime($start_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($end_date));

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getFundPerformanceAAUM(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';

        if ($fund_code) {
            $days = (isset($request->days) && $request->days) ? $request->days : 365;
            $end_date = FundDetail::getLastPublishedDate($fund_code);
            $start_date = Carbon::parse($end_date)->subDays($days)->format('Y-m-d');

            $last_aaum = DB::select("SELECT DATE_FORMAT(entry_date, '%d-%m-%Y') AS entry_date , corpus_entry FROM mpx_corpus_entry WHERE entry_date = (SELECT entry_date from mpx_corpus_entry WHERE fund_code = '" . $fund_code . "' AND publish = 'y' ORDER BY entry_date DESC LIMIT 1) AND fund_code = '" . $fund_code . "'");
            $dataArr['last_aaum'] = count($last_aaum) ? $last_aaum[0] : [];
            $f_aaum = DB::select("SELECT DATE_FORMAT(entry_date, '%d-%m-%Y') AS entry_date , corpus_entry FROM mpx_corpus_entry WHERE entry_date = (DATE_SUB((SELECT entry_date from mpx_corpus_entry WHERE fund_code = '" . $fund_code . "' AND publish = 'y' ORDER BY entry_date DESC LIMIT 1), INTERVAL 3 MONTH)) AND fund_code = '" . $fund_code . "'");
            $dataArr['f_aaum'] = count($f_aaum) ? $f_aaum[0] : [];
            $s_aaum = DB::select("SELECT DATE_FORMAT(entry_date, '%d-%m-%Y') AS entry_date , corpus_entry FROM mpx_corpus_entry WHERE entry_date = (DATE_SUB((SELECT entry_date from mpx_corpus_entry WHERE fund_code = '" . $fund_code . "' AND publish = 'y' ORDER BY entry_date DESC LIMIT 1), INTERVAL 6 MONTH)) AND fund_code = '" . $fund_code . "'");
            $dataArr['s_aaum'] = count($s_aaum) ? $s_aaum[0] : [];
            $t_aaum = DB::select("SELECT DATE_FORMAT(entry_date, '%d-%m-%Y') AS entry_date , corpus_entry FROM mpx_corpus_entry WHERE entry_date = (DATE_SUB((SELECT entry_date from mpx_corpus_entry WHERE fund_code = '" . $fund_code . "' AND publish = 'y' ORDER BY entry_date DESC LIMIT 1), INTERVAL 9 MONTH)) AND fund_code = '" . $fund_code . "'");
            $dataArr['t_aaum'] = count($t_aaum) ? $t_aaum[0] : [];

            $responseArr['aaum_data'] = $dataArr;

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getFundPortfolioDetails(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';

        if ($fund_code) {
            $dataArr = DB::select('CALL sp_fund_search_portfolio("' . $fund_code . '")');

            $responseArr['portfolio_data'] = count($dataArr) ? $dataArr[0] : [];

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getFundPortfolioTopScripts(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        $top_rows = (isset($request->top_rows) && $request->top_rows) ? $request->top_rows : 10;
        $month = (isset($request->month) && $request->month) ? $request->month : 0;
        $year = (isset($request->year) && $request->year) ? $request->year : 0;

        if ($fund_code) {
            $dataArr = DB::select('CALL sp_fund_search_portfolio_top_script("' . $month . '","' . $year . '","' . $fund_code . '",' . $top_rows . ')');

            $responseArr['portfolio_top_scripts'] = $dataArr;
            $responseArr['portfolio_top_scripts_sum'] = count($dataArr) ? collect($dataArr)->sum('content_per') : 'NA';

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getFundPortfolioTopIndustries(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $fund_code = (isset($request->fund_code) && $request->fund_code) ? $request->fund_code : '';
        $top_rows = (isset($request->top_rows) && $request->top_rows) ? $request->top_rows : 10;

        $month = (isset($request->month) && $request->month) ? $request->month : 0;
        $year = (isset($request->year) && $request->year) ? $request->year : 0;


        if ($fund_code) {
            $dataArr = DB::select('CALL sp_fund_search_portfolio_top_industry("' . $month . '","' . $year . '","' . $fund_code . '",' . $top_rows . ')');

            $responseArr['portfolio_top_industries'] = count($dataArr) ? collect($dataArr)->take($top_rows) : [];
            $responseArr['portfolio_top_industries_sum'] = count($dataArr) ? round(collect($dataArr)->sum('industry_content_per')) : 'NA';

            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getComparePrice(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $compare_type = (isset($request->compare_type) && $request->compare_type) ? $request->compare_type : '';
        $value1 = (isset($request->value1) && $request->value1) ? urldecode($request->value1) : '';
        $value2 = (isset($request->value2) && $request->value2) ? urldecode($request->value2) : '';
        $from_date = (isset($request->from_date) && $request->from_date) ? $request->from_date : '';
        $to_date = (isset($request->to_date) && $request->to_date) ? $request->to_date : '';
        $typeArr = explode("_", $compare_type);

        if (count($typeArr) == 2 && $value1 && $value2 && $from_date && $to_date) {
            $type1_first_date = '';
            $type2_first_date = '';
            if ($typeArr[0] == 'scheme') {
                $type1_first_date = FundDetail::getFirstPublishedDate($value1);
            }
            if ($typeArr[0] == 'index') {
                $type1_first_date = IndicesDetail::getFirstPublishedDate($value1);
            }
            if ($typeArr[0] == 'currency') {
                $type1_first_date = CurrencyDetail::getFirstPublishedDate($value1);
            }
            if ($typeArr[1] == 'scheme') {
                $type2_first_date = FundDetail::getFirstPublishedDate($value2);
            }
            if ($typeArr[1] == 'index') {
                $type2_first_date = IndicesDetail::getFirstPublishedDate($value2);
            }
            if ($typeArr[1] == 'currency') {
                $type2_first_date = CurrencyDetail::getFirstPublishedDate($value2);
            }
            $notice_text = '';
            $notice_value_type = '';

            if ($type1_first_date && $type2_first_date) {
                $dateTimestampFrom = strtotime($from_date);
                $dateTimestampType1 = strtotime($type1_first_date);
                $dateTimestampType2 = strtotime($type2_first_date);

                if ($dateTimestampFrom < $dateTimestampType1) {
                    $from_date = $type1_first_date;
                    $notice_text = 'data available from ' . date('d/m/Y', $dateTimestampType1);
                    $notice_value_type = '1';
                }
                if ($dateTimestampFrom < $dateTimestampType2) {
                    $from_date = $type2_first_date;
                    $notice_text = 'data available from ' . date('d/m/Y', $dateTimestampType2);
                    $notice_value_type = '2';
                }
            }
            $graphArr = [];

            if ($typeArr[0] == 'scheme') {
                $type1 = 'GRAPH_FUND';
            }
            if ($typeArr[0] == 'index') {
                $type1 = 'GRAPH_INDEX';
            }
            if ($typeArr[0] == 'currency') {
                $type1 = 'GRAPH_CURRENCY';
            }
            if ($typeArr[1] == 'scheme') {
                $type2 = 'GRAPH_FUND';
            }
            if ($typeArr[1] == 'index') {
                $type2 = 'GRAPH_INDEX';
            }
            if ($typeArr[1] == 'currency') {
                $type2 = 'GRAPH_CURRENCY';
            }
            $graphArr[0] = DB::select('CALL sp_fund_index_currency("' . $type1 . '","' . $from_date . '","' . $to_date . '",0,"' . $value1 . '","","",0)');
            $graphArr[1] = DB::select('CALL sp_fund_index_currency("' . $type2 . '","' . $from_date . '","' . $to_date . '",0,"' . $value2 . '","","",0)');
            $responseArr['graph_data'] = $graphArr;
            $responseArr['from_date'] = $from_date;
            $responseArr['to_date'] = $to_date;
            $responseArr['notice_text'] = $notice_text;
            $responseArr['notice_value_type'] = $notice_value_type;
            $responseArr['notice_value_type_text'] = $value1;
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getCompareRatios(Request $request)
    {
        \Log::debug('calling sp_fund_ratios');
        $dataArr = $responseArr = [];
        $message = __('message');

        $compare_type = (isset($request->compare_type) && $request->compare_type) ? $request->compare_type : '';
        $value1 = (isset($request->value1) && $request->value1) ? urldecode($request->value1) : '';
        $value2 = (isset($request->value2) && $request->value2) ? urldecode($request->value2) : '';
        $value3 = (isset($request->value3) && $request->value3) ? urldecode($request->value3) : '';
        $value4 = (isset($request->value4) && $request->value4) ? urldecode($request->value4) : '';
        $value5 = (isset($request->value5) && $request->value5) ? urldecode($request->value5) : '';
        $from_date = (isset($request->from_date) && $request->from_date) ? $request->from_date : '';
        $to_date = (isset($request->to_date) && $request->to_date) ? $request->to_date : '';


        if ($compare_type && $value1 && $value2 && $from_date && $to_date) {
            $type1_first_date = '';
            $type2_first_date = '';

            $type1_first_date = FundDetail::getFirstPublishedDate($value1);

            $type2_first_date = FundDetail::getFirstPublishedDate($value2);

            $notice_text = '';
            $notice_value_type = '';

            if ($type1_first_date && $type2_first_date) {
                $dateTimestampFrom = strtotime($from_date);
                $dateTimestampType1 = strtotime($type1_first_date);
                $dateTimestampType2 = strtotime($type2_first_date);

                if ($dateTimestampFrom < $dateTimestampType1) {
                    $from_date = $type1_first_date;
                    $notice_text = 'data available from ' . date('d/m/Y', $dateTimestampType1);
                    $notice_value_type = '1';
                }
                if ($dateTimestampFrom < $dateTimestampType2) {
                    $from_date = $type2_first_date;
                    $notice_text = 'data available from ' . date('d/m/Y', $dateTimestampType2);
                    $notice_value_type = '2';
                }
            }
            $graphArr = [];
            if ($compare_type != 'rolling_return') {
                if ($compare_type == 'jensens_alpha' || $compare_type == 'beta' || $compare_type == 'cagr') {
                    $graph1 =  self::jensenalphaApi($value1, $from_date, $to_date);
                    if (count($graph1)) {
                        $graph1['fund_code'] =  count($graph1) ? $graph1['search_fund_name'] : '';
                        $graph1['cagr'] =  count($graph1) ? $graph1['fund_return_absolute'] : '';
                        $graphArr[0] = count($graph1) ? $graph1 : [];
                    }


                    $graph2 = self::jensenalphaApi($value2, $from_date, $to_date);
                    if (count($graph2)) {
                        $graph2['fund_code'] =  count($graph2) ? $graph2['search_fund_name'] : '';
                        $graph2['cagr'] =  count($graph2) ? $graph2['fund_return_absolute'] : '';
                        $graphArr[1] = count($graph2) ? $graph2 : [];
                    }

                    if (!empty($value3)) {
                        $graph3 = self::jensenalphaApi($value3, $from_date, $to_date);
                        $graph3['fund_code'] =  count($graph3) ? $graph3['search_fund_name'] : '';
                        $graph3['cagr'] =  count($graph3) ? $graph3['fund_return_absolute'] : '';
                        $graphArr[2] = count($graph3) ? $graph3 : [];
                    }

                    if (!empty($value4)) {
                        $graph4 = self::jensenalphaApi($value4, $from_date, $to_date);
                        $graph4['fund_code'] =  count($graph4) ? $graph4['search_fund_name'] : '';
                        $graph4['cagr'] =  count($graph4) ? $graph4['fund_return_absolute'] : '';
                        $graphArr[3] = count($graph4) ? $graph4 : [];
                    }

                    if (!empty($value5)) {
                        $graph5  = self::jensenalphaApi($value5, $from_date, $to_date);
                        $graph5['fund_code'] =  count($graph5) ? $graph5['search_fund_name'] : '';
                        $graph5['cagr'] =  count($graph5) ? $graph5['fund_return_absolute'] : '';
                        $graphArr[4] = count($graph5) ? $graph5 : [];
                    }
                } else if ($compare_type == 'information_ratio') {
                    $graph1 =  self::informationRatioApi($value1, $from_date, $to_date);
                    if (count($graph1)) {
                        $graph1['fund_code'] =  count($graph1) ? $graph1['search_fund_name'] : '';
                        $graphArr[0] = count($graph1) ? $graph1 : [];
                    }

                    $graph2 = self::informationRatioApi($value2, $from_date, $to_date);
                    if (count($graph2)) {
                        $graph2['fund_code'] =  count($graph2) ? $graph2['search_fund_name'] : '';
                        $graphArr[1] = count($graph2) ? $graph2 : [];
                    }

                    if (!empty($value3)) {
                        $graph3 = self::informationRatioApi($value3, $from_date, $to_date);
                        $graph3['fund_code'] =  count($graph3) ? $graph3['search_fund_name'] : '';
                        $graphArr[2] = count($graph3) ? $graph3 : [];
                    }

                    if (!empty($value4)) {
                        $graph4 = self::informationRatioApi($value4, $from_date, $to_date);
                        $graph4['fund_code'] =  count($graph4) ? $graph4['search_fund_name'] : '';
                        $graphArr[3] = count($graph4) ? $graph4 : [];
                    }

                    if (!empty($value5)) {
                        $graph5  = self::informationRatioApi($value5, $from_date, $to_date);
                        $graph5['fund_code'] =  count($graph5) ? $graph5['search_fund_name'] : '';
                        $graphArr[4] = count($graph5) ? $graph5 : [];
                    }
                } else {
                    $graph1 = DB::select('CALL sp_fund_ratios("' . $from_date . '","' . $to_date . '","' . $value1 . '")');
                    $graphArr[0] = count($graph1) ? $graph1[0] : [];
                    $graph2 = DB::select('CALL sp_fund_ratios("' . $from_date . '","' . $to_date . '","' . $value2 . '")');
                    $graphArr[1] = count($graph2) ? $graph2[0] : [];
                    if (!empty($value3)) {
                        $graph3 = DB::select('CALL sp_fund_ratios("' . $from_date . '","' . $to_date . '","' . $value3 . '")');
                        $graphArr[2] = count($graph3) ? $graph3[0] : [];
                    }
                    if (!empty($value4)) {
                        $graph4 = DB::select('CALL sp_fund_ratios("' . $from_date . '","' . $to_date . '","' . $value4 . '")');
                        $graphArr[3] = count($graph4) ? $graph4[0] : [];
                    }

                    if (!empty($value5)) {
                        $graph5 = DB::select('CALL sp_fund_ratios("' . $from_date . '","' . $to_date . '","' . $value5 . '")');
                        $graphArr[4] = count($graph5) ? $graph5[0] : [];
                    }
                }
            } else {
                $graph1 = DB::select('CALL sp_rolling_return("' . $from_date . '","' . $to_date . '","' . $value1 . '")');
                $oneMonthRollingReturnApi1 = self::oneMonthRollingReturnApi($value1, $from_date, $to_date);
                $graphArr[0] = count($graph1) ? $graph1[0] : [];
                $graphArr[0]->rolling_return =  count($graph1) ? $oneMonthRollingReturnApi1['one_month_interval_percentage_change'] : '';


                $graph2 = DB::select('CALL sp_rolling_return("' . $from_date . '","' . $to_date . '","' . $value2 . '")');
                $oneMonthRollingReturnApi2 = self::oneMonthRollingReturnApi($value2, $from_date, $to_date);
                $graphArr[1] = count($graph2) ? $graph2[0] : [];
                $graphArr[1]->rolling_return =  count($graph2) ? $oneMonthRollingReturnApi2['one_month_interval_percentage_change'] : '';

                if (!empty($value3)) {
                    $graph3 = DB::select('CALL sp_rolling_return("' . $from_date . '","' . $to_date . '","' . $value3 . '")');
                    $oneMonthRollingReturnApi3 = self::oneMonthRollingReturnApi($value3, $from_date, $to_date);
                    $graphArr[2] = count($graph3) ? $graph3[0] : [];
                    $graphArr[2]->rolling_return =  count($graph3) ? $oneMonthRollingReturnApi3['one_month_interval_percentage_change'] : '';
                }

                if (!empty($value4)) {
                    $graph4 = DB::select('CALL sp_rolling_return("' . $from_date . '","' . $to_date . '","' . $value4 . '")');
                    $oneMonthRollingReturnApi4 = self::oneMonthRollingReturnApi($value4, $from_date, $to_date);
                    $graphArr[3] = count($graph4) ? $graph4[0] : [];
                    $graphArr[3]->rolling_return =  count($graph4) ? $oneMonthRollingReturnApi4['one_month_interval_percentage_change'] : '';
                }

                if (!empty($value5)) {
                    $graph5 = DB::select('CALL sp_rolling_return("' . $from_date . '","' . $to_date . '","' . $value5 . '")');
                    $oneMonthRollingReturnApi5 = self::oneMonthRollingReturnApi($value5, $from_date, $to_date);
                    $graphArr[4] = count($graph5) ? $graph5[0] : [];
                    $graphArr[4]->rolling_return =  count($graph5) ? $oneMonthRollingReturnApi5['one_month_interval_percentage_change'] : '';
                }
            }

            $responseArr['graph_data'] = $graphArr;

            $responseArr['notice_text'] = $notice_text;
            $responseArr['notice_value_type'] = $notice_value_type;
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getCompareComposition(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $compare_type = (isset($request->compare_type) && $request->compare_type) ? $request->compare_type : '';
        $value1 = (isset($request->value1) && $request->value1) ? urldecode($request->value1) : '';
        $value2 = (isset($request->value2) && $request->value2) ? urldecode($request->value2) : '';
        $value3 = (isset($request->value3) && $request->value3) ? urldecode($request->value3) : '';
        $value4 = (isset($request->value4) && $request->value4) ? urldecode($request->value4) : '';
        $value5 = (isset($request->value5) && $request->value5) ? urldecode($request->value5) : '';

        $compare1 = (isset($request->compare1) && $request->compare1) ? urldecode($request->compare1) : '';
        $compare2 = (isset($request->compare2) && $request->compare2) ? urldecode($request->compare2) : '';
        $compare3 = (isset($request->compare3) && $request->compare3) ? urldecode($request->compare3) : '';
        $compare4 = (isset($request->compare4) && $request->compare4) ? urldecode($request->compare4) : '';
        $compare5 = (isset($request->compare5) && $request->compare5) ? urldecode($request->compare5) : '';

        if (!empty($compare1)) {
            $value1_typeArr = explode('_', $compare1);
            //dd($value1_typeArr);
            $value1_type = $value1_typeArr[0];
            $value2_type = $value1_typeArr[1];
        }
        if (!empty($compare2)) {
            $value2_typeArr = explode('_', $compare2);
            $value3_type = $value2_typeArr[1];
        }
        if (!empty($compare3)) {
            $value3_typeArr = explode('_', $compare3);
            $value4_type = $value3_typeArr[1];
        }
        if (!empty($compare4)) {
            $value4_typeArr = explode('_', $compare4);
            $value5_type = $value4_typeArr[1];
        }

        $month = (isset($request->month) && $request->month) ? $request->month : '';
        $year = (isset($request->year) && $request->year) ? $request->year : '';


        if ($compare_type && $value1 && $value2 && $month && $year) {
            $type1_first_date = '';
            $type2_first_date = '';
            if ($compare_type == 'aaum') {
                $type1_first_date = CorpusEntry::getFirstPublishedDate($value1);
                $type2_first_date = CorpusEntry::getFirstPublishedDate($value2);
                $type3_first_date = CorpusEntry::getFirstPublishedDate($value3);
                $type4_first_date = CorpusEntry::getFirstPublishedDate($value4);
                $type5_first_date = CorpusEntry::getFirstPublishedDate($value5);
            } else {
                $type1_first_date = FundComposition::getFirstPublishedDate($value1);
                $type2_first_date = FundComposition::getFirstPublishedDate($value2);
                $type3_first_date = FundComposition::getFirstPublishedDate($value3);
                $type4_first_date = FundComposition::getFirstPublishedDate($value4);
                $type5_first_date = FundComposition::getFirstPublishedDate($value5);
            }

            $responseArr['compare1'] = $request->compare1;
            $notice_text = '';
            $notice_value_type = '';

            if ($type1_first_date && $type2_first_date) {
                $fdate = strtotime($year . '-' . $month . '-1');
                $from_date = date("Y-m-t", $fdate);
                $dateTimestampFrom = strtotime($from_date);
                $dateTimestampType1 = strtotime($type1_first_date);
                $dateTimestampType2 = strtotime($type2_first_date);
                $dateTimestampType3 = strtotime($type3_first_date);
                $dateTimestampType4 = strtotime($type4_first_date);
                $dateTimestampType5 = strtotime($type5_first_date);

                if ($dateTimestampFrom < $dateTimestampType1) {
                    $from_date = $type1_first_date;
                    $notice_text = 'data available from ' . date('d/m/Y', $dateTimestampType1);
                    $notice_value_type = '1';
                }
                if ($dateTimestampFrom < $dateTimestampType2) {
                    $from_date = $type2_first_date;
                    $notice_text = 'data available from ' . date('d/m/Y', $dateTimestampType2);
                    $notice_value_type = '2';
                }
                if ($dateTimestampFrom < $dateTimestampType3) {
                    $from_date = $type3_first_date;
                    $notice_text = 'data available from ' . date('d/m/Y', $dateTimestampType3);
                    $notice_value_type = '3';
                }
                if ($dateTimestampFrom < $dateTimestampType4) {
                    $from_date = $type4_first_date;
                    $notice_text = 'data available from ' . date('d/m/Y', $dateTimestampType4);
                    $notice_value_type = '4';
                }
                if ($dateTimestampFrom < $dateTimestampType5) {
                    $from_date = $type5_first_date;
                    $notice_text = 'data available from ' . date('d/m/Y', $dateTimestampType5);
                    $notice_value_type = '5';
                }
            } else {
                //return $this->sendError($message['data_not_available'], '');
            }
            $indiceCompositionLastDate = IndicesComposition::where('publish', 'y')->orderBy('entry_date', 'DESC')->first()->entry_date;
            $corpusEntryLastDate = CorpusEntry::where('publish', 'y')->orderBy('entry_date', 'DESC')->first()->entry_date;

            $responseArr['indiceCompositionLastDate'] = $indiceCompositionLastDate;
            $responseArr['corpusEntryLastDate'] = $corpusEntryLastDate;

            $compare_type_new = ($compare_type != 'top_script')?$compare_type:'top_scrip';

            $responseArr['info_box'] = 'Compare : '. ucwords(str_replace('_',' ',$compare_type_new)) .' || Month : '.date('F Y',strtotime($corpusEntryLastDate));


            $graphArr = [];
            if ($compare_type == 'top_script') {

                if ($value1_type == 'scheme') {
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value1)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;

                    $graph1 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value1)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'scrip_name',
                            'industry',
                            'corpus_entry_date',
                            'composition_entry_date',
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
                        )
                        ->orderBy('content_per', 'desc')
                        ->groupBy('scrip_name')
                        ->limit(10)
                        ->get()->toArray();

                    //dd($graph1);

                    //$graph1 = DB::select('CALL sp_fund_search_portfolio_top_script("' . date("m", strtotime($corpusEntryLastDate)) . '","' . date("Y", strtotime($corpusEntryLastDate)) . '","' . $value1 . '",10)');
                    //dd($graph1);
                    if (empty($graph1)) {
                        $year = date("Y", strtotime($corpusEntryLastDate));
                        $month = date("m", strtotime($corpusEntryLastDate));
                        $fdate = ($year . '-' . $month . '-1');
                        $from_date = date("Y-m-d", strtotime($fdate . ' -1 month'));
                        $corpusEntryLastDate = date("Y-m-t", strtotime($from_date));
                        //dd($from_date);
                        $graph1 =
                            DB::table('view_corpus_with_allocation')
                            ->where('fund_code', $value1)
                            ->where('corpus_entry_date', $corpusEntryLastDate)
                            ->where('composition_entry_date', $corpusEntryLastDate)
                            ->where('category', 'Equity')
                            ->select(
                                'scrip_name',
                                'industry',
                                'corpus_entry_date',
                                'composition_entry_date',
                                DB::raw('SUM(calculated_amount/100) as amount'),
                                DB::raw($total_corpus_entry . ' as AUM'),
                                DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
                            )
                            ->orderBy('content_per', 'desc')
                            ->groupBy('scrip_name')
                            ->limit(10)
                            ->get()->toArray();
                    }

                    $graphArr['scheme1']['data'] = $graph1;
                    $graphArr['scheme1']['top_scripts_sum'] = count($graph1) ? collect($graph1)->sum('content_per') : 'NA';
                } else {
                    $graph1 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value1)->select('scrip_name', 'type', 'industry', 'percentage', 'percentage as content_per')->orderBy('content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme1']['data'] = $graph1;
                    $graphArr['scheme1']['top_scripts_sum'] = count($graph1) ? collect($graph1)->sum('content_per') : 'NA';

                    //dd($graphArr['scheme1']);
                }
                if (!empty($value2_type) && $value2_type == 'scheme') {
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value2)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;

                    $graph2 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value2)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'scrip_name',
                            'industry',
                            'corpus_entry_date',
                            'composition_entry_date',
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
                        )
                        ->orderBy('content_per', 'desc')
                        ->groupBy('scrip_name')
                        ->limit(10)
                        ->get()->toArray();
                    $graphArr['scheme2']['data'] = $graph2;
                    $graphArr['scheme2']['top_scripts_sum'] = count($graph2) ? collect($graph2)->sum('content_per') : 'NA';
                } else {
                    $graph2 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value2)->select('scrip_name', 'type', 'industry', 'percentage', 'percentage as content_per')->orderBy('content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme2']['data'] = $graph2;
                    $graphArr['scheme2']['top_scripts_sum'] = count($graph2) ? collect($graph2)->sum('content_per') : 'NA';
                }

                if (!empty($value3_type) && $value3_type == 'scheme') {
                    //dd($corpusEntryLastDate);
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value3)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;

                    $graph3 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value3)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'scrip_name',
                            'industry',
                            'corpus_entry_date',
                            'composition_entry_date',
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
                        )
                        ->orderBy('content_per', 'desc')
                        ->groupBy('scrip_name')
                        ->limit(10)
                        ->get()->toArray();
                    $graphArr['scheme3']['data'] = $graph3;
                    $graphArr['scheme3']['top_scripts_sum'] = count($graph3) ? collect($graph3)->sum('content_per') : 'NA';
                } else {
                    $graph3 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value3)->select('scrip_name', 'type', 'industry', 'percentage', 'percentage as content_per')->orderBy('content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme3']['data'] = $graph3;
                    $graphArr['scheme3']['top_scripts_sum'] = count($graph3) ? collect($graph3)->sum('content_per') : 'NA';
                }

                if (!empty($value4_type) && $value4_type == 'scheme') {
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value4)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;

                    $graph4 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value4)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'scrip_name',
                            'industry',
                            'corpus_entry_date',
                            'composition_entry_date',
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
                        )
                        ->orderBy('content_per', 'desc')
                        ->groupBy('scrip_name')
                        ->limit(10)
                        ->get()->toArray();
                    $graphArr['scheme4']['data'] = $graph4;
                    $graphArr['scheme4']['top_scripts_sum'] = count($graph4) ? collect($graph4)->sum('content_per') : 'NA';
                } else {
                    $graph4 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value4)->select('scrip_name', 'type', 'industry', 'percentage', 'percentage as content_per')->orderBy('content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme4']['data'] = $graph4;
                    $graphArr['scheme4']['top_scripts_sum'] = count($graph4) ? collect($graph4)->sum('content_per') : 'NA';
                }

                if (!empty($value5_type) && $value5_type == 'scheme') {
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value5)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;

                    $graph5 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value5)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'scrip_name',
                            'industry',
                            'corpus_entry_date',
                            'composition_entry_date',
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
                        )
                        ->orderBy('content_per', 'desc')
                        ->groupBy('scrip_name')
                        ->limit(10)
                        ->get()->toArray();
                    $graphArr['scheme5']['data'] = $graph5;
                    $graphArr['scheme5']['top_scripts_sum'] = count($graph5) ? collect($graph5)->sum('content_per') : 'NA';
                } else {
                    $graph5 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value5)->select('scrip_name', 'type', 'industry', 'percentage', 'percentage as content_per')->orderBy('content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme5']['data'] = $graph5;
                    $graphArr['scheme5']['top_scripts_sum'] = count($graph5) ? collect($graph5)->sum('content_per') : 'NA';
                }
            } elseif ($compare_type == 'top_industry') {
                if ($value1_type == 'scheme') {
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value1)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;
                    $graph1 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value1)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'industry',
                            'category',
                            'fund_code',
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('SUM(content_per) as allocation'),
                            // DB::raw('SUM(content_per/100) as allocation'),
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as industry_content_per')
                        )
                        ->orderBy('industry_content_per', 'desc')
                        ->groupBy('industry')
                        ->limit(10)
                        ->get()->toArray();
                    //$graph1 = DB::select('CALL sp_fund_search_portfolio_top_industry("' . date("m", strtotime($corpusEntryLastDate)) . '","' . date("Y", strtotime($corpusEntryLastDate)) . '","' . $value1 . '",10)');
                    if (empty($graph1)) {
                        $year = date("Y", strtotime($corpusEntryLastDate));
                        $month = date("m", strtotime($corpusEntryLastDate));
                        $fdate = ($year . '-' . $month . '-1');
                        $from_date = date("Y-m-d", strtotime($fdate . ' -1 month'));
                        $corpusEntryLastDate = date("Y-m-t", strtotime($from_date));
                        //dd($from_date);
                        $total_corpus_entry = DB::table('corpus_entry')
                            ->where('fund_code', $value1)
                            ->where('entry_date', $corpusEntryLastDate)
                            ->select(
                                DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
                            )->first()->total_corpus_entry;
                        $graph1 =
                            DB::table('view_corpus_with_allocation')
                            ->where('fund_code', $value1)
                            ->where('corpus_entry_date', $corpusEntryLastDate)
                            ->where('composition_entry_date', $corpusEntryLastDate)
                            ->where('category', 'Equity')
                            ->select(
                                'industry',
                                'category',
                                'fund_code',
                                DB::raw($total_corpus_entry . ' as AUM'),
                                DB::raw('SUM(content_per) as allocation'),
                                // DB::raw('SUM(content_per/100) as allocation'),
                                DB::raw('SUM(calculated_amount/100) as amount'),
                                DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as industry_content_per')
                            )
                            ->orderBy('industry_content_per', 'desc')
                            ->groupBy('industry')
                            ->limit(10)
                            ->get()->toArray();
                    }

                    $graphArr['scheme1']['data'] = $graph1;
                    $graphArr['scheme1']['top_industry_sum'] = count($graph1) ? round(collect($graph1)->sum('industry_content_per')) : 'NA';
                } else {
                    $graph1 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value1)->select('scrip_name', 'type', 'industry', 'percentage', DB::raw('SUM(percentage) as industry_content_per'))->groupBy('industry')->orderBy('industry_content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme1']['data'] = $graph1;
                    $graphArr['scheme1']['top_industry_sum'] = count($graph1) ? collect($graph1)->sum('industry_content_per') : 'NA';
                    //dd($graphArr['scheme1']);
                }
                if (!empty($value2_type) && $value2_type == 'scheme') {
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value2)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 200, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;
                    $graph2 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value2)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'industry',
                            'category',
                            'fund_code',
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('SUM(content_per) as allocation'),
                            // DB::raw('SUM(content_per/100) as allocation'),
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as industry_content_per')
                        )
                        ->orderBy('industry_content_per', 'desc')
                        ->groupBy('industry')
                        ->limit(10)
                        ->get()->toArray();
                    $graphArr['scheme2']['data'] = $graph2;
                    $graphArr['scheme2']['top_industry_sum'] = count($graph2) ? round(collect($graph2)->sum('industry_content_per')) : 'NA';
                } else {
                    $graph2 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value2)->select('scrip_name', 'type', 'industry', 'percentage', DB::raw('SUM(percentage) as industry_content_per'))->groupBy('industry')->orderBy('industry_content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme2']['data'] = $graph2;
                    $graphArr['scheme2']['top_industry_sum'] = count($graph2) ? collect($graph2)->sum('industry_content_per') : 'NA';
                    //dd($graphArr['scheme2']);
                }
                if (!empty($value3_type) && $value3_type == 'scheme') {
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value3)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 200, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;
                    $graph3 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value3)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'industry',
                            'category',
                            'fund_code',
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('SUM(content_per) as allocation'),
                            // DB::raw('SUM(content_per/100) as allocation'),
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as industry_content_per')
                        )
                        ->orderBy('industry_content_per', 'desc')
                        ->groupBy('industry')
                        ->limit(10)
                        ->get()->toArray();
                    $graphArr['scheme3']['data'] = $graph3;
                    $graphArr['scheme3']['top_industry_sum'] = count($graph3) ? round(collect($graph3)->sum('industry_content_per')) : 'NA';
                } else {
                    $graph3 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value3)->select('scrip_name', 'type', 'industry', 'percentage', DB::raw('SUM(percentage) as industry_content_per'))->groupBy('industry')->orderBy('industry_content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme3']['data'] = $graph3;
                    $graphArr['scheme3']['top_industry_sum'] = count($graph3) ? collect($graph3)->sum('industry_content_per') : 'NA';
                }
                if (!empty($value4_type) && $value4_type == 'scheme') {
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value4)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 200, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;
                    $graph4 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value4)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'industry',
                            'category',
                            'fund_code',
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('SUM(content_per) as allocation'),
                            // DB::raw('SUM(content_per/100) as allocation'),
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as industry_content_per')
                        )
                        ->orderBy('industry_content_per', 'desc')
                        ->groupBy('industry')
                        ->limit(10)
                        ->get()->toArray();
                    $graphArr['scheme4']['data'] = $graph4;
                    $graphArr['scheme4']['top_industry_sum'] = count($graph4) ? round(collect($graph4)->sum('industry_content_per')) : 'NA';
                } else {
                    $graph4 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value4)->select('scrip_name', 'type', 'industry', 'percentage', DB::raw('SUM(percentage) as industry_content_per'))->groupBy('industry')->orderBy('industry_content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme4']['data'] = $graph4;
                    $graphArr['scheme4']['top_industry_sum'] = count($graph4) ? collect($graph4)->sum('industry_content_per') : 'NA';
                }
                if (!empty($value5_type) && $value5_type == 'scheme') {
                    $total_corpus_entry = DB::table('corpus_entry')
                        ->where('fund_code', $value5)
                        ->where('entry_date', $corpusEntryLastDate)
                        ->select(
                            DB::raw('COALESCE(SUM(corpus_entry) / 200, 1) as total_corpus_entry')
                        )->first()->total_corpus_entry;
                    $graph5 =
                        DB::table('view_corpus_with_allocation')
                        ->where('fund_code', $value5)
                        ->where('corpus_entry_date', $corpusEntryLastDate)
                        ->where('composition_entry_date', $corpusEntryLastDate)
                        ->where('category', 'Equity')
                        ->select(
                            'industry',
                            'category',
                            'fund_code',
                            DB::raw($total_corpus_entry . ' as AUM'),
                            DB::raw('SUM(content_per) as allocation'),
                            // DB::raw('SUM(content_per/100) as allocation'),
                            DB::raw('SUM(calculated_amount/100) as amount'),
                            DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as industry_content_per')
                        )
                        ->orderBy('industry_content_per', 'desc')
                        ->groupBy('industry')
                        ->limit(10)
                        ->get()->toArray();
                    $graphArr['scheme5']['data'] = $graph5;
                    $graphArr['scheme5']['top_industry_sum'] = count($graph5) ? round(collect($graph5)->sum('industry_content_per')) : 'NA';
                } else {
                    $graph5 =  IndicesComposition::whereDate('entry_date', $indiceCompositionLastDate)->where('correlation_new', $value5)->select('scrip_name', 'type', 'industry', 'percentage', DB::raw('SUM(percentage) as industry_content_per'))->groupBy('industry')->orderBy('industry_content_per', 'desc')->limit(10)->get();
                    $graphArr['scheme5']['data'] = $graph5;
                    $graphArr['scheme5']['top_industry_sum'] = count($graph5) ? collect($graph5)->sum('industry_content_per') : 'NA';
                }
            } else {

                $graphArr['scheme1']['data'] = CorpusEntry::select(['fund_code', 'entry_date', 'corpus_entry'])->where('publish', 'y')->where('fund_code', $value1)->where('entry_date', $corpusEntryLastDate)->first();
                $graphArr['scheme2']['data'] = CorpusEntry::select(['fund_code', 'entry_date', 'corpus_entry'])->where('publish', 'y')->where('fund_code', $value2)->where('entry_date', $corpusEntryLastDate)->first();
                $graphArr['scheme3']['data'] = CorpusEntry::select(['fund_code', 'entry_date', 'corpus_entry'])->where('publish', 'y')->where('fund_code', $value3)->where('entry_date', $corpusEntryLastDate)->first();
                $graphArr['scheme4']['data'] = CorpusEntry::select(['fund_code', 'entry_date', 'corpus_entry'])->where('publish', 'y')->where('fund_code', $value4)->where('entry_date', $corpusEntryLastDate)->first();
                $graphArr['scheme5']['data'] = CorpusEntry::select(['fund_code', 'entry_date', 'corpus_entry'])->where('publish', 'y')->where('fund_code', $value5)->where('entry_date', $corpusEntryLastDate)->first();
            }

            $responseArr['composition_data'] = $graphArr;
            $responseArr['notice_text'] = $notice_text;
            $responseArr['notice_value_type'] = $notice_value_type;
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getPerformanceSnapshot(Request $request)
    {
        // dd($request->all());
        $dataArr = $responseArr = [];
        $message = __('message');

        $type = (isset($request->type) && $request->type) ? $request->type : '';
        $type_id = isset($request->fund_type_id) ? $request->fund_type_id : '';
        $report_category = isset($request->report_category) ? $request->report_category : '';
        $date = (isset($request->date) && $request->date) ? urldecode($request->date) : '';
        // $Latest_corpus_entry_date='2024-03-31';
        $last_aaum =  DB::select("SELECT `entry_date` FROM `mpx_corpus_entry` WHERE fund_code IN (SELECT fund_code FROM mpx_fund_master WHERE fund_type_id = $type_id) ORDER BY `entry_date` DESC LIMIT 0,1;");
        $last_aaum_date = $last_aaum[0]->entry_date;

        $corpusdate = Carbon::createFromFormat('Y-m-d', $date);

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
        // dd($last_aaum_date);
        if ($type == 'weekly') {
            if ($report_category == 'return') {
                $dataArr = DB::select('CALL sp_weekly_funds("' . $date . '",' . $type_id . ')');
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
        if (count($dataArr)) {
            $responseArr['snapshot_data'] = $dataArr;
            $responseArr['test'] = $type_id;
            if ($report_category == 'corpus_change') {
                $responseArr['aaum_date'] = $final_corpus_date;
            }
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function sendSipPlannerEmail(Request $request)
    {
        $responseArr = [];
        $inputs = $request->all();
        $inputs['image_url'] = '';
        if ($inputs['output']) {
            $inputs['image_url'] = $this->saveGraphImage($inputs['output']);
        }

        //dd($inputs);
        $mailPSObj = new MailPS();
        $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

        $email = $inputs['email'];

        $mailArr = ["fullname" => rtrim($inputs['name']), "form_data" => $inputs['form_data'], "result_data" => $inputs['result_data'], 'image_url' => ($inputs['plan'] == 5) ? $inputs['image_url'] : ''];

        $subject    = 'Sip Planner Calculator Result';
        $content    = view('emails.web.to-user-sip-planner', compact('mailArr', 'mailCssAtr'));
        $fromName = 'myplexusTeam';
        $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
        if ($mailResp) {
        }
        return $this->sendResponse($responseArr, 'Mail has been sent to your E-mail ID.');
    }
    public function sendRetirementCalulatorEmail(Request $request)
    {
        $responseArr = [];


        $commonconstants = Config('commonconstants');
        $messageLang = __('message');
        $rulesArr = [
            'name' => 'required',
            'email' => 'required|email',
            'current_age' => 'required',
            'retirement_age' => 'required',
            'life_expect' => 'required',
            'return_during' => 'required',
            'return_after' => 'required',
            'inflation' => 'required',
            'monthly_expence' => 'required',
            'pension' => 'required',
            'curr_savings' => 'required',
            'current_lumsum' => 'required',
            'corpus_need_on_retirement' => 'required',
            'savings_required_per_month' => 'required',
            'savings_equired_per_year' => 'required',
            'output' => 'required',
        ];

        $validator = Validator::make($request->all(), $rulesArr, [fund_type_id]);

        if ($validator->fails()) {
            return $this->sendError($messageLang['error']['request_validation'], $validator->errors());
        }
        $inputs['image_url'] = '';
        $inputs = $request->all();
        if ($inputs['output']) {
            $inputs['image_url'] = $this->saveGraphImage($inputs['output']);
        }
        $mailPSObj = new MailPS();
        $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

        $email = $inputs['email'];

        $mailArr = ["fullname" => rtrim($inputs['name']), "data" => $inputs, 'image_url' => $inputs['image_url']];

        $subject    = 'Retirement Calculator Result';
        $content    = view('emails.web.to-user-retirement-calculator', compact('mailArr', 'mailCssAtr'));
        $fromName = 'myplexusTeam';
        $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
        if ($mailResp) {
        }
        return $this->sendResponse($responseArr, 'Mail has been sent to your E-mail ID.');
    }
    public function saveGraphImage($img_encoded)
    {
        $image = str_replace('data:image/png;base64,', '', $img_encoded);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(40) . '.' . 'png';
        $folderName = 'calculator-chart-img';
        $destinationPath = Storage::path($folderName);
        if (!\File::exists($destinationPath)) {
            Storage::makeDirectory($folderName);
        }
        \File::put($destinationPath . '/' . $imageName, base64_decode($image));

        return url(Storage::url($folderName . '/' . $imageName));
    }
    public function sendInflationCalculatorEmail(Request $request)
    {
        $responseArr = [];


        $commonconstants = Config('commonconstants');
        $messageLang = __('message');
        $rulesArr = [
            'name' => 'required',
            'email' => 'required|email',
            'current_expenses' => 'required',
            'inflation_rate' => 'required',
            'period' => 'required',
            'inflation_wealth' => 'required',
            'output' => 'required',
        ];

        $validator = Validator::make($request->all(), $rulesArr, []);

        if ($validator->fails()) {
            return $this->sendError($messageLang['error']['request_validation'], $validator->errors());
        }


        $inputs = $request->all();

        $inputs['image_url'] = '';
        $inputs = $request->all();
        if ($inputs['output']) {
            $inputs['image_url'] = $this->saveGraphImage($inputs['output']);
        }

        $mailPSObj = new MailPS();
        $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

        $email = $inputs['email'];

        $mailArr = ["fullname" => rtrim($inputs['name']), "data" => $inputs, 'image_url' => $inputs['image_url']];

        $subject    = 'Inflation Calculator Result';
        $content    = view('emails.web.to-user-inflation-calculator', compact('mailArr', 'mailCssAtr'));
        $fromName = 'myplexusTeam';
        $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
        if ($mailResp) {
        }
        return $this->sendResponse($responseArr, 'Mail has been sent to your E-mail ID.');
    }
    public function sipCalculatorEmail(Request $request)
    {
        $responseArr = [];


        $commonconstants = Config('commonconstants');
        $messageLang = __('message');

        $rulesArr = [
            'name' => 'required',
            'email' => 'required|email',
            'fund_code' => 'required',
            'sip_amount' => 'required',
            'duration_months' => 'required',
            'sip_day' => 'required',
            'sip_return' => 'required',
            'invested_amount' => 'required',
            'current_value' => 'required',
            'current_nav' => 'required',
            'total_unit' => 'required',
        ];


        $validator = Validator::make($request->all(), $rulesArr, []);

        if ($validator->fails()) {
            return $this->sendError($messageLang['error']['request_validation'], $validator->errors());
        }


        $inputs = $request->all();

        $inputs['image_url'] = '';
        $inputs = $request->all();
        if ($inputs['output']) {
            $inputs['image_url'] = $this->saveGraphImage($inputs['output']);
        }

        $mailPSObj = new MailPS();
        $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

        $email = $inputs['email'];

        $mailArr = ["fullname" => rtrim($inputs['name']), "data" => $inputs, 'image_url' => $inputs['image_url']];

        $subject    = 'SIP Performance Calculator Result';
        $content    = view('emails.web.to-user-sip-calculator', compact('mailArr', 'mailCssAtr'));
        $fromName = 'myplexusTeam';
        $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
        if ($mailResp) {
        }
        return $this->sendResponse($responseArr, 'Mail has been sent to your E-mail ID.');
    }
    public function sipPerformanceCalculator(Request $request)
    {
        $responseArr = [];


        $commonconstants = Config('commonconstants');
        $messageLang = __('message');
        $rulesArr = [
            'name' => 'required',
            'email' => 'required|email',
            'fund_code' => 'required',
            'sip_amount' => 'required',
            'duration_months' => 'required',
            'sip_day' => 'required',
        ];

        $validator = Validator::make($request->all(), $rulesArr, []);

        if ($validator->fails()) {
            return $this->sendError($messageLang['error']['request_validation'], $validator->errors());
        }


        $inputs = $request->all();

        $sip_data = DB::select('CALL sp_sip_calc_with_nav(' . $inputs['duration_months'] . ',"' . $inputs['fund_code'] . '",' . $inputs['sip_amount'] . ',' . $inputs['sip_day'] . ')');

        if (count($sip_data)) {
            $row = json_decode(json_encode($sip_data[0]), true);

            $row['ALLNAVS'] = str_replace(array('[', ']'), '', $row['ALLNAVS']);
            $row['ALLNAVS'] = explode(',', $row['ALLNAVS']);
            $row['ALLUNITS'] = str_replace(array('[', ']'), '', $row['ALLUNITS']);
            $row['ALLUNITS'] = explode(',', $row['ALLUNITS']);

            $row['ALLDATES'] = str_replace(array('[', '"', ']'), '', $row['ALLDATES']);
            //$row['ALLDATES'] = str_replace('-', '/', $row['ALLDATES']);
            $row['ALLVALUES'] = str_replace(array('[', ']'), '', $row['ALLVALUES']);
            $row['ALLVALUES'] = explode(',', $row['ALLVALUES']);

            $count = count(explode(',', $row['ALLDATES']));
            $alldates = explode(',', $row['ALLDATES']);

            $allnavs = $row['ALLNAVS'];
            $allvalues = $row['ALLVALUES'];
            $allunits = $row['ALLUNITS'];
            $cnt = ($count - 1);
            $data = [];
            for ($i = 0; $i < $cnt; $i++) {
                $data[] = array("date" => $alldates[$i], "nav" => $allnavs[$i], "sip_value" => $allvalues[$i], "sip_units" => $allunits[$i]);
            }
            $data = array_reverse($data);

            $responseArr  = array('sip_data' => $sip_data[0], 'table_data' => $data, 'current_nav' => $allnavs[$cnt], 'total_unit' => $allunits[$cnt], 'invested_amount' => $row['INVESTEDAMT'], 'current_value' => $row['CURRENTVALUE'], 'sip_return' => '');


            $data = [];
            $invested_amt = 0;
            $total_unit = 0;
            $unit_value = 0;
            $no_of_year = 0;
            $cagr = 0;
            $data_invested_amt = '';
            $data_unit_value = '';


            for ($i = $cnt - 1; $i >= 0; $i--) {
                $invested_amt = $invested_amt + (-$allvalues[$i]);
                $total_unit = $total_unit + $allunits[$i];
                $unit_value = $total_unit * $allnavs[$i];
                $no_of_year = ceil(($i + 1) / 12);
                $cagr = round((pow(($unit_value / $invested_amt), (1 / $no_of_year)) - 1) * 100);
                $data[] = array($alldates[$i], $invested_amt, $unit_value, $allnavs[$i], $cagr);
                $data_invested_amt .= "{ label: '" . $alldates[$i] . "', y: " . $invested_amt . "},";
                $data_unit_value .= "{ label: '" . $alldates[$i] . "', y: " . $unit_value . "},";
            }

            $responseArr['graph_table_data'] = $data;


            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function calculateRiskTolerancePortfolio(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $messageLang = __('message');
        $rulesArr = [
            'name' => 'required',
            'email' => 'required|email',
            'answers' => 'required',
        ];

        $validator = Validator::make($request->all(), $rulesArr, []);

        if ($validator->fails()) {
            return $this->sendError($messageLang['error']['request_validation'], $validator->errors());
        }

        $responseArr = [];
        $inputs = $request->all();
        $fields = 'q1_v1,q1_v2,q1_v3,q1_v4,q1_v5,q1_v6,q1_v7,q2_v1,q2_v2,q3_v1,q3_v2,q3_v3,q3_v4,q3_v5,q3_v6,q3_v7,q3_v8,q3_v9,q3_v10';
        $fieldsArr = explode(",", $fields);
        $insertArr = [];
        $insertArr['reg_name'] = $inputs['name'];
        $insertArr['reg_email'] = $inputs['email'];
        for ($i = 0; $i < count($fieldsArr); $i++) {
            $insertArr[$fieldsArr[$i]] = $inputs['answers'][$i]['answer'] ? (int) $inputs['answers'][$i]['answer'] : 0;
        }
        $portfolio_id = RiskTolerancePortfolio::insertGetId($insertArr);
        if ($portfolio_id) {
            session()->put('risk_portfolio_id', $portfolio_id);
            $dataArr = DB::select('CALL risk_tolerance_portfolio(' . $portfolio_id . ')');
            if (count($dataArr)) {
                $responseArr['risk_tolerance_portfolio'] = json_decode(json_encode($dataArr[0]), true);
                $mailPSObj = new MailPS();
                $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

                $email = $inputs['email'];

                $mailArr = ["fullname" => rtrim($inputs['name']), "portfolio_data" => $responseArr['risk_tolerance_portfolio']];
                $subject    = 'Risk Tolerance Evalutor';
                $content    = view('emails.web.to-user-risk-portfolio', compact('mailArr', 'mailCssAtr'));
                $fromName = 'myplexusTeam';
                $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
                if ($mailResp) {
                }
                return $this->sendResponse($responseArr, 'Mail has been sent to your E-mail ID.');
            }
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getFundCompositionSnapshotFundWatch($fund_code)
    {
        // dd($type_id);
        $dataArr = $responseArr = [];
        $message = __('message');

        // $dataArr = DB::select('CALL sp_fund_composition_classification_fund_watch(' . $type_id . ', "' . $fund_code . '")');

       // $fund_code = "'" . $fund_code . "'";
        // dd($fund_code);
        // echo 'CALL sp_fund_search_portfolio(' . $fund_code . ')';die;
        $dataArr = DB::select('CALL sp_fund_search_portfolio("' . $fund_code . '")');
        
        
        // dd($dataArr);
        if (count($dataArr)) {
            // dd('count successful');
            $dataArr2 = $dataArr[0];
            //dd($dataArr2);
            $year = $dataArr2->yearinfo;
            $month = $dataArr2->monthinfo;
            $last_date = CorpusEntry::getLastPublishedDate();
            $last_date = $year.'-'.$month.'-'. (date("t", strtotime($year . '-' . $month)));

            //dd($last_date);
            $mcap_entry = DB::table('mcap_eps')
                ->select('scrip_name', 'market_cap')
                ->whereYear('entry_date', $year)
                ->whereMonth('entry_date', $month)
                ->orderBy('market_cap', 'DESC')
                ->get();

            // dd($mcap_entry);

            $vlc_scrip_arr = [];
            $lc_scrip_arr = [];
            $mc_scrip_arr = [];
            $sc_scrip_arr = [];

            $i = 0;
            foreach ($mcap_entry as $mcap_val) {

                $i++;

                if ($i >= 1 && $i <= 15) {

                    array_push($vlc_scrip_arr, $mcap_val->scrip_name);
                } else if ($i >= 16 && $i <= 100) {
                    array_push($lc_scrip_arr, $mcap_val->scrip_name);
                } else if ($i >= 101 && $i <= 250) {

                    array_push($mc_scrip_arr, $mcap_val->scrip_name);
                } else if ($i > 250) {

                    array_push($sc_scrip_arr, $mcap_val->scrip_name);
                }
            }

            
            //dd($fund_code);

            //dd($portfolio_array);
            $vlc_val = DB::table('fund_composition')
                ->select(DB::raw('SUM(content_per) as vlc'))
                ->where('fund_code', $fund_code)
                ->whereIn('scrip_name', $vlc_scrip_arr)
                ->whereYear('entry_date', $year)
                ->whereMonth('entry_date', $month)
                ->first();

            $lc_val = DB::table('fund_composition')
                ->select(DB::raw('SUM(content_per) as lc'))
                ->where('fund_code', $fund_code)
                ->whereIn('scrip_name', $lc_scrip_arr)
                ->whereYear('entry_date', $year)
                ->whereMonth('entry_date', $month)
                ->first();

            $mc_val = DB::table('fund_composition')
                ->select(DB::raw('SUM(content_per) as mc'))
                ->where('fund_code', $fund_code)
                ->whereIn('scrip_name', $mc_scrip_arr)
                ->whereYear('entry_date', $year)
                ->whereMonth('entry_date', $month)
                ->first();

            $sc_val = DB::table('fund_composition')
                ->select(DB::raw('SUM(content_per) as sc'))
                ->where('fund_code', $fund_code)
                ->whereIn('scrip_name', $sc_scrip_arr)
                ->whereYear('entry_date', $year)
                ->whereMonth('entry_date', $month)
                ->first();
            $dataArr2->eq_small = round($sc_val->sc, 2);
            $dataArr2->eq_mid = round($mc_val->mc, 2);
            $dataArr2->eq_large = round($lc_val->lc, 2);
            $dataArr2->eq_very_large = round($vlc_val->vlc, 2);    

            

            $responseArr['composition_snapshot_fundwatch'] = $dataArr2;
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
    public function getLastAAUmDate(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $type_id = $request->fund_type_id;
        $last_aaum =  DB::select("SELECT `entry_date` FROM `mpx_corpus_entry` WHERE fund_code IN (SELECT fund_code FROM mpx_fund_master WHERE fund_type_id = $type_id) ORDER BY `entry_date` DESC LIMIT 0,1;");
        $last_aaum_date = $last_aaum[0]->entry_date;
        $responseArr['last_date'] = $last_aaum_date;
        return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
    }

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
                SUM(CASE WHEN entry_date = '$date' THEN closing_nav END) AS closing_nav_current_date,
                SUM(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_nav END) AS closing_nav_sixMonthsAgo,
                SUM(CASE WHEN entry_date = '$oneYearAgo' THEN closing_nav END) AS closing_nav_oneYearAgo,
                SUM(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_nav END) AS closing_nav_twoYearsAgo,
                SUM(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_nav END) AS closing_nav_threeYearsAgo,
                (
                    (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
                    SUM(CASE WHEN mpx_fund_detail.entry_date = '$sixMonthsAgo' THEN mpx_fund_detail.closing_nav END)) / 
                    NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$sixMonthsAgo' THEN mpx_fund_detail.closing_nav END), 0)
                ) * 100 AS sixmonthsReturn,
                (
                    (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
                    SUM(CASE WHEN mpx_fund_detail.entry_date = '$oneYearAgo' THEN mpx_fund_detail.closing_nav END)) / 
                    NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$oneYearAgo' THEN mpx_fund_detail.closing_nav END), 0)
                ) * 100 AS oneYearReturn,
                (
                (
                    POW(
                            CAST(SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(SUM(CASE WHEN mpx_fund_detail.entry_date = '$twoYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
                            (1 / 2)
                        ) - 1 
                    ) * 100
                ) AS twoyearsReturn,
                (
                (
                    POW(
                        CAST(SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                        NULLIF(CAST(SUM(CASE WHEN mpx_fund_detail.entry_date = '$threeYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
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
                    (
                        (SUM(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                        SUM(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_value END)) / 
                        NULLIF(SUM(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_value END), 0)
                    ) * 100 AS sevenDaysReturn,
                    (
                        (SUM(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                        SUM(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_value END)) / 
                        NULLIF(SUM(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_value END), 0)
                    ) * 100 AS fourteenDaysReturn,
                    (
                        (SUM(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                        SUM(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_value END)) / 
                        NULLIF(SUM(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_value END), 0)
                    ) * 100 AS thirtyDaysReturn,
                    (
                        (SUM(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                        SUM(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_value END)) / 
                        NULLIF(SUM(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_value END), 0)
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
        return $fundValue - $indexValue; // Calculate the difference
    }
}
