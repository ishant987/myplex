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
use App\Modles\SettingsModel;
use DB;

class FundWatchController extends BaseController
{
    public function __construct()
    {
        $this->defDataArr = self::getDefData();
        $this->page_path = env('PAGE_PATHS', 'web.pages');
        $this->Useful = new Useful;
    }

    public function watch(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
            $dtMdl = new FundWatch();
            $commonconstants = Config('commonconstants');
            $archiveListModel = $dtMdl->archiveGroupList();
            // if ($archiveListModel && $reqYear == 0) {
            //     $reqYear = $archiveListModel[0]->year;
            // }

            // $dataListModel = $dtMdl->frontList(['year' => $reqYear]);

            $rcntDataListModel = $dtMdl->frontList([], '', '', '', 10);
            $defDataArr = $this->defDataArr;
            $dateFormat = $commonconstants['d_m_y_frmt2'];
            $media_folder = Core::getUploadedURL($commonconstants['pdf_dir_name']);
        }
        return view($this->page_path . '.fund-watch', compact('dataArr', 'rcntDataListModel', 'archiveListModel', 'media_folder'));
    }
    public function index(Request $request, $reqYear = 0)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $dataListModel = $archiveListModel = $rcntDataListModel = [];
            $reqId = 0;

            $commonconstants = Config('commonconstants');

            $dtMdl = new FundWatch();

            $archiveListModel = $dtMdl->archiveGroupList();
            if ($archiveListModel && $reqYear == 0) {
                $reqYear = $archiveListModel[0]->year;
            }

            $dataListModel = $dtMdl->frontList(['year' => $reqYear]);

            $rcntDataListModel = $dtMdl->frontList([], '', '', '', 3);

            $defDataArr = $this->defDataArr;
            $dateFormat = $commonconstants['d_m_y_frmt2'];

            return view('themes.frontend.pages.fund-watch-list', compact('defDataArr', 'dataArr', 'dataListModel', 'rcntDataListModel', 'archiveListModel', 'dateFormat', 'reqYear', 'reqId'));
        }
        return abort(404);
    }

    public function show(Request $request, $reqId)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 45);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $dataMdl = $dataListModel = $archiveListModel = $rcntDataListModel = [];
            $reqYear = 0;

            $dtMdl = new FundWatch();

            $dataMdl = $dtMdl->getData(['fw_id' => $reqId, 'status' => $commonconstants['status_val'][1]]);

            if (!$dataMdl) {
                return abort(404);
            }

            $archiveListModel = $dtMdl->archiveGroupList();
            if ($archiveListModel) {
                $year = $archiveListModel[0]->year;
                $dataListModel = $dtMdl->frontList(['year' => $year]);
            }

            $rcntDataListModel = $dtMdl->frontList([], '', '', '', 3);

            $dataArr['item'] = $dataMdl;
            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name'])));

            return view('themes.frontend.pages.fund-watch', compact('defDataArr', 'dataArr', 'dataListModel', 'rcntDataListModel', 'archiveListModel', 'reqYear', 'reqId'));
        }
        return abort(404);
    }

    public function newIndex($fund_code)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        $fundMaster = FundMaster::where("fund_code", $fund_code)->first();
        $fundWatch = FundWatchNew::where("fund_code", $fund_code)->first();
        $fund_code = $fundMaster->fund_code;
        $sip = SELF::getSIPData($fund_code);
        $fundCompAnalysis = SELF::fundCompAnalysis($fund_code);
        $lumbsum = SELF::getLumnsubData($fund_code);
        $AAUMValue = SELF::AAUMValue($fund_code);
        $PortFoliBreakup = SELF::breakUP($fund_code); 
        return view($this->page_path . '.fund_watch.details',compact('lumbsum','fundMaster','fundWatch','lumbsum','PortFoliBreakup','fundCompAnalysis'));
        // return response()->json(['fund_code' => $fund_code, 'breakup' => $PortFoliBreakup, 'AAUM' => $AAUMValue, 'lumsum' => $lumbsum, 'sip' => $sip, 'fund_comp_analysis' => $fundCompAnalysis], 200); //
    }
    private function breakUP($fund_code)
    {
        $lastMonthDate = $lastSavedDate =  FundComposition::getPublishReadyDate();
        $filterArray = ['Equity' => 0, 'Cash' => 0, 'Corporate Debt' => 0, 'SOV' => 0, 'Others' => 0];
        $AllBreakUP = FundComposition::where(['fund_code' => $fund_code, 'entry_date' => $lastMonthDate])->get()->toArray();

        foreach ($AllBreakUP as $key => $value) {
            if (in_array($value['category'], array_keys($filterArray))) {
                $filterArray[$value['category']] = $filterArray[$value['category']]+$value['content_per'];
            } else {
                $filterArray['Others'] = $filterArray['Others'] + $value['content_per'];
            }
        }

        return $filterArray;
    }
    private function getSIPData($fund_code)
    {
        $deatultSIPAmount = 10000;
        $defaultYears = ['ONEYEAR' => 1, 'TWOYEAR' => 2, 'THREEYEAR' => 3];
        $dataArr['ONEYEAR'] = DB::select('CALL sp_SIP_calc(12,"' . $fund_code . '",10000)');
        $dataArr['TWOYEAR'] = DB::select('CALL sp_SIP_calc(24,"' . $fund_code . '",10000)');
        $dataArr['THREEYEAR'] = DB::select('CALL sp_SIP_calc(36,"' . $fund_code . '",10000)');
        // $response =Http::get('api/v1/fund-performance-scheme-sip?fund_code='.$fund_code)->json();
        return $dataArr;
    }
    private function AAUMValue($fund_code)
    {
        $numberOfGrapBar = 6;
        $mothsGap = 3;
        $flastMonthDate = $this->Useful->get_last_month();
        $FUnddata = [];
        for ($i = 0; $i <= $numberOfGrapBar; $i++) {
            $s_date = $flastMonthDate[0];
            $dates = $this->Useful->get_last_month_quatery($s_date, $i * $mothsGap);
            $LastMonthDate[] = $dates;
            $FUnddata[] = CorpusEntry::where("fund_code", $fund_code)->where('entry_date', $dates[1])->get(['corpus_entry', 'entry_date'])->toArray();
        }

        return $FUnddata;
    }
    private function getLumnsubData($fund_code)
    {
        $deatultLumsumAmount = 100000;
        $defaultYears = ['ONEYEAR' => 1, 'TWOYEAR' => 2, 'THREEYEAR' => 3];
        $yesterday = $this->Useful->get_yesterday();
        //$yesterday='2022-11-01';
        $fundDetails = FundDetail::where("fund_code", $fund_code);
        $presentClosingNav = $fundDetails->where('entry_date', $yesterday)->first('closing_nav');
        if ($presentClosingNav) {
            $PreviewYearNavs = [];
            $response = Http::get(url('api/v1/fund-return-scheme?fund_code=' . $fund_code))->json();
            $percentege = $response['data']['return_scheme'];
            foreach ($defaultYears as $key => $val) {
                $LastYeardate = $this->Useful->getYears($val, $yesterday);
                $data = FundDetail::where("fund_code", $fund_code)->where('entry_date', $LastYeardate)->first('closing_nav');

                if ($data) {
                    $numberofUnits = round($deatultLumsumAmount / $data->closing_nav, 3);
                    $PreviewYearNavs[$val . ' Year'] = [
                        'amount' => $this->Useful->currencyFormat(round($numberofUnits * $presentClosingNav->closing_nav)),
                        'last_date' => $LastYeardate,
                        'last_date_nav_val' => $data->closing_nav,
                        'start_date' => $yesterday,
                        'start_date_nav_val' => $presentClosingNav['closing_nav'],
                        'numer_of_units' => $numberofUnits,
                        'percentage' => round($percentege[$key], 2),
                    ];
                } else {
                    $PreviewYearNavs[$val . ' Year' . $LastYeardate . $yesterday] = [];
                }
            }
            return $PreviewYearNavs;
        }
        return null;
    }
    private function fundCompAnalysis($fund_code)
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
        return ['headers'=>$headers,'result'=>$result];
    }
}
