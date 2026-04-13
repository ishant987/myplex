<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Carbon\Carbon;

use App\Lib\Core\Useful;

use App\Models\CurrencyDetail;
use App\Models\CurrencyMaster;
use App\Models\SettingsModel;

class DailyCurrenciesValueController extends BaseController
{
    public $className;

    public function __construct(){
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editvalues()
    {
        $dataListModel = CurrencyMaster::list(['status' => Config('commonconstants.status_val.1')], '', 'cm_id', 'ASC');
        foreach($dataListModel as $value) {
            if($value->currencycor == NULL)
                $value->entry_value = 'NA';
            else {
                $value->entry_value = CurrencyMaster::importCurrencyVal($value->currencycor->cor);
            }
        }

        $otherData = ['last_saved_cur' => SettingsModel::getSettingValue('cur')];
        
        $editDataAtrArr = ["title"=>__('admin.currency.edit_daily_value_txt'), "route" => 'currency.values.edit'];
        
        return view('themes.backend.pages.currency.daily-values', compact('editDataAtrArr', 'dataListModel', 'otherData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatevalues(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();

        $validator = Validator::make($request->all(), [
            'entry_date' => 'required',
            'entry_value' => 'required|array'
        ], [
            
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $nVal = $commonconstants['y_n_val'][2];
            $date = new Carbon();
            $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
            $lastSavedDate = SettingsModel::getSettingValue('cur');
            $entryDate = $request->input('entry_date');
            $diff = Useful::dateDiff($lastSavedDate, $entryDate);
            if ($diff <= 0) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['already_saved'].$entryDate.'.')->with('title', $admin['warning_ttl']);
            }
            elseif ($diff > 1) {
                return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['must_be_continuous'].$lastSavedDate.'.')->with('title', $admin['warning_ttl']);
            }
            $entryValue = $request->input('entry_value');
            foreach ($entryValue as $cmId => $value) {
                if($value != "NA" && $value != 0){
                    $store = [];
                    $store['cm_id'] = $cmId;
                    $store['entry_date'] = $entryDate;
                    $store['entry_value'] = $value;
                    $store['publish'] = $nVal;
                    $store['created_id'] = $loginAdminId;
                    $store['updated_id'] = $loginAdminId;
                    $store['created_at'] = $dateFormatted;
                    $store['updated_at'] = $dateFormatted;
                    $totInsrt = CurrencyDetail::insert($store);
                }
            }
            if ($totInsrt == 0) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            }
            else{
                $save = SettingsModel::where('option_key', 'cur')->update(['option_value' => $entryDate, 'updated_id' => $loginAdminId]);
                if($save == 0){
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                }
            }

            return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['saved'])->with('title', $admin['success_ttl']);
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['saved'])->with('title', $admin['error_ttl']);
            }
        }
    }
}
