<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundDetail;
use DB;
class CompareRationController extends BaseController
{
    public function getCompareRatios(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');
        $compare_type = (isset($request->compare_type) && $request->compare_type) ? $request->compare_type : '';
        $value1 = (isset($request->value1) && $request->value1) ? urldecode($request->value1) : '';
        $value2 = (isset($request->value2) && $request->value2) ? urldecode($request->value2) : '';
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
                    $notice_text = 'data available from '. date('d/m/Y', $dateTimestampType1);
                    $notice_value_type = '1';
                }
                if ($dateTimestampFrom < $dateTimestampType2) {
                    $from_date = $type2_first_date;
                    $notice_text = 'data available from '. date('d/m/Y', $dateTimestampType2);
                    $notice_value_type = '2';
                }
            }
            $graphArr = [];
            if ($compare_type != 'rolling_return') {
                $graph1 = DB::select('CALL sp_fund_ratios("'.$from_date.'","'.$to_date.'","'.$value1.'")');
                $graphArr[0] = count($graph1) ? $graph1[0] : [];

                $graph2 = DB::select('CALL sp_fund_ratios("'.$from_date.'","'.$to_date.'","'.$value2.'")');
                $graphArr[1] = count($graph2) ? $graph2[0] : [];
            } else {
                $graph1 = DB::select('CALL sp_rolling_return("'.$from_date.'","'.$to_date.'","'.$value1.'")');
                $graphArr[0] = count($graph1) ? $graph1[0] : [];

                $graph2 = DB::select('CALL sp_rolling_return("'.$from_date.'","'.$to_date.'","'.$value2.'")');
                $graphArr[1] = count($graph2) ? $graph2[0] : [];
            }

            $responseArr['graph_data'] = $graphArr;
            $responseArr['notice_text'] = $notice_text;
            $responseArr['notice_value_type'] = $notice_value_type;
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
}
