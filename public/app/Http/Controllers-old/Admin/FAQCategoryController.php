<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Lib\Admin\App;
use App\Lib\App\Common;

use App\Models\CommonCategory;

class FAQCategoryController extends BaseController
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

        $filterArr = ['type' => $commonconstants['category_type']['value']['1']];
        $dataListModel = CommonCategory::listWithParent($filterArr);

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $fldsHide = __('admin.common_category.flds_hide.f');
        $boolFalse = $commonconstants['bool_false'];

        $othrsAtrArr = ["breadcrumb" => 'faqcategory.index', "title" => __('admin.common_category.all_txt'), "add_route" => 'admin.faq-category.create', "edit_route" => 'admin.faq-category.edit', "delete_route" => 'admin.faq-category.delete'];

        // $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.faq-category.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.faq-category.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.faq-category.delete')];
        $roleRights = ['add' => false, 'edit' => App::hasAccessToMethod($this->className, 'admin.faq-category.edit'), 'delete' => false];

        return view('themes.backend.pages.commoncategory.index', compact('dataListModel', 'listDataAtrArr', 'othrsAtrArr', 'statusAtrArr', 'fldsHide', 'boolFalse', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $commonconstants = Config('commonconstants');
        $type = $commonconstants['category_type']['value']['1'];

        $parentCatArr = CommonCategory::getCategoryList($type);

        $coreObj = new App();
        $statusArr = $coreObj->getStatusLblTyp2Arr();

        $fldsHide = __('admin.common_category.flds_hide.f');
        $boolFalse = $commonconstants['bool_false'];

        $othrsAtrArr = ["breadcrumb" => 'faqcategory.create', "title" => __('admin.common_category.add_txt'), "store_route" => 'admin.faq-category.store'];

        return view('themes.backend.pages.commoncategory.createform', compact('parentCatArr', 'othrsAtrArr', 'statusArr', 'fldsHide', 'boolFalse'));
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
        $type = $commonconstants['category_type']['value']['1'];

        $input = $request->validate([
            'title' => 'required',
            // 'slug' => 'required',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        try {
            $input = $request->except('_token', 'submit');

            $store = new CommonCategory($input);

            $reqSlug = isset($input['slug']) ? $input['slug'] : $input['title'];
            $store->slug = Common::generateSlug($reqSlug, 'common_category', '', '', "AND type='" . $type . "'");

            $fldsHide = __('admin.common_category.flds_hide.f');
            $boolFalse = $commonconstants['bool_false'];

            if ($fldsHide['parent'] == $boolFalse) {
                $parent = intval($input['parent']);
                $store->parent = $parent > 0 ? $parent : 0;
            }

            if ($fldsHide['image'] == $boolFalse) {
                $media_id = intval($input['media_id']);
                $store->media_id = $media_id > 0 ? $media_id : 0;
            }

            if ($fldsHide['c_order'] == $boolFalse) {
                $c_order = intval($input['c_order']);
                $store->c_order = $c_order > 0 ? $c_order : 0;
            }

            $store->type = $type;
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
        $commonconstants = Config('commonconstants');
        $type = $commonconstants['category_type']['value']['1'];

        $dataArr = CommonCategory::where('type', '=', $type)->find($id);
        $parentCatArr = CommonCategory::getCategoryList($type);

        $coreObj = new App();
        $statusArr = $coreObj->getStatusLblTyp2Arr();

        $fldsHide = __('admin.common_category.flds_hide.f');
        $boolFalse = $commonconstants['bool_false'];

        $editDataAtrArr = ["breadcrumb" => 'faqcategory.edit', "title" => __('admin.common_category.edit_txt'), "update_route" => 'admin.faq-category.update'];

        return view('themes.backend.pages.commoncategory.updateform', compact('dataArr', 'parentCatArr', 'statusArr', 'fldsHide', 'boolFalse', 'editDataAtrArr'));
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
        $type = $commonconstants['category_type']['value']['1'];

        $input = $request->validate([
            'title' => 'required',
            // 'slug' => 'required',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        try {
            $input = $request->except('_method', '_token', 'submit');

            $store = CommonCategory::where('type', '=', $type)->find($id);

            foreach ($input as $key => $value) {
                if ($key == 'parent') {
                    $parent = intval($input['parent']);
                    $store->parent = $parent > 0 ? $parent : 0;
                } else if ($key == 'media_id') {
                    $media_id = intval($input['media_id']);
                    $store->$key = $media_id > 0 ? $media_id : 0;
                } else if ($key == 'c_order') {
                    $c_order = intval($value);
                    $store->$key = $c_order > 0 ? $c_order : 0;
                } else {
                    $store->$key = trim($value);
                }
            }
            $reqSlug = (isset($store->slug) && $store->slug) ? $store->slug : $store->title;
            $store->slug = Common::generateSlug($reqSlug, 'common_category', '', 'cc_id !=' . $id, "AND type='" . $type . "'");
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

    public function deleteData(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        $type = $commonconstants['category_type']['value']['1'];
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                CommonCategory::whereIn('cc_id', $checkboxArr)->where('type', '=', $type)->delete();
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
