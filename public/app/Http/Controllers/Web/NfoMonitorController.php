<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Lib\Core\Core;

use App\Models\PageModel;
use App\Models\NfoOffer;

class NfoMonitorController extends BaseController
{
    public function __construct()
    {
        $this->defDataArr = self::getDefData();
        $this->page_path =env('PAGE_PATHS','web.pages');
    }

    public function html(Request $request){
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);
        }
        return view($this->page_path.'.nfo.list',compact('dataArr'));
    }
    public function index(Request $request, $reqYear = 0)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 28);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $filterArr = $dataListModel = $archiveListModel = $singleArchieve = [];

            $commonconstants = Config('commonconstants');
			
			//dd($commonconstants);		
			
            $dtMdl = new NfoOffer();		
			
            if($reqYear > 0){
				
                $filterArr['year'] = $reqYear;
				
                $dataListModel = $dtMdl->frontListArchieve($filterArr);	
				
				$singleArchieve = $dtMdl->archiveGroupListYearWise($reqYear);
				
				//dd($dataListModel);
				//dd($singleArchieve);
				
            }
            else{
                $curYear = date("Y");			
				
                $archiveListModel = $dtMdl->archiveGroupList();
				//dd($archiveListModel);
				
                if($archiveListModel){
                    foreach ($archiveListModel as $key => $record) {
                        $year = $record->year;
                        $filterArr['year'] = $year;
                       if($year != $curYear){
                            $filterArr['take'] = 3;
                        }
                        $dataListModel[$key]['archive'] = $record;
                        $dataListModel[$key]['items'] = $dtMdl->frontList($filterArr);
                    }
                }
            }
			
			//dd($dataListModel[$key]['archive']);
            $defDataArr = $this->defDataArr;
            $dateFormat = $commonconstants['d_m_y_frmt3'];
            return view($this->page_path.'.nfo.list', compact('defDataArr', 'dataArr', 'dataListModel', 'dateFormat', 'reqYear', 'singleArchieve'));
        }
        return abort(404);
    }

    public function show(Request $request, $reqId)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 41);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $dataMdl = [];

            $dataMdl = NfoOffer::getData(['no_id' => $reqId, 'status' => 1 ]); 
			
			//dd($dataMdl);

            if(!$dataMdl){
                return abort(404);
            }

            $dataArr['item'] = $dataMdl;

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name'])));
            $dateFormat = $commonconstants['dt_frmt'];
			
			$dataMdl = new NfoOffer();
			$archiveListModel = $dataMdl->archiveGroupList();
			
			$nfoMdl = NfoOffer::frontList(['take' => 3], '', '', '','ASC','');
            //dd($nfoMdl);
			
			//dd($dataArr);

            return view($this->page_path.'.nfo.details', compact('defDataArr', 'dataArr', 'dateFormat', 'archiveListModel', 'nfoMdl'));
        }
        return abort(404);
    }
}
