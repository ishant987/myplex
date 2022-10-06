<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;
use Carbon\Carbon;
use Response;

use App\Lib\App\Common;
use App\Lib\Core\Core;
use App\Lib\Core\Useful;

use App\Models\McapEps;
use App\Models\Scrips;
use App\Models\SettingsModel;
use Illuminate\Support\Facades\DB;

class MonthlyMcapEpsValueController extends BaseController
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
    public function create($msg = '')
    {
        $otherData = ['last_saved_date' => SettingsModel::getSettingValue('mcap'), 'months_list' => Common::months(), 'year_list' => Common::years()];

        return view('themes.backend.pages.mcapeps.upload', compact('otherData', 'msg'));
    }

    public function store(Request $request, $msg = '')
    {
        $submit = $request->submit;

        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $today = date($commonconstants['d_m_y_frmt']);
        $upldDirName = $commonconstants['raw_dir_name'];
        $errFileName = 'mcap_eps_error_' . $today . '.csv';

        if($msg == 'error' && $submit == 'download'){
            if (Storage::exists($upldDirName.'/'.$errFileName)) {
                $file= Core::getUploadedPath($upldDirName).'/'.$errFileName;

                $headers = array(
                    'Content-Type: text/csv',
                );

                return Response::download($file, $errFileName, $headers)->deleteFileAfterSend(true);
            }
            else{
                return redirect()->route('admin.mcap-eps.values.create')->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['error_file_not_exist'])->with('title', $admin['warning_ttl']);
            }
        }
        else if($submit == 'upload'){
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
                $slctdMonthLastDate = Common::getLastDateOfMonth($entry_month, $entry_year);
                $prevMonthLastDate = Common::getPreviousMonthLastDate($entry_month, $entry_year);
                $lastSavedDate = SettingsModel::getSettingValue('mcap');
                $diff = Useful::dateDiff($lastSavedDate, $prevMonthLastDate);
                // dd($diff);
                if ($diff < 0) {
                    return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['already_saved'] . $slctdMonthLastDate . '.')->with('title', $admin['warning_ttl']);
                } elseif ($diff > 1) {
                    return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['must_be_continuous'] . $lastSavedDate . '.')->with('title', $admin['warning_ttl']);
                }

                if ($request->hasFile('file_upload')) {
                    $file      = $request->file('file_upload');
                    $extension = $file->getClientOriginalExtension();
                    $filename  = 'mcap_eps_' . $today . '.' . $extension;
                    $path      = $file->storeAs($upldDirName, $filename);
                    if ($path) {
                        $nVal = $commonconstants['y_n_val'][2];
                        $date = new Carbon();
                        $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
                        $errFilePath = $upldDirName .'/'.$errFileName;
                        Storage::put($errFilePath, '');
                        $errFileColumns = array('Company Name', 'Mcap', 'EPS *', 'P/E', 'Error Message');
                        $errFile = fopen(Core::getUploadedPath($errFilePath), 'w');
                        fputcsv($errFile, $errFileColumns);
                        $fileHandle = fopen(Core::getUploadedPath($path), "r");
                        $err = false;
                        $totInsrt = 0;
                        $row = 0;
                        DB::beginTransaction();
                        while (!feof($fileHandle)) {
                            $srcDataRow = fgetcsv($fileHandle, 1024, ',');
                            if ($row > 0) {
                                // dd($srcDataRow);
                                if (!empty($srcDataRow)) {
                                    $sdScrip = $srcDataRow[0];
                                    $sdMcap = $srcDataRow[1];
                                    $sdEps = $srcDataRow[2];
                                    $sdPe = $srcDataRow[3];
                                    if ($sdScrip != '') {
                                        $scrpMdl = Scrips::getData(['scrip_name_like' => trim($sdScrip, chr(0xC2) . chr(0xA0))], ['actual_scrip']);
                                        // dd($scrpMdl);
                                        if (!$scrpMdl) {
                                            fputcsv($errFile, array($sdScrip, $sdMcap, $sdEps, $sdPe, 'The company name "' . $sdScrip . '" is not found under your Scrip module.'));
                                            $err = true;
                                        } else {
                                            $meMdl = McapEps::getData(['scrip_name' => $scrpMdl->actual_scrip, 'entry_date' => $slctdMonthLastDate], ['me_id']);
                                            // dd($meMdl);
                                            if ($meMdl) {
                                                fputcsv($errFile, array($sdScrip, $sdMcap, $sdEps, $sdPe, 'Duplicate actual scrip name ('.$scrpMdl->actual_scrip.') exist for company name "' . $sdScrip . '".'));
                                                $err = true;
                                            } else {
                                                $store = [];
                                                $store['scrip_name'] = $scrpMdl->actual_scrip;
                                                $store['entry_date'] = $slctdMonthLastDate;
                                                $store['market_cap'] = is_numeric($sdMcap) ? $sdMcap : NULL;
                                                $store['eps'] = is_numeric($sdEps) ? $sdEps : NULL;
                                                $store['pe'] = is_numeric($sdPe) ? $sdPe : NULL;
                                                $store['publish'] = $nVal;
                                                $store['created_id'] = $loginAdminId;
                                                $store['created_at'] = $dateFormatted;
                                                $totInsrt = McapEps::insert($store);
                                            }
                                        }
                                    }
                                }
                            }
                            $row++;
                        }
                        fclose($errFile);
                        if ($totInsrt == 0) {
                            DB::rollBack();
                            return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                        } else {
                            $save = SettingsModel::where('option_key', 'mcap')->update(['option_value' => $slctdMonthLastDate, 'updated_id' => $loginAdminId]);
                            if ($save == 0) {
                                DB::rollBack();
                                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                            }
                        }
                        DB::commit();
                        // Uploaded CSV file deleted.
                        $this->fileDelete($path);
                        if ($err == true) {
                            return redirect()->route('admin.mcap-eps.values.create', 'error')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['saved_download_file'])->with('title', $admin['success_ttl']);
                        }
                        return redirect()->route('admin.mcap-eps.values.create')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['saved'])->with('title', $admin['success_ttl']);
                    } else {
                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['file_upload'])->with('title', $admin['error_ttl']);
                    }
                }
            } catch (QueryException $exception) {
                if (isset($path) && $path) {
                    $this->fileDelete($path);
                }
                if (isset($errFilePath) && $errFilePath) {
                    $this->fileDelete($errFilePath);
                }

                if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
                } else {
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                }
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
