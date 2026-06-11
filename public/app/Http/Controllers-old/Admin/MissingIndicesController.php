<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;

use Validator;

use App\Lib\Admin\App;

use App\Models\IndicesDetail;
use App\Models\IndicesMaster;
use App\Models\SettingsModel;

use App\Exports\MissingIndicesExport;
use App\Imports\MissingIndicesImport;
use Maatwebsite\Excel\Facades\Excel;

class MissingIndicesController extends BaseController
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
        $defMsg = $indicesName = '';
        $exportDataArr = $fltrDataArr = $dataListModel = [];
        $data = $request->all();

        $listDataAtrArr = App::getReportListDataAtr();

        $status = Config('commonconstants.status_val.1');

        $indicesList = IndicesMaster::list(['status' => $status, 'cor' => 'yes'], ['name', 'corelation'], 'name', 'ASC');

        $fltrDataArr['missing_date'] = $request->has('fmd') ? $request->query('fmd') : '';
        $fltrDataArr['indices'] = $request->has('fic') ? $request->query('fic') : '';

        $dataListModel = IndicesDetail::missingList($fltrDataArr);
        if (!$dataListModel) {
            $defMsg = __('message.info.select_filter');
        }

        if ($fltrDataArr['indices'] != '') {
            $dataMdl = IndicesMaster::getData(['corelation' => $fltrDataArr['indices'], 'status' => $status], ['name']);
            $indicesName = $dataMdl ? $dataMdl->name : '';
        }

        $lastSavedDate = SettingsModel::getSettingValue('idx');

        $exportDataArr = array_merge($exportDataArr, $fltrDataArr);

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.missing-indices.create')];

        return view('themes.backend.pages.indices.missing-list', compact('dataListModel', 'listDataAtrArr', 'fltrDataArr', 'data', 'exportDataArr', 'roleRights', 'indicesList', 'defMsg', 'lastSavedDate', 'indicesName'));
    }

    /**
     * Export the Gamification responses of all users
     *
     */
    public function export(Request $request)
    {
        return Excel::download(new MissingIndicesExport($request->all()), 'missing-indices-list_' . date(Config('commonconstants.dt_tm_frmt')) . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('themes.backend.pages.indices.missing-createform');
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

        $dataImport = new MissingIndicesImport();
        Excel::import($dataImport, $request->file('file_upload'));

        $message = $dataImport->getRowCount() . " rows added successfully.";
        if (count($dataImport->getEntryExistArr()) > 0)
            $message .= " Missing dates are: " . implode(', ', $dataImport->getEntryExistArr()) . " values already exist.";
        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', $message)->with('title', __('admin.success_ttl'));
    }
}
