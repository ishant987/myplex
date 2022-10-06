<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;
use Carbon\Carbon;

use App\Lib\App\Common;
use App\Lib\Core\Core;
use App\Lib\Core\Useful;
use App\Models\Corpus;
use App\Models\CorpusEntry;
use App\Models\SettingsModel;
use Illuminate\Support\Facades\DB;

class MonthlyAUMsValueController extends BaseController
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
        $otherData = ['last_saved_date' => SettingsModel::getSettingValue('aum'), 'months_list' => Common::months(), 'year_list' => Common::years()];

        return view('themes.backend.pages.fund.aumsupload', compact('otherData'));
    }

    public function store(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        try {
            $validator = Validator::make($request->all(), [
                'file_upload' => ['required', function ($attribute, $value, $fail) {
                    if (!in_array($value->getClientOriginalExtension(), ['csv'])) {
                        $fail('Incorrect :attribute type choose.');
                    }
                }],
                'entry_month' => 'required',
                'entry_year' => 'required'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $entry_month = $request->entry_month;
            $entry_year = $request->entry_year;
            $curMonthLastDate = Common::getLastDateOfMonth($entry_month, $entry_year);
            $prevMonthLastDate = Common::getPreviousMonthLastDate($entry_month, $entry_year);
            $lastSavedDate = SettingsModel::getSettingValue('aum');
            $diff = Useful::dateDiff($lastSavedDate, $prevMonthLastDate);
            // dd($diff);
            if ($diff < 0) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['already_saved'] . $curMonthLastDate . '.')->with('title', $admin['warning_ttl']);
            } elseif ($diff > 1) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['must_be_continuous'] . $lastSavedDate . '.')->with('title', $admin['warning_ttl']);
            }

            if ($request->hasFile('file_upload')) {
                $today = date($commonconstants['d_m_y_frmt']);
                $upldDirName = $commonconstants['raw_dir_name'];

                $file      = $request->file('file_upload');
                $extension = $file->getClientOriginalExtension();
                $filename  = 'aums_' . $today . '.' . $extension;
                $path      = $file->storeAs($upldDirName, $filename);
                if ($path) {
                    return redirect()->route('admin.aums.values.edit', $curMonthLastDate);
                } else {
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['file_upload'])->with('title', $admin['error_ttl']);
                }
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
    public function edit($saveValueDate='')
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $mdlObj = new CorpusEntry;

        $today = date($commonconstants['d_m_y_frmt']);
        $upldDirName = $commonconstants['raw_dir_name'];
        $frmtdcsvpath  = $upldDirName . '/aums_' . $today . '.csv';
        if (Storage::exists($frmtdcsvpath)) {
            $cmnObj = new Common;
            $fileHandle = fopen(Core::getUploadedPath($frmtdcsvpath), "r");
            $frmtDataArr = [];
            $i = 0;
            while (!feof($fileHandle)) {
                $fund = fgetcsv($fileHandle, 1024, ',');
                // dd($fund);
                if (!empty($fund) && is_numeric($fund[0])) {
                    $cor = $cmnObj->formatAMFIData($fund[1]);
                    $cor = strtoupper($cor);
                    $val1 = floatval($fund[2]);
                    $val2 = floatval($fund[3]);
                    $aum = $val1 + $val2;
                    $frmtDataArr[$i] = ['amfi_fund_code' => $fund[0], 'cor' => $cor, 'aum' => $aum];
                    $i++;
                }
            }
            // dd($frmtDataArr);
            $dataListModel = $mdlObj->getActiveAUMs();
            if($dataListModel){
                // dd($dataListModel);
                foreach ($dataListModel as $record) {
                    $corpuses = Corpus::list(['fund_id' => $record->fund_id], ['fund']);
                    if($corpuses){
                        $sum = 0;
                        foreach ($corpuses as $corpus) {
                            $cor = $cmnObj->formatAMFIData($corpus->fund);
                            $cor = strtoupper($cor);
                            $key = array_search($cor, array_column($frmtDataArr, 'cor'));
                            if ($key) {
                                $val = strval(round(floatval($frmtDataArr[$key]['aum']), 2));
                            } else {
                                $val = 0;
                            }
                            $sum += $val;
                        }
                        $record->aum = $sum;
                        $record->no = count($corpuses);
                    }
                }
            }
        } else {
            return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['uploaded_file_not_exist'])->with('title', $admin['error_ttl']);
        }
        // dd($dataListModel);

        $otherData = ['last_saved_date' => SettingsModel::getSettingValue('aum'), 'save_value_date' => $saveValueDate];

        $editDataAtrArr = ["title" => __('admin.fund.aums.list_lbl_txt'), "route" => 'aums.values.edit'];

        return view('themes.backend.pages.fund.aumsuploadedlist', compact('editDataAtrArr', 'dataListModel', 'otherData'));
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
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();

        $validator = Validator::make($request->all(), [
            'entry_date' => 'required',
            'aum' => 'required|array'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $nVal = $commonconstants['y_n_val'][2];
            $date = new Carbon();
            $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
            $today = date($commonconstants['y_m_d_frmt']);
            $lastSavedDate = SettingsModel::getSettingValue('aum');
            $entryDate = $request->input('entry_date');
            if ($lastSavedDate == $today) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['already_saved'] . $entryDate . '.')->with('title', $admin['warning_ttl']);
            }
            $exstngDataArr = [];
            $activeAUMs = CorpusEntry::getActiveAUMs();
            // dd($activeAUMs);
            foreach ($activeAUMs as $record) {
                $exstngDataArr[$record->fund_code] = $record->corpus_entry;
            }
            $entryValue = $request->input('aum');
            DB::beginTransaction();
            foreach ($entryValue as $key => $value) {
                $lastValue = $exstngDataArr[$key];
                if ($lastValue == 0) {
                    $corpusChange = 0;
                    $percentageChange = 0;
                } else {
                    $corpusChange = $value - $lastValue;
                    $percentageChange = (($value - $lastValue) / $lastValue) * 100;
                }
                $store = [];
                $store['fund_code'] = $key;
                $store['entry_date'] = $entryDate;
                $store['corpus_entry'] = $value;
                $store['percentage_change'] = $percentageChange;
                $store['corpus_change'] = $corpusChange;
                $store['publish'] = $nVal;
                $store['created_id'] = $loginAdminId;
                $store['created_at'] = $dateFormatted;
                $totInsrt = CorpusEntry::insert($store);
            }
            if ($totInsrt == 0) {
                DB::rollBack();
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            } else {
                $save = SettingsModel::where('option_key', 'aum')->update(['option_value' => $entryDate, 'updated_id' => $loginAdminId]);
                if ($save == 0) {
                    DB::rollBack();
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                }
            }
            DB::commit();
            // Uploaded formatted CSV file deleted.
            $this->fileDelete($commonconstants['raw_dir_name'] . '/aums_' . date($commonconstants['d_m_y_frmt']) . '.csv');
            // Redirect to Upload Monthly AUMs Value page.
            return redirect()->route('admin.aums.values.create')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['saved'])->with('title', $admin['success_ttl']);
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['saved'])->with('title', $admin['error_ttl']);
            }
        }
    }

    public static function fileDelete($filePath)
    {
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }
}
