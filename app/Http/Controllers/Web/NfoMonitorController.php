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

            $filterArr = $dataListModel = $archiveListModel = [];

            $commonconstants = Config('commonconstants');

            $dtMdl = new NfoOffer();
            if($reqYear > 0){
                $filterArr['year'] = $reqYear;
                $dataListModel = $dtMdl->frontList($filterArr);
            }
            else{
                $curYear = date("Y");
                $archiveListModel = $dtMdl->archiveGroupList();
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

            $defDataArr = $this->defDataArr;
            $dateFormat = $commonconstants['d_m_y_frmt2'];

            return view('themes.frontend.pages.nfo-monitor-list', compact('defDataArr', 'dataArr', 'dataListModel', 'dateFormat', 'reqYear'));
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

            $dataMdl = NfoOffer::getData(['no_id' => $reqId, 'status' => $commonconstants['status_val'][1], 'type' => $commonconstants['nfo_monitor_type']['value'][2]]); 

            if(!$dataMdl){
                return abort(404);
            }

            $dataArr['item'] = $dataMdl;

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name'])));
            $dateFormat = $commonconstants['dt_frmt'];

            return view('themes.frontend.pages.nfo-monitor', compact('defDataArr', 'dataArr', 'dateFormat'));
        }
        return abort(404);
    }
}
