<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Admin\App;

use App\Models\FAQModel;
use App\Models\CommonCategory;

class FAQController extends BaseController
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
        $commonconstants = Config('commonconstants');

        $filterArr = [];
        $dataListModel = FAQModel::faqList($filterArr);

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $fldsHide = __('faq.flds_hide');
        $boolFalse = $commonconstants['bool_false'];

        $moduleAtrArr = ["view_txt" => __('admin.view_txt'), "target" => $commonconstants['target_opt1']];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.faq.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.faq.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.faq.delete')];

        return view('themes.backend.pages.faq.index', compact('dataListModel', 'listDataAtrArr', 'moduleAtrArr', 'statusAtrArr', 'fldsHide', 'boolFalse', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $commonconstants = Config('commonconstants');

        $type = ['type' => $commonconstants['category_type']['value']['1']];
        $categoryArr = CommonCategory::getCategoryList($type);

        $coreObj = new App();
        $statusArr = $coreObj->getStatusLblTyp2Arr();

        $fldsHide = __('faq.flds_hide');
        $boolFalse = $commonconstants['bool_false'];

        return view('themes.backend.pages.faq.createform', compact('categoryArr', 'statusArr', 'fldsHide', 'boolFalse'));
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

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'cc_id' => 'required|integer',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'cc_id.required' => __('validation.custom.required.category'),
            'cc_id.integer' => __('validation.custom.integer.category'),
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit');

            $store = new FAQModel($input);

            $fldsHide = __('faq.flds_hide');
            $boolFalse = $commonconstants['bool_false'];

            if ($fldsHide['category'] == $boolFalse) {
                $cc_id = intval($input['cc_id']);
                $store->cc_id = $cc_id > 0 ? $cc_id : 0;
            }

            if ($fldsHide['c_order'] == $boolFalse) {
                $c_order = intval($input['c_order']);
                $store->c_order = $c_order > 0 ? $c_order : 0;
            }

            $store->updated_id = $loginAdminId;

            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
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
        $dataArr = FAQModel::find($id);

        $commonconstants = Config('commonconstants');

        $type = ['type' => $commonconstants['category_type']['value']['1']];
        $categoryArr = CommonCategory::getCategoryList($type);

        $coreObj = new App();
        $statusArr = $coreObj->getStatusLblTyp2Arr();

        $fldsHide = __('faq.flds_hide');
        $boolFalse = $commonconstants['bool_false'];

        $editDataAtrArr = ["title" => __('faq.edit_txt'), "route" => 'faq.edit'];

        return view('themes.backend.pages.faq.updateform', compact('dataArr', 'categoryArr', 'statusArr', 'fldsHide', 'boolFalse', 'editDataAtrArr'));
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

        $commonconstants = Config('commonconstants');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'cc_id' => 'required|integer',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'cc_id.required' => __('validation.custom.required.category'),
            'cc_id.integer' => __('validation.custom.integer.category'),
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $store = FAQModel::find($id);

            $input = $request->except('_method', '_token', 'submit');

            foreach ($input as $key => $value) {
                if ($key == 'c_order') {
                    $c_order = intval($input['c_order']);
                    $store->c_order = $c_order > 0 ? $c_order : 0;
                } elseif ($key == 'cc_id') {
                    $cc_id = intval($input['cc_id']);
                    $store->cc_id = $cc_id > 0 ? $cc_id : 0;
                } else {
                    $store->$key = trim($value);
                }
            }

            $store->updated_id = $loginAdminId;

            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
    }

    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                FAQModel::whereIn('faq_id', $checkboxArr)->delete();
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }
}
