<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Admin\App;
use App\Lib\App\Common;

use App\Models\AskExpertTopic;
use App\Models\User;
use App\Models\ModuleUserRelModel;

class AskExpertTopicController extends BaseController
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

        $dataListModel = AskExpertTopic::list();

        $coreObj = new App();

        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $fldsHide = __('askexpert.topic.flds_hide');
        $boolFalse = $commonconstants['bool_false'];

        $moduleAtrArr = ["view_txt" => __('admin.view_txt'), "target" => $commonconstants['target_opt1'], "cu_by_val" => $commonconstants['cu_by_val'], "cu_by_txt" => __('common.cu_by_txt')];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.topic.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.topic.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.topic.delete')];

        return view('themes.backend.pages.topic.index', compact('dataListModel', 'listDataAtrArr', 'moduleAtrArr', 'statusAtrArr', 'fldsHide', 'boolFalse', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $commonconstants = Config('commonconstants');

        $parentDataArr = AskExpertTopic::getParentDataList();

        $dataList = User::usersListByGroup($commonconstants['expert_group_id']);

        $statusArr = App::getStatusLblTyp2Arr();

        $fldsHide = __('askexpert.topic.flds_hide');
        $boolFalse = $commonconstants['bool_false'];

        return view('themes.backend.pages.topic.createform', compact('statusArr', 'parentDataArr', 'dataList', 'fldsHide', 'boolFalse'));
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
            'slug' => 'required',
            'assigned_to' => 'nullable|array|min:1',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'assigned_to.required' => __('admin.validation.required.to'),
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $fldsHide = __('askexpert.topic.flds_hide');
            $boolFalse = $commonconstants['bool_false'];

            $input = $request->except('_token', 'submit', 'assigned_from', 'assigned_to', 'q');

            $store = new AskExpertTopic($input);

            $reqSlug = isset($input['slug']) ? $input['slug'] : $input['title'];
            $store->slug = Common::generateSlug($reqSlug, 'ask_expert_topic');

            $parent = intval($input['parent']);
            $store->parent = $parent > 0 ? $parent : 0;

            if ($fldsHide['image'] == $boolFalse) {
                $media_id = intval($input['media_id']);
                $store->media_id = $media_id > 0 ? $media_id : 0;
            }

            if ($fldsHide['c_order'] == $boolFalse) {
                $c_order = intval($input['c_order']);
                $store->c_order = $c_order > 0 ? $c_order : 0;
            }

            $store->created_medium = $commonconstants['medium']['value']['3'];
            $store->created_by = $commonconstants['cu_by_val']['1'];
            $store->created_id = $loginAdminId;
            $store->updated_at = $commonconstants['null'];
            if ($store->save()) {
                $dataId = $store->aet_id;

                $usersArr = $request->input('assigned_to');
                if (!empty($usersArr)) {
                    $store2 = [];
                    foreach ($usersArr as $key => $value) {
                        $store2[$key] = ['u_id' => $value, 'type' => $commonconstants['module_user_rel_type']['value']['0'], 'data_id' => $dataId, 'updated_id' => $loginAdminId];
                    }
                    $totInsrt = ModuleUserRelModel::insert($store2);
                    if ($totInsrt == 0) {
                        return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.data_saved'))->with('title', __('admin.error_ttl'));
                    }
                }
            }
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
        $dtObj = new AskExpertTopic;

        $dataArr = $dtObj->find($id);

        $commonconstants = Config('commonconstants');

        $parentDataArr = $dtObj->getParentDataList();

        $dataList = User::usersListByGroup($commonconstants['expert_group_id']);

        $toObj = ModuleUserRelModel::getModuleUserRelList(['type' => $commonconstants['module_user_rel_type']['value']['0'], 'data_id' => $id]);

        $statusArr = App::getStatusLblTyp2Arr();

        $fldsHide = __('askexpert.topic.flds_hide');
        $boolFalse = $commonconstants['bool_false'];

        $editDataAtrArr = ["title" => __('askexpert.topic.edit_txt'), "route" => 'topic.edit'];

        return view('themes.backend.pages.topic.updateform', compact('dataArr', 'parentDataArr', 'dataList', 'toObj', 'statusArr', 'fldsHide', 'boolFalse', 'editDataAtrArr'));
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
            'slug' => 'required',
            'assigned_to' => 'nullable|array|min:1',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'assigned_to.required' => __('admin.validation.required.to'),
            'c_order.integer' => __('admin.validation.c_order.integer')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $store = AskExpertTopic::find($id);

            $input = $request->except('_method', '_token', 'submit', 'assigned_from', 'assigned_to', 'q');

            foreach ($input as $key => $value) {
                if ($key == 'media_id') {
                    $media_id = intval($input['media_id']);
                    $store->media_id = $media_id > 0 ? $media_id : 0;
                } elseif ($key == 'c_order') {
                    $c_order = intval($input['c_order']);
                    $store->c_order = $c_order > 0 ? $c_order : 0;
                } else {
                    $store->$key = trim($value);
                }
            }

            $reqSlug = isset($input['slug']) ? $input['slug'] : $input['title'];
            $store->slug = Common::generateSlug($reqSlug, 'ask_expert_topic', '', 'aet_id !=' . $id);

            $parent = intval($input['parent']);
            $store->parent = $parent > 0 ? $parent : 0;

            $store->updated_id = $loginAdminId;

            if ($store->save()) {
                $userArr = $request->input('assigned_to');
                if (!empty($userArr)) {
                    $relType = $commonconstants['module_user_rel_type']['value']['0'];

                    ModuleUserRelModel::where(['type' => $relType, 'data_id' => $id])->whereNotIn('u_id', $userArr)->delete();

                    $store2 = [];
                    foreach ($userArr as $key => $value) {
                        $rowDataObj = ModuleUserRelModel::getModuleUserRelData(['type' => $relType, 'data_id' => $id, 'u_id' => $value], ['mur_id', 'deleted_at']);
                        if ($rowDataObj) {
                            if ($rowDataObj->deleted_at) {
                                $rowDataObj->updated_id = $loginAdminId;
                                $rowDataObj->deleted_at = NULL;
                                $totAfctd = $rowDataObj->save();
                            } else {
                                $store2 = ['updated_id' => $loginAdminId];
                                $totAfctd = ModuleUserRelModel::where(['mur_id' => $rowDataObj->mur_id, 'u_id' => $value, 'type' => $relType, 'data_id' => $id])->update($store2);
                            }
                        } else {
                            $store2 = ['u_id' => $value, 'type' => $relType, 'data_id' => $id, 'updated_id' => $loginAdminId];
                            $totAfctd = ModuleUserRelModel::insert($store2);
                        }
                    }

                    if ($totAfctd == 0) {
                        return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
                    }
                }
            }
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
                \DB::beginTransaction();

                ModuleUserRelModel::whereIn('data_id', $checkboxArr)->where('type', '=', $commonconstants['module_user_rel_type']['value']['0'])->forceDelete();

                $delModel = AskExpertTopic::whereIn('aet_id', $checkboxArr)->delete();
                if ($delModel > 0) {
                    \DB::commit();
                } else {
                    \DB::rollBack();
                }
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
