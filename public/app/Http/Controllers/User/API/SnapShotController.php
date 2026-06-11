<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SnapShotController extends BaseController
{
    public function getMonthlyBadFunds(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $start_date= date('Y-m-d', mktime(0, 0, 0, date("m"), 0));
        $end_date= date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
        $weekly_bad_funds = DB::select('CALL sp_snapshot_monthly_worst_fund("'.$start_date.'")');
        if (count($weekly_bad_funds)) {
            $responseArr['monthly_bad_funds'] = $weekly_bad_funds;
            $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], $end_date);
    }
    public function getMonthlyBestFunds(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $start_date= date('Y-m-d', mktime(0, 0, 0, date("m"), 0));
        $end_date= date('Y-m-01', mktime(0, 0, 0, date("m"), 0));
        $weekly_best_funds = DB::select('CALL sp_snapshot_monthly_best_fund("'.$start_date.'")');
        if (count($weekly_best_funds)) {
            $responseArr['monthly_best_funds'] = $weekly_best_funds;
            $responseArr['from_date'] = date('d/m/Y', strtotime($end_date));
            $responseArr['to_date'] = date('d/m/Y', strtotime($start_date));
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
}
