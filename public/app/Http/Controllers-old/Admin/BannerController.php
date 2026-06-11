<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Admin\App;

use App\Models\BannerModel;

class BannerController extends BaseController
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
    public function index()
    {
        $dataListModel = BannerModel::orderBy('bnr_id', 'DESC')->get();
        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $fldsHide = __('banner.flds_hide');
        $boolFalse = Config('commonconstants.bool_false');

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.banner.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.banner.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.banner.delete')];

        return view('themes.backend.pages.banner.index', compact('dataListModel', 'listDataAtrArr', 'statusAtrArr', 'fldsHide', 'boolFalse', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groupArr = BannerModel::getBannerGroup();

        $coreObj = new App();
        $statusArr = $coreObj->getStatusLblTyp2Arr();
        $linkTargetArr = $coreObj->linkTargetAtr();

        $fldsHide = __('banner.flds_hide');
        $boolFalse = Config('commonconstants.bool_false');

        return view('themes.backend.pages.banner.createform', compact('groupArr', 'statusArr', 'linkTargetArr', 'fldsHide', 'boolFalse'));
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

        $validator = Validator::make($request->all(), [
            'media_id' => 'required',
            'bnr_group' => 'required',
            'link' => 'nullable|url',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'media_id.required' => __('admin.validation.required.featured_img'),
            'bnr_group.required' => __('banner.validation.required.bnr_group'),
            'link.url' => __('message.error.valid_url'),
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit', 'bnr_group_dd');

            $store = new BannerModel($input);

            $c_order = intval($input['c_order']);
            $store->c_order = $c_order > 0 ? $c_order : 0;

            $store->updated_id = $loginAdminId;

            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.data_saved'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.add'))->with('title', __('admin.success_ttl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bmObj = new BannerModel();
        $dataArr = $bmObj->find($id);
        $groupArr = $bmObj->getBannerGroup();

        $coreObj = new App();
        $statusArr = $coreObj->getStatusLblTyp2Arr();
        $linkTargetArr = $coreObj->linkTargetAtr();

        $fldsHide = __('banner.flds_hide');
        $boolFalse = Config('commonconstants.bool_false');

        $editDataAtrArr = ["title" => __('banner.edit_txt'), "route" => 'banner.edit'];

        return view('themes.backend.pages.banner.updateform', compact('dataArr', 'groupArr', 'statusArr', 'linkTargetArr', 'fldsHide', 'boolFalse', 'editDataAtrArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $validator = Validator::make($request->all(), [
            'media_id' => 'required',
            'bnr_group' => 'required',
            'link' => 'nullable|url',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'media_id.required' => __('admin.validation.required.featured_img'),
            'bnr_group.required' => __('banner.validation.required.bnr_group'),
            'link.url' => __('message.error.valid_url'),
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_method', '_token', 'submit', 'bnr_group_dd', 'files');

            $store = BannerModel::find($id);

            foreach ($input as $key => $value) {
                if ($key == 'c_order') {
                    $c_order = intval($value);
                    $store->$key = $c_order > 0 ? $c_order : 0;
                } else {
                    $store->$key = trim($value);
                }
            }
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
    }

    public function deleteData(Request $request)
    {
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                BannerModel::destroy($checkboxArr);
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }
}
