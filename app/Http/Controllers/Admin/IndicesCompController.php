<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use App\Lib\Admin\App;
use App\Lib\App\Common;

use App\Models\IndicesComposition;
use App\Models\SettingsModel;

class IndicesCompController extends BaseController
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
        $sortBy = 'ic_id';
        $orderBy = 'DESC';

        $lstObj = new IndicesComposition;

        $lastSavedDate = SettingsModel::getSettingValue('idx_comp');

        $listDataAtrArr = Arr::except(App::getListDataAtr(), ['alert_css', 'edit_txt']);
        $moduleAtrArr = $lstObj->getModuleVars();

        $fltrDataArr = array();

        $fltrDataArr['indices_name'] = $request->has('fin') ? Common::ampSafeOnUrl($request->query('fin')) : '';
        $fltrDataArr['scrip_name'] = $request->has('fsn') ? Common::ampSafeOnUrl($request->query('fsn')) : '';
        $fltrDataArr['type'] = $request->has('fte') ? $request->query('fte') : '';
        $fltrDataArr['industry'] = $request->has('fiy') ? $request->query('fiy') : '';
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

        $sortbyArr = ['ic_id' => __('admin.insertion_txt'), 'indices_name' => __('admin.indices.name_txt'), 'scrip_name' => __('admin.scrip.label_txt'), 'type' => __('admin.type_txt'), 'industry' => __('admin.industry_txt'), 'percentage' => __('admin.percentage_txt')];
        $orderbyArr = ['asc' => 'ASC', 'desc' => 'DESC'];

        $showEntryArr = ['value' => __('admin.sw_entry.options.value'), 'text' => __('admin.sw_entry.options.text')];

        $roleRights = ['delete' => App::hasAccessToMethod($this->className, 'admin.indices-comp.delete')];

        return view('themes.backend.pages.indices.comp-list', compact('dataListModel', 'data', 'listDataAtrArr', 'moduleAtrArr', 'sortbyArr', 'orderbyArr', 'fltrDataArr', 'perPage', 'sortBy', 'orderBy', 'showEntryArr', 'lastSavedDate', 'roleRights'));
    }

    public function deletedata()
    {
        $loginAdminId = self::getLoggedInAdminId();
        $alertCss2 = Config('adminconstants.alert_css.2');
        $delErrMsg = __('message.error.delete');
        $errTtl = __('admin.error_ttl');
        try {
            DB::beginTransaction();
            $lastSavedDate = SettingsModel::getSettingValue('idx_comp');
            $delModel = IndicesComposition::where('entry_date', $lastSavedDate)->delete();
            if ($delModel > 0) {
                $fdMdl = IndicesComposition::orderBy('entry_date', 'desc')->first();
                if($fdMdl){
                    $entryDate = $fdMdl->entry_date;
                }
                else{
                    $entryDate = '2021-12-31';
                }
                $save = SettingsModel::where('option_key', 'idx_comp')->update(['option_value' => $entryDate, 'updated_id' => $loginAdminId]);
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
