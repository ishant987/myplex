<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;
use Carbon\Carbon;

use App\Lib\Core\Useful;
use App\Lib\App\Common;
use App\Lib\Core\Core;

use App\Models\FundDetail;
use App\Models\SettingsModel;

class DailyNavsValueController extends BaseController
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
        return view('themes.backend.pages.fund.navupload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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
                        if (!in_array($value->getClientOriginalExtension(), ['txt'])) {
                            $fail('Incorrect :attribute type choose.');
                        }
                    }]
                ]);

                // $validator = Validator::make($request->all(), [
                //     'file_upload' => 'required_if:submit,"upload"|mimes:txt',
                // ]);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                if ($request->hasFile('file_upload')) {
                    $today = date($commonconstants['d_m_y_frmt']);
                    $upldDirName = $commonconstants['raw_dir_name'];

                    $file      = $request->file('file_upload');
                    $extension = $file->getClientOriginalExtension();
                    $filename  = 'nav_' . $today . '.' . $extension;
                    $path      = $file->storeAs($upldDirName, $filename);
                    if ($path) {
                        $csvpath  = $upldDirName . '/nav_fetched_' . $today . '.csv';
                        if (Storage::exists($path)) {
                            Storage::put($csvpath, Storage::get($path));
                            $frmtdcsvpath  = $upldDirName . '/nav_' . $today . '.csv';
                            if (!Storage::exists($frmtdcsvpath)) {
                                $fileHandle = fopen(Core::getUploadedPath($csvpath), "r");
                                $outHandle = fopen(Core::getUploadedPath($frmtdcsvpath), "w");
                                while (!feof($fileHandle)) {
                                    $fund = fgetcsv($fileHandle, 1024, ';');
                                    if (isset($fund[0]) && isset($fund[3]) && isset($fund[4])) {
                                        $cor = $fund[3];
                                        $cor = Common::formatAMFIData($cor);
                                        $cor = strtoupper($cor);
                                        if (!is_numeric($fund[4])) {
                                            fputs($outHandle, $fund[0] . ';' . $cor . ';0.0' . PHP_EOL, 1024);
                                        } else {
                                            fputs($outHandle, $fund[0] . ';' . $cor . ';' . $fund[4] . PHP_EOL, 1024);
                                        }
                                    }
                                }
                                // Not used / temp files deleted.
                                $this->fileDelete($path);
                                $this->fileDelete($csvpath);
                                return redirect()->route('admin.navs.values.edit');
                            } else {
                                // Not used / temp files deleted.
                                $this->fileDelete($path);
                                $this->fileDelete($csvpath);
                                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['file_exist'])->with('title', $admin['error_ttl']);
                            }
                        }
                    } else {
                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['file_upload'])->with('title', $admin['error_ttl']);
                    }
                }
            }
            // For previous NAVs values for holiday
            if ($btnValue == 'holiday') {
                return redirect()->route('admin.navs.values.edit', 'holiday');
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
        $mdlObj = new FundDetail;

        if ($type == 'holiday') {
            $dataListModel = $mdlObj->getActiveFunds();
        } else {
            $commonconstants = Config('commonconstants');
            $adminconstants = Config('adminconstants');

            $message = __('message');
            $admin = __('admin');

            $today = date($commonconstants['d_m_y_frmt']);
            $upldDirName = $commonconstants['raw_dir_name'];
            $frmtdcsvpath  = $upldDirName . '/nav_' . $today . '.csv';
            if (Storage::exists($frmtdcsvpath)) {
                $dataListModel = $mdlObj->getActiveFunds();
                foreach ($dataListModel as $record) {
                    if ($record->cor === NULL) {
                        $record->last_nav = 'NA';
                    } else {
                        $record->last_nav = $this->getNAV($frmtdcsvpath, $record->cor);
                    }
                }
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['uploaded_file_not_exist'])->with('title', $admin['error_ttl']);
            }
        }

        $otherData = ['last_saved_date' => SettingsModel::getSettingValue('nav')];

        $editDataAtrArr = ["title" => __('admin.fund.nav.list_upld_daily_txt'), "route" => 'navs.values.edit'];

        return view('themes.backend.pages.fund.navuploadedlist', compact('editDataAtrArr', 'dataListModel', 'otherData'));
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
            'nav' => 'required|array'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $nVal = $commonconstants['y_n_val'][2];
            $date = new Carbon();
            $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
            $lastSavedDate = SettingsModel::getSettingValue('nav');
            $entryDate = $request->input('entry_date');
            $diff = Useful::dateDiff($lastSavedDate, $entryDate);
            if ($entryDate == $dateFormatted) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['must_be_save_tomorrow'])->with('title', $admin['warning_ttl']);
            } elseif ($diff <= 0) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['already_saved'] . $entryDate . '.')->with('title', $admin['warning_ttl']);
            } elseif ($diff > 1) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['must_be_continuous'] . $lastSavedDate . '.')->with('title', $admin['warning_ttl']);
            }
            $lastNav = [];
            $activeFunds = FundDetail::getActiveFunds();
            foreach ($activeFunds as $fund) {
                $lastNav[$fund->fund_code] = $fund->last_nav;
            }
            $entryValue = $request->input('nav');
            foreach ($entryValue as $key => $value) {
                if ($value != "NA") {
                    $last = $lastNav[$key];
                    if ($last == 0) {
                        $percentageChange = 0;
                    } else {
                        $percentageChange = (($value - $last) / $last) * 100;
                    }
                    $store = [];
                    $store['fund_code'] = $key;
                    $store['entry_date'] = $entryDate;
                    $store['closing_nav'] = $value;
                    $store['holiday'] = $type == 'holiday' ? 1 : 0;
                    $store['percentage_change'] = $percentageChange;
                    $store['publish'] = $nVal;
                    $store['created_id'] = $loginAdminId;
                    $store['updated_id'] = $loginAdminId;
                    $store['created_at'] = $dateFormatted;
                    $store['updated_at'] = $dateFormatted;
                    $totInsrt = FundDetail::insert($store);
                }
            }
            if ($totInsrt == 0) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            } else {
                $save = SettingsModel::where('option_key', 'nav')->update(['option_value' => $entryDate, 'updated_id' => $loginAdminId]);
                if ($save == 0) {
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                }
            }
            // Uploaded formatted CSV file deleted.
            $this->fileDelete($commonconstants['raw_dir_name'] . '/nav_' . date($commonconstants['d_m_y_frmt']) . '.csv');
            // Redirect to Upload Daily NAVs Value page.
            return redirect()->route('admin.navs.values.create')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['saved'])->with('title', $admin['success_ttl']);
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['saved'])->with('title', $admin['error_ttl']);
            }
        }
    }

    public static function getNAV($filePath, $cor)
    {
        $page = file_get_contents(Core::getUploadedPath($filePath));
        $cor = Common::formatAMFIData($cor);
        $cor = strtoupper($cor);
        $ret = preg_match("/;{$cor};([0-9.]*)/i", $page, $match);
        if ($ret === 1) {
            $data = strval(round(floatval($match[1]), 2));
        } else {
            $data = 'NA';
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
