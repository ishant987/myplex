<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use App\Lib\Core\Core;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;
use Carbon\Carbon;

use App\Lib\Core\Useful;

use App\Models\IndicesDetail;
use App\Models\SettingsModel;

class DailyIndicesValueController extends BaseController
{
    public $className;

    public function __construct()
    {
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('themes.backend.pages.indices.idcupload');
    }

    public function store(Request $request)
    {
        $btnValue = $request->submit;

        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        try {
            // For file upload.
            if ($btnValue == "upload") {
                $validator = Validator::make($request->all(), [
                    'file_upload' => ['required', function ($attribute, $value, $fail) {
                        if (!in_array($value->getClientOriginalExtension(), ['csv'])) {
                            $fail('Incorrect :attribute type choose.');
                        }
                    }]
                ]);

                // $validator = Validator::make($request->all(), [
                //     'file_upload' => 'required_if:submit,"upload"|mimes:csv',
                // ]);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                if ($request->hasFile('file_upload')) {
                    $today = date($commonconstants['d_m_y_frmt']);
                    $upldDirName = $commonconstants['raw_dir_name'];

                    $file      = $request->file('file_upload');
                    $extension = $file->getClientOriginalExtension();
                    $filename  = 'indices_' . $today . '.' . $extension;
                    $path      = $file->storeAs($upldDirName, $filename);
                    if ($path) {
                        return redirect()->route('admin.indices.values.edit');
                    } else {
                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['file_upload'])->with('title', $admin['error_ttl']);
                    }
                }
            }
            // For previous values for holiday
            if ($btnValue == 'holiday') {
                return redirect()->route('admin.indices.values.edit', 'holiday');
            }
        } catch (QueryException $exception) {
            if (isset($path) && $path) {
                $this->fileDelete($path);
            }

            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($type = '')
    {
        $mdlObj = new IndicesDetail;

        if ($type == 'holiday') {
            $dataListModel = $mdlObj->getActiveIndices();
        } else {
            $commonconstants = Config('commonconstants');
            $adminconstants = Config('adminconstants');

            $message = __('message');
            $admin = __('admin');

            $today = date($commonconstants['d_m_y_frmt']);
            $upldDirName = $commonconstants['raw_dir_name'];
            $frmtdcsvpath  = $upldDirName . '/indices_' . $today . '.csv';
            if (Storage::exists($frmtdcsvpath)) {
                $dataListModel = $mdlObj->getActiveIndices();
                foreach ($dataListModel as $record) {
                    if ($record->corelation === NULL) {
                        $record->closing_value = 'NA';
                    } else {
                        $record->closing_value = $this->getValue($frmtdcsvpath, $record->corelation);
                    }
                }
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['uploaded_file_not_exist'])->with('title', $admin['error_ttl']);
            }
        }

        $otherData = ['last_saved_date' => SettingsModel::getSettingValue('idx')];

        $editDataAtrArr = ["title" => __('admin.indices.list_upld_daily_txt'), "route" => 'indices.values.edit'];

        return view('themes.backend.pages.indices.idcuploadedlist', compact('editDataAtrArr', 'dataListModel', 'otherData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $type = $request->submit;

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();

        $validator = Validator::make($request->all(), [
            'entry_date' => 'required',
            'c_value' => 'required|array'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $nVal = $commonconstants['y_n_val'][2];
            $date = new Carbon();
            $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
            $lastSavedDate = SettingsModel::getSettingValue('idx');
            $entryDate = $request->input('entry_date');
            $diff = Useful::dateDiff($lastSavedDate, $entryDate);
            if ($diff <= 0) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['already_saved'] . $entryDate . '.')->with('title', $admin['warning_ttl']);
            } elseif ($diff > 1) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['must_be_continuous'] . $lastSavedDate . '.')->with('title', $admin['warning_ttl']);
            }
            $closingVal = [];
            $activeIndices = IndicesDetail::getActiveIndices();
            foreach ($activeIndices as $record) {
                $closingVal[$record->corelation] = $record->closing_value;
            }
            $entryValue = $request->input('c_value');
            foreach ($entryValue as $key => $value) {
                if ($value != "NA") {
                    $last = $closingVal[$key];
                    if ($last == 0) {
                        $percentageChange = 0;
                    } else {
                        $percentageChange = (($value - $last) / $last) * 100;
                    }
                    $store = [];
                    $store['name'] = $key;
                    $store['entry_date'] = $entryDate;
                    $store['closing_value'] = $value;
                    $store['holiday'] = $type == 'holiday' ? 1 : 0;
                    $store['percentage_change'] = $percentageChange;
                    $store['publish'] = $nVal;
                    $store['created_id'] = $loginAdminId;
                    $store['updated_id'] = $loginAdminId;
                    $store['created_at'] = $dateFormatted;
                    $store['updated_at'] = $dateFormatted;
                    $totInsrt = IndicesDetail::insert($store);
                }
            }
            if ($totInsrt == 0) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            } else {
                $save = SettingsModel::where('option_key', 'idx')->update(['option_value' => $entryDate, 'updated_id' => $loginAdminId]);
                if ($save == 0) {
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                }
            }
            // Uploaded formatted CSV file deleted.
            $this->fileDelete($commonconstants['raw_dir_name'] . '/indices_' . date($commonconstants['d_m_y_frmt']) . '.csv');
            // Redirect to Upload Daily Indices Value page.
            return redirect()->route('admin.indices.values.create')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['saved'])->with('title', $admin['success_ttl']);
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['saved'])->with('title', $admin['error_ttl']);
            }
        }
    }

    public static function getValue($filePath, $cor)
    {
        $dataArr = Core::csvToArray(Core::getUploadedPath($filePath));
        $data = 'NA';
        if (!empty($dataArr)) {
            foreach ($dataArr as $record) {
                $name = $record['Name'];
                $curValue = $record['CURRENT VALUE'];
                if (strtolower($name) == strtolower($cor)) {
                    $data = strval(round(floatval($curValue), 2));
                }
            }
        }
        return $data;
    }

    public static function fileDelete($filePath)
    {
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }
}
