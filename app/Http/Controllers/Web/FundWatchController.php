<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Lib\Core\Core;
use App\Lib\Core\Useful;
use App\Lib\App\Common;
use App\Models\FundDetail;
use App\Models\PageModel;
use App\Models\FundWatch;
use App\Models\FundMaster;

class FundWatchController extends BaseController
{
    public function __construct()
    {
        $this->defDataArr = self::getDefData();
        $this->page_path =env('PAGE_PATHS','web.pages');
        $this->Useful =new Useful;
    }

    public function watch(Request $request){
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

            $rcntDataListModel = $dtMdl->frontList([], '', '', '',10);
            $defDataArr = $this->defDataArr;
            $dateFormat = $commonconstants['d_m_y_frmt2'];
            $media_folder=Core::getUploadedURL($commonconstants['pdf_dir_name']);
        }
        return view($this->page_path.'.fund-watch',compact('dataArr', 'rcntDataListModel', 'archiveListModel','media_folder' ));
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
    public function newIndex(){
        $fundMaster =FundMaster::where("fund_code",'007')->first();
        // $lumbsum=SELF::getLumnsubData($fundMaster->fund_code);
		$AAUMValue=SELF::AAUMValue($fundMaster->fund_code);
        dd($AAUMValue);
    }
	private function AAUMValue($fund_code){
        $numberOfGrapBar =6;
        $flastMonthDate =$this->Useful->get_last_month();
        $lastMonthDate=$FUnddata=[]; 
        for($i=0;$i<=$numberOfGrapBar;$i++){
            $s_date =!empty($lastMonthDate) ? $lastMonthDate[$i-1][0] : $flastMonthDate[0];
            $getLastMonthDate =$this->Useful->get_last_month_quatery($s_date,$i);
            $LastMonthDate[$i] =$getLastMonthDate;
            $FUnddata[] =FundDetail::where("fund_code",$fund_code)->whereBetween('entry_date', [$getLastMonthDate[0],$getLastMonthDate[1]])->get()->toArray();
        }
        
        return $FUnddata;
	}   
    private function getLumnsubData($fund_code){
        $deatultLumsumAmount =100000;
        $defaultYears=[1,2,3];
        $yesterday=$this->Useful->get_yesterday();
        
		$fundDetails =FundDetail::where("fund_code",$fund_code);
        $presetClosingNav =$fundDetails->where('entry_date',$yesterday)->first('closing_nav')->toArray();
		$numberofUnits =round($deatultLumsumAmount/$presetClosingNav['closing_nav'],2);
		$PreviewYearNavs =[];
        foreach($defaultYears as $key=>$val)
		{
			$LastYeardate=$this->Useful->getYears($val,$yesterday);
			$data =FundDetail::where("fund_code",$fund_code)->where('entry_date',$LastYeardate)->first('closing_nav');
			if($data){
				$PreviewYearNavs[$val.' Year'] =[
					'amount'=>$this->Useful->currencyFormat(round($deatultLumsumAmount+($numberofUnits * $data->closing_nav))),
					'last_date'=>$LastYeardate,
					'last_date_nav_val'=>$data->closing_nav,
					'start_date'=>$yesterday,
					'start_date_nav_val'=>$presetClosingNav['closing_nav'],
					'numer_of_units'=>$numberofUnits,
				];
			}else{
				$PreviewYearNavs[$val.' Year'.$LastYeardate.$yesterday] =null;
			}
		}
		return $PreviewYearNavs;

    }
}
