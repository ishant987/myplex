<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;

use Validator;

use App\Lib\Admin\App;

use App\Models\FundDetail;
use App\Models\FundMaster;
use App\Models\SettingsModel;

use App\Exports\MissingNavExport;
use App\Imports\MissingNavImport;
use Maatwebsite\Excel\Facades\Excel;

class MissingNavController extends BaseController
{
    public $className;

    public function __construct()
    {
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $defMsg = $fundName = '';
        $exportDataArr = $fltrDataArr = $dataListModel = [];
        $data = $request->all();

        $listDataAtrArr = App::getReportListDataAtr();

        $status = Config('commonconstants.status_val.1');

        $fundList = FundMaster::list(['status' => $status], ['fund_code', 'fund_name'], 'fund_name', 'ASC');

        $fltrDataArr['missing_date'] = $request->has('fmd') ? $request->query('fmd') : '';
        $fltrDataArr['fund_code'] = $request->has('ffc') ? $request->query('ffc') : '';

        $dataListModel = FundDetail::missingList($fltrDataArr);
        if (!$dataListModel) {
            $defMsg = __('message.info.select_filter');
        }

        if ($fltrDataArr['fund_code'] != '') {
            $dataMdl = FundMaster::getData(['fund_code' => $fltrDataArr['fund_code'], 'status' => $status], ['fund_name']);
            $fundName = $dataMdl ? $dataMdl->fund_name : '';
        }

        $lastSavedDate = SettingsModel::getSettingValue('nav');

        $exportDataArr = array_merge($exportDataArr, $fltrDataArr);

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.missing-nav.create')];

        return view('themes.backend.pages.fund.missing-list', compact('dataListModel', 'listDataAtrArr', 'fltrDataArr', 'data', 'exportDataArr', 'roleRights', 'fundList', 'defMsg', 'lastSavedDate', 'fundName'));
    }

    /**
     * Export the Gamification responses of all users
     *
     */
    public function export(Request $request)
    {
        return Excel::download(new MissingNavExport($request->all()), 'missing-nav-list_' . date(Config('commonconstants.dt_tm_frmt')) . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('themes.backend.pages.fund.missing-createform');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_upload' => 'required|mimes:xls,xlsx'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dataImport = new MissingNavImport();
        Excel::import($dataImport, $request->file('file_upload'));

        $message = $dataImport->getRowCount() . " rows added successfully.";
        if (count($dataImport->getEntryExistArr()) > 0)
            $message .= " Missing dates are: " . implode(', ', $dataImport->getEntryExistArr()) . " values already exist.";
        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', $message)->with('title', __('admin.success_ttl'));
    }
}
