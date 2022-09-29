<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
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
use Carbon\Carbon;

use App\Lib\Core\Useful;
use App\Lib\Admin\App;
use App\Lib\Core\MailPS;
use Validator;
use Illuminate\Support\Str;
use Storage;


class CompareSchemeController extends BaseController
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
    public function getCompareComposition(Request $request)
    {
        $dataArr = $responseArr = [];
        $message = __('message');

        $compare_type = (isset($request->compare_type) && $request->compare_type) ? $request->compare_type : '';
        $value1 = (isset($request->value1) && $request->value1) ? urldecode($request->value1) : '';
        $value2 = (isset($request->value2) && $request->value2) ? urldecode($request->value2) : '';
        $month = (isset($request->month) && $request->month) ? $request->month : '';
        $year = (isset($request->year) && $request->year) ? $request->year : '';


        if ($compare_type && $value1 && $value2 && $month && $year) {
            $type1_first_date = '';
            $type2_first_date = '';
            if ($compare_type == 'aaum') {
                $type1_first_date = CorpusEntry::getFirstPublishedDate($value1);

                $type2_first_date = CorpusEntry::getFirstPublishedDate($value2);
            } else {
                $type1_first_date = FundComposition::getFirstPublishedDate($value1);

                $type2_first_date = FundComposition::getFirstPublishedDate($value2);
            }


            $notice_text = '';
            $notice_value_type = '';

            if ($type1_first_date && $type2_first_date) {
                $fdate = strtotime($year.'-'.$month.'-1');
                $from_date = date("Y-m-t", $fdate);
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
            } else {
                return $this->sendError($message['data_not_available'], '');
            }
            $graphArr = [];
            if ($compare_type == 'top_script') {
                $graph1 = DB::select('CALL sp_fund_search_portfolio_top_script("'.date("m", strtotime($from_date)).'","'.date("Y", strtotime($from_date)).'","'.$value1.'",10)');
                $graphArr['scheme1']['data'] = $graph1;
                $graphArr['scheme1']['top_scripts_sum'] = count($graph1) ? collect($graph1)->sum('content_per') : 'NA';

                $graph2 = DB::select('CALL sp_fund_search_portfolio_top_script("'.date("m", strtotime($from_date)).'","'.date("Y", strtotime($from_date)).'","'.$value2.'",10)');
                $graphArr['scheme2']['data'] = $graph2;
                $graphArr['scheme2']['top_scripts_sum'] = count($graph2) ? collect($graph2)->sum('content_per') : 'NA';
            } elseif ($compare_type == 'top_industry') {
                $graph1 = DB::select('CALL sp_fund_search_portfolio_top_industry("'.date("m", strtotime($from_date)).'","'.date("Y", strtotime($from_date)).'","'.$value1.'",10)');
                $graphArr['scheme1']['data'] = $graph1;
                $graphArr['scheme1']['top_industry_sum'] = count($graph1) ? round(collect($graph1)->sum('industry_content_per')) : 'NA';

                $graph2 = DB::select('CALL sp_fund_search_portfolio_top_industry("'.date("m", strtotime($from_date)).'","'.date("Y", strtotime($from_date)).'","'.$value2.'",10)');
                $graphArr['scheme2']['data'] = $graph2;
                $graphArr['scheme2']['top_industry_sum'] = count($graph2) ? round(collect($graph2)->sum('industry_content_per')) : 'NA';
            } else {
                $graphArr['scheme1']['data'] = CorpusEntry::select(['fund_code','entry_date','corpus_entry'])->where('publish', 'y')->where('fund_code', $value1)->where('entry_date', $from_date)->first();
                $graphArr['scheme2']['data'] = CorpusEntry::select(['fund_code','entry_date','corpus_entry'])->where('publish', 'y')->where('fund_code', $value2)->where('entry_date', $from_date)->first();
            }

            $responseArr['composition_data'] = $graphArr;
            $responseArr['notice_text'] = $notice_text;
            $responseArr['notice_value_type'] = $notice_value_type;
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
		$value3 = (isset($request->value3) && $request->value3) ? urldecode($request->value3) : '';
        $value4 = (isset($request->value4) && $request->value4) ? urldecode($request->value4) : '';
        $value5 = (isset($request->value5) && $request->value5) ? urldecode($request->value5) : '';
        $value6 = (isset($request->value6) && $request->value6) ? urldecode($request->value6) : '';
        $from_date = (isset($request->from_date) && $request->from_date) ? $request->from_date : '';
        $to_date = (isset($request->to_date) && $request->to_date) ? $request->to_date : '';
        $typeArr = explode("_", $compare_type);

        if (count($typeArr) == 2 && $value1 && $value2 && $from_date && $to_date) {
            $type1_first_date = '';
            $type2_first_date = '';
			$type3_first_date = '';
			$type4_first_date = '';
			$type5_first_date = '';
			$type6_first_date = '';

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
			 if ($typeArr[1] == 'scheme') {
                $type3_first_date = FundDetail::getFirstPublishedDate($value3);
            }
            if ($typeArr[1] == 'scheme') {
                $type4_first_date = FundDetail::getFirstPublishedDate($value4);
            }
            if ($typeArr[1] == 'scheme') {
                $type5_first_date = FundDetail::getFirstPublishedDate($value5);
            }
            if ($typeArr[1] == 'scheme') {
                $type6_first_date = FundDetail::getFirstPublishedDate($value6);
            }

            $notice_text = '';
            $notice_value_type = '';

            if ($type1_first_date && $type2_first_date || $type3_first_date) {
                $dateTimestampFrom = strtotime($from_date);
                $dateTimestampType1 = strtotime($type1_first_date);
                $dateTimestampType2 = strtotime($type2_first_date);
				 $dateTimestampType3 = strtotime($type3_first_date);
				 $dateTimestampType4 = strtotime($type4_first_date);
				 $dateTimestampType5 = strtotime($type5_first_date);
				 $dateTimestampType6 = strtotime($type6_first_date);

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
				if ($dateTimestampFrom < $dateTimestampType3) {
                    $from_date = $type3_first_date;
                    $notice_text = 'data available from '. date('d/m/Y', $dateTimestampType3);
                    $notice_value_type = '3';
                }
                if ($dateTimestampFrom < $dateTimestampType4) {
                    $from_date = $type4_first_date;
                    $notice_text = 'data available from '. date('d/m/Y', $dateTimestampType4);
                    $notice_value_type = '4';
                }
                if ($dateTimestampFrom < $dateTimestampType5) {
                    $from_date = $type5_first_date;
                    $notice_text = 'data available from '. date('d/m/Y', $dateTimestampType5);
                    $notice_value_type = '5';
                }
                if ($dateTimestampFrom < $dateTimestampType6) {
                    $from_date = $type6_first_date;
                    $notice_text = 'data available from '. date('d/m/Y', $dateTimestampType6);
                    $notice_value_type = '6';
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
            $graphArr[0] = DB::select('CALL sp_fund_index_currency("'.$type1.'","'.$from_date.'","'.$to_date.'",0,"'.$value1.'","","",0)');
            $graphArr[1] = DB::select('CALL sp_fund_index_currency("'.$type2.'","'.$from_date.'","'.$to_date.'",0,"'.$value2.'","","",0)');
			$graphArr[2] = DB::select('CALL sp_fund_index_currency("'.$type2.'","'.$from_date.'","'.$to_date.'",0,"'.$value3.'","","",0)');
			$graphArr[3] = DB::select('CALL sp_fund_index_currency("'.$type2.'","'.$from_date.'","'.$to_date.'",0,"'.$value4.'","","",0)');
			$graphArr[4] = DB::select('CALL sp_fund_index_currency("'.$type2.'","'.$from_date.'","'.$to_date.'",0,"'.$value5.'","","",0)');
			$graphArr[5] = DB::select('CALL sp_fund_index_currency("'.$type2.'","'.$from_date.'","'.$to_date.'",0,"'.$value6.'","","",0)');
            $responseArr['graph_data'] = $graphArr;
            $responseArr['notice_text'] = $notice_text;
            $responseArr['notice_value_type'] = $notice_value_type;
            $responseArr['notice_value_type_text'] = $value3;
            return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
        }
        return $this->sendError($message['data_not_available'], '');
    }
}