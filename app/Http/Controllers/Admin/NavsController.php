<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use App\Lib\Admin\App;

use App\Models\FundDetail;
use App\Models\SettingsModel;

class NavsController extends BaseController
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
        $data = $request->all();
        $perPage = Config('commonconstants.pagination_no');
        $sortBy = 'fd_id';
        $orderBy = 'DESC';

        $lstObj = new FundDetail;

        $lastSavedDate = SettingsModel::getSettingValue('nav');

        $listDataAtrArr = Arr::except(App::getListDataAtr(), ['alert_css', 'edit_txt']);
        $moduleAtrArr = $lstObj->getModuleVars();

        $fltrDataArr = array();

        $fltrDataArr['fund_code'] = $request->has('ffc') ? $request->query('ffc') : '';
        $fltrDataArr['entry_date'] = $request->has('fed') ? $request->query('fed') : $lastSavedDate;

        if ($request->has('ppage')) {
            $perPage = $request->query('ppage');
        }

        if ($request->has('oby')) {
            $orderBy = $request->query('oby');
        }
        if ($request->has('sby')) {
            $sortBy = $request->query('sby');
        }

        $dataListModel = $lstObj::search($fltrDataArr)->orderBy($sortBy, $orderBy)->paginate($perPage);

        $sortbyArr = ['fd_id' => __('admin.insertion_txt'), 'fund_code' => __('admin.fund.code_txt'), 'closing_nav' => __('admin.value_txt'), 'percentage_change' => __('admin.percentage_change_txt')];
        $orderbyArr = ['asc' => 'ASC', 'desc' => 'DESC'];

        $showEntryArr = ['value' => __('admin.sw_entry.options.value'), 'text' => __('admin.sw_entry.options.text')];

        $roleRights = ['delete' => App::hasAccessToMethod($this->className, 'admin.navs.delete')];

        return view('themes.backend.pages.fund.nav-list', compact('dataListModel', 'data', 'listDataAtrArr', 'moduleAtrArr', 'sortbyArr', 'orderbyArr', 'fltrDataArr', 'perPage', 'sortBy', 'orderBy', 'showEntryArr', 'lastSavedDate', 'roleRights'));
    }

    public function deletedata()
    {
        $loginAdminId = self::getLoggedInAdminId();
        $alertCss2 = Config('adminconstants.alert_css.2');
        $delErrMsg = __('message.error.delete');
        $errTtl = __('admin.error_ttl');
        try {
            DB::beginTransaction();
            $lastSavedDate = SettingsModel::getSettingValue('nav');
            $delModel = FundDetail::where('entry_date', $lastSavedDate)->delete();
            if ($delModel > 0) {
                $fdMdl = FundDetail::orderBy('entry_date', 'desc')->first();
                if($fdMdl){
                    $entryDate = $fdMdl->entry_date;
                }
                else{
                    $entryDate = '2021-12-31';
                }
                $save = SettingsModel::where('option_key', 'nav')->update(['option_value' => $entryDate, 'updated_id' => $loginAdminId]);
                if ($save == 0) {
                    DB::rollBack();
                    return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
                }
            } else {
                DB::rollBack();
                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
            }
            DB::commit();
            return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', $alertCss2)->with('message', $exception->getMessage())->with('title', $errTtl)->withInput();
            } else {
                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
            }
        }
    }
}
