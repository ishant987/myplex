<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;

use Validator;

use App\Lib\Admin\App;

use App\Models\CurrencyDetail;
use App\Models\CurrencyMaster;
use App\Models\SettingsModel;

use App\Exports\MissingCurrencyExport;
use App\Imports\MissingCurrencyImport;
use Maatwebsite\Excel\Facades\Excel;

class MissingCurrencyController extends BaseController
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
        $defMsg = $currencyName = '';
        $exportDataArr = $fltrDataArr = $dataListModel = [];
        $data = $request->all();

        $listDataAtrArr = App::getReportListDataAtr();

        $status = Config('commonconstants.status_val.1');

        $currencyList = CurrencyMaster::list(['status' => $status], ['cm_id', 'name'], 'name', 'ASC');

        $fltrDataArr['missing_date'] = $request->has('fmd') ? $request->query('fmd') : '';
        $fltrDataArr['currency_id'] = $request->has('fci') ? $request->query('fci') : 0;

        $dataListModel = CurrencyDetail::missingList($fltrDataArr);
        if (!$dataListModel) {
            $defMsg = __('message.info.select_filter');
        }

        if (intval($fltrDataArr['currency_id']) > 0) {
            $dataMdl = CurrencyMaster::getData(['currency_id' => $fltrDataArr['currency_id'], 'status' => $status], ['name']);
            $currencyName = $dataMdl ? $dataMdl->name : '';
        }

        $lastSavedDate = SettingsModel::getSettingValue('cur');

        $exportDataArr = array_merge($exportDataArr, $fltrDataArr);

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.missing-currency.create')];

        return view('themes.backend.pages.currency.missing-list', compact('dataListModel', 'listDataAtrArr', 'fltrDataArr', 'data', 'exportDataArr', 'roleRights', 'currencyList', 'defMsg', 'lastSavedDate', 'currencyName'));
    }

    /**
     * Export the Gamification responses of all users
     *
     */
    public function export(Request $request)
    {
        return Excel::download(new MissingCurrencyExport($request->all()), 'missing-currency-list_' . date(Config('commonconstants.dt_tm_frmt')) . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('themes.backend.pages.currency.missing-createform');
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

        $dataImport = new MissingCurrencyImport();
        Excel::import($dataImport, $request->file('file_upload'));

        $message = $dataImport->getRowCount() . " rows added successfully.";
        if (count($dataImport->getEntryExistArr()) > 0)
            $message .= " Missing dates are: " . implode(', ', $dataImport->getEntryExistArr()) . " values already exist.";
        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', $message)->with('title', __('admin.success_ttl'));
    }
}
