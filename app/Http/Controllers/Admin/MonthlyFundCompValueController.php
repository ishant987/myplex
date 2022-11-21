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

use App\Models\FundComposition;
use App\Models\FundMaster;
use App\Models\IndicesComposition;
use App\Models\Scrips;
use App\Models\SettingsModel;
use Illuminate\Support\Facades\DB;

class MonthlyFundCompValueController extends BaseController
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
        $otherData = ['last_saved_date' => SettingsModel::getSettingValue('fund_comp'), 'months_list' => Common::months(), 'year_list' => Common::years()];

        return view('themes.backend.pages.fund.compupload', compact('otherData', 'msg'));
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
        $errFileName = 'fund_comp_error_' . $today . '.csv';

        if ($msg == 'error' && $submit == 'download') {
            if (Storage::exists($upldDirName . '/' . $errFileName)) {
                $file = Core::getUploadedPath($upldDirName) . '/' . $errFileName;

                $headers = array(
                    'Content-Type: text/csv',
                );

                return Response::download($file, $errFileName, $headers)->deleteFileAfterSend(true);
            } else {
                return redirect()->route('admin.fund-comp.values.create')->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['error_file_not_exist'])->with('title', $admin['warning_ttl']);
            }
        } else if ($submit == 'upload') {
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
                $lastSavedDate = SettingsModel::getSettingValue('fund_comp');
                $diff = Useful::dateDiff($lastSavedDate, $prevMonthLastDate);
                // dd($diff);
                if ($diff < 0) {
                    return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['already_saved'] . $slctdMonthLastDate . '.')->with('title', $admin['warning_ttl']);
                } elseif ($diff > 1) {
                    return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['must_be_continuous'] . $lastSavedDate . '.')->with('title', $admin['warning_ttl']);
                }

                if ($request->hasFile('file_upload')) {
                    $today = date($commonconstants['d_m_y_frmt']);
                    $upldDirName = $commonconstants['raw_dir_name'];

                    $file      = $request->file('file_upload');
                    $extension = $file->getClientOriginalExtension();
                    $filename  = 'fund_comp_' . $today . '.' . $extension;
                    $path      = $file->storeAs($upldDirName, $filename);
                    if ($path) {
                        $nVal = $commonconstants['y_n_val'][2];
                        $date = new Carbon();
                        $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
                        $errFilePath = $upldDirName . '/' . $errFileName;
                        Storage::put($errFilePath, '');
                        $errFileColumns = array('FUND CODE', 'PERCENT', 'SCRIP', 'CATEGORY', 'INDUSTRY', 'ERROR MESSAGE');
                        $errFile = fopen(Core::getUploadedPath($errFilePath), 'w');
                        fputcsv($errFile, $errFileColumns);
                        $fileHandle = fopen(Core::getUploadedPath($path), "r");
                        $err = false;
                        $totInsrt = 0;
                        $row = 0;
                        $cashTxt = "cash";
                        $sovTxt = "sov";
                        $corpDebtTxt = "corporatedebt";
                        $usfObj = new Useful;
                        $insrtArr = $unqFndCdArr = [];
                        while (!feof($fileHandle)) {
                            $srcDataRow = fgetcsv($fileHandle, 1024, ',');
                            if ($row > 0) {
                                // dd($srcDataRow);
                                if (!empty($srcDataRow)) {
                                    $sdFundCode = is_numeric($srcDataRow[0])? '0'.$srcDataRow[0] : $srcDataRow[0];
                                    $sdScrip = $srcDataRow[2];
                                    $sdCategory = $srcDataRow[3];
                                    $sdIndustry = $srcDataRow[4];
                                    if ($sdFundCode != '' && $sdScrip != '' && $sdCategory != '') {
                                        $sdPercentage = $srcDataRow[1];
                                        $rowInsrt = false;
                                        $fundMdl = FundMaster::getData(['fund_code' => $sdFundCode, 'status' => $commonconstants['status_val'][1]], ['indices_name']);
                                        // dd($fundMdl);
                                        if (!$fundMdl) {
                                            fputcsv($errFile, array($sdFundCode, $sdPercentage, $sdScrip, $sdCategory, $sdIndustry, 'The fund code "' . $sdFundCode . '" is not found.'));
                                            $err = true;
                                        } else {
                                            $scrpMdl = Scrips::getData(['scrip_name_like' => trim($sdScrip, chr(0xC2) . chr(0xA0))], ['type', 'industry', 'actual_scrip']);
                                            // dd($scrpMdl);
                                            if (!$scrpMdl) {
                                                fputcsv($errFile, array($sdFundCode, $sdPercentage, $sdScrip, $sdCategory, $sdIndustry, 'The fund code "' . $sdFundCode . '" in actual scrip name "' . $sdScrip . '" is not found.'));
                                                $err = true;
                                            } else {
                                                $fcMdl = FundComposition::getData(['indices_name' => $fundMdl->indices_name, 'scrip_name' => $scrpMdl->actual_scrip, 'entry_date' => $slctdMonthLastDate], ['fc_id']);
                                                // dd($fcMdl);
                                                if ($fcMdl) {
                                                    fputcsv($errFile, array($sdFundCode, $sdPercentage, $sdScrip, $sdCategory, $sdIndustry, 'Duplicate fund code "' . $sdFundCode . '" in actual scrip name (' . $scrpMdl->actual_scrip . ') exist for index "' . $fundMdl->indices_name . '".'));
                                                    $err = true;
                                                } else {
                                                    $scripName = $scrpMdl->actual_scrip;
                                                    $idcCmpMdl = IndicesComposition::getData(['entry_date' => $slctdMonthLastDate, 'indices_name' => $fundMdl->indices_name, 'scrip_name' => $scrpMdl->actual_scrip], ['percentage']);
                                                    // dd($idcCmpMdl);
                                                    $indcPercentage = $idcCmpMdl ? $idcCmpMdl->percentage : 0;
                                                    $industry = $sdIndustry;
                                                    if (strtolower($sdCategory) == 'equity') {
                                                        $industry = $scrpMdl->industry;
                                                    }
                                                    $nwSdScrip = $usfObj->removeSpaceMakeLower($sdScrip);
                                                    $nwSdCategory = $usfObj->removeSpaceMakeLower($sdCategory);
                                                    $nwSdIndustry = $usfObj->removeSpaceMakeLower($sdIndustry);
                                                    if( $nwSdScrip == $cashTxt || $nwSdScrip == $sovTxt || $nwSdScrip == $corpDebtTxt ){
                                                        $scripName = $sdScrip;
                                                    }
                                                    // 
                                                    if( ($nwSdScrip == $cashTxt && $nwSdCategory == $cashTxt && $nwSdIndustry == $cashTxt) || ($nwSdScrip == $corpDebtTxt && $nwSdCategory == $corpDebtTxt && $nwSdIndustry == $corpDebtTxt) || ($nwSdScrip == $sovTxt && $nwSdCategory == $sovTxt && $nwSdIndustry == $sovTxt) ){
                                                        foreach ($insrtArr as $key => $value) {
                                                            if( $value['fund_code'] == $sdFundCode && ($value['scrip_name'] == $sdScrip) && $value['industry'] == $sdIndustry && $value['category'] == $sdCategory ){
                                                                $insrtArr[$key]['content_per'] = $value['content_per']+$sdPercentage;
                                                                $rowInsrt = false;
                                                            }else {
                                                                $rowInsrt = true; 
                                                            }
                                                        }
                                                    }
                                                    else{
                                                        $rowInsrt = true;
                                                    }
                                                    // Final
                                                    if( $rowInsrt == true ){
                                                        array_push($insrtArr, ['fund_code' =>$sdFundCode,'scrip_name' =>$sdScrip,'act_scrip_name' =>$scripName,'industry' =>$sdIndustry,'act_industry' =>$industry,'category' =>$sdCategory,'content_per' =>$sdPercentage,'indices_per' =>$indcPercentage ]); 
                                                    }
                                                }
                                            }
                                        }
                                        if(!in_array($sdFundCode, $unqFndCdArr)){
                                            array_push($unqFndCdArr, $sdFundCode); 
                                        }
                                    }
                                }
                            }
                            $row++;
                        }
                        // dd($insrtArr);
                        $fundSumArr = [];
                        foreach ($unqFndCdArr as $indx => $fundCode){
                            $fundSumArr[$indx]['code'] = $fundCode;
                            $fundSumArr[$indx]['sum'] = 0;
                            foreach ($insrtArr as $key => $value) {
                                if( $value['fund_code'] == $fundCode ){
                                    $fundSumArr[$indx]['sum'] = $value['content_per']+$fundSumArr[$indx]['sum'];
                                }
                            }
                        }
                        $fundErrArr = [];
                        foreach ($fundSumArr as $key => $value) {
                            if($value['sum'] > 102 && $value['sum'] < 95){
                                array_push($fundErrArr, $value['code']); 
                                // Error data log.
                                fputcsv($errFile, array($value['code'], '', '', '', '', 'The total sum of fund code "' . $value['code'] . '" not beetween 95 and 102.'));
                            }
                        }
                        fclose($errFile);
                        // dd($insrtArr);
                        DB::beginTransaction();
                        foreach ($insrtArr as $key => $value) {
                            if(!in_array($value['fund_code'], $fundErrArr)){
                                $store = [];
                                $store['entry_date'] = $slctdMonthLastDate;
                                $store['fund_code'] = $value['fund_code'];
                                $store['scrip_name'] = $value['act_scrip_name'];
                                $store['industry'] = $value['act_industry'];
                                $store['category'] = $value['category'];
                                $store['content_per'] = $value['content_per'];
                                $store['indices_per'] = $value['indices_per'];
                                $store['publish'] = $nVal;
                                $store['created_id'] = $loginAdminId;
                                $store['created_at'] = $dateFormatted;
                                // dd($store);
                                $totInsrt = FundComposition::insert($store);
                            }
                        }
                        if ($totInsrt == 0) {
                            DB::rollBack();
                            return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                        } else {
                            $save = SettingsModel::where('option_key', 'fund_comp')->update(['option_value' => $slctdMonthLastDate, 'updated_id' => $loginAdminId]);
                            if ($save == 0) {
                                DB::rollBack();
                                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                            }
                        }
                        DB::commit();
                        // Uploaded CSV file deleted.
                        $this->fileDelete($path);
                        if ($err == true) {
                            return redirect()->route('admin.fund-comp.values.create', 'error')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['saved_download_file'])->with('title', $admin['success_ttl']);
                        }
                        return redirect()->route('admin.fund-comp.values.create')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['saved'])->with('title', $admin['success_ttl']);
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
