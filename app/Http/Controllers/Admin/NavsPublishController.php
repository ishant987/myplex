<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Carbon\Carbon;

use App\Lib\Core\Useful;

use App\Models\FundDetail;
use App\Models\SettingsModel;
use App\Models\AdminModel;

class NavsPublishController extends BaseController
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
        $otherData = ['values_published_date' => SettingsModel::getSettingValue('nav_publish'), 'values_ready_date' => FundDetail::getPublishReadyDate()];
        return view('themes.backend.pages.fund.nav-publish', compact('otherData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $input = $request->all();

        $validator = Validator::make($input, [
            'values_ready' => 'required',
            'values_published' => 'required',
            'secret' => 'required|min:2',
        ], [
            'values_ready.required' => $message['error']['values_ready'],
            'values_published.required' => $message['error']['values_published'],
        ]);

        $validator->after(function () use ($input, $validator, $loginAdminId) {
            if ($input['secret']) {
                $result = AdminModel::where(function ($query) use ($loginAdminId) {
                    $query->where('admin_id', $loginAdminId)->where(function ($query) {
                        $query->whereNull('secret');
                    });
                })->first();
                if ($result) {
                    $validator->errors()->add('secret', __('auth.error.secret_not_given'));
                }
            }
        });


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $secret = $request->input('secret');
            $adminId = AdminModel::verifySecret($loginAdminId, $secret);
            if($adminId == 0){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', __('auth.error.secret'))->with('title', $admin['error_ttl']);
            }
            else{
                $mdlObj = new FundDetail;
                $valuesReadyDate = $mdlObj->getPublishReadyDate();
                $valuePublishedDate = SettingsModel::getSettingValue('nav_publish');
                $valuesReady = $request->input('values_ready');
                $valuesPublished = $request->input('values_published');
                if( ($valuesReadyDate != $valuesReady) && ($valuePublishedDate != $valuesPublished) ){
                    return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['values_published'])->with('title', $admin['warning_ttl']);
                }
                else{
                    $diff = Useful::dateDiff($valuesPublished, $valuesReady);
                    if ($diff <= 0) {
                        return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['already_published'] . $valuesReady . '.')->with('title', $admin['warning_ttl']);
                    } elseif ($diff > 1) {
                        return back()->with('alert', $adminconstants['alert_css'][3])->with('message', $message['warning']['must_be_continuous_published'] . $valuePublishedDate . '.')->with('title', $admin['warning_ttl']);
                    }
                    $date = new Carbon();
                    $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
                    $store = [];
                    $store['publish'] = $commonconstants['y_n_val'][1];
                    $store['updated_id'] = $loginAdminId;
                    $store['updated_at'] = $dateFormatted;
                    $totUpdt = FundDetail::where('entry_date', $valuesReady)->update($store);
                    if ($totUpdt == 0) {
                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_publish'])->with('title', $admin['error_ttl']);
                    } else {
                        $save = SettingsModel::where('option_key', 'nav_publish')->update(['option_value' => $valuesReady, 'updated_id' => $loginAdminId]);
                        if ($save == 0) {
                            return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_publish'])->with('title', $admin['error_ttl']);
                        }
                    }
                    return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['data_publish'])->with('title', $admin['success_ttl']);
                }
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_publish'])->with('title', $admin['error_ttl']);
            }
        }
    }
}
