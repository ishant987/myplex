<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Illuminate\Support\Arr;

use App\Lib\Admin\App;

use App\Models\AuthroleModel;
use App\Models\ModuleModel;
use App\Models\RoleModuleMethodRightsModel;

class AdminroleController extends BaseController
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
        $dataListModel = AuthroleModel::orderBy('role_id', 'DESC')->get();

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();

        $othrDataAtrArr = ["login_admin_id" => self::getLoggedInAdminId(), "def_super_adminrole_id" => Config('commonconstants.def_super_adminrole_id'), "view_txt" => __('admin.view_txt')];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.adminrole.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.adminrole.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deleteuserrole')];

        return view('themes.backend.pages.adminrole.index', compact('dataListModel', 'listDataAtrArr', 'othrDataAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = ModuleModel::with('modulemethods')
            ->where('module_id', '!=', 44)
            ->where('status', '=', Config('commonconstants.status_val.1'))
            ->orderBy('title', 'ASC')
            ->get();
        $maxTdCnt = 0;
        foreach ($modules as $key => $module) {
            if (!empty($module->getModuleMethods()) && $maxTdCnt < count($module->getModuleMethods())) {
                $maxTdCnt = count($module->getModuleMethods());
            }
        }
        /**/
        return view('themes.backend.pages.adminrole.createform', compact('modules', 'maxTdCnt'));
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
            'title' => 'required',
        ], [
            'title.required' => 'The role name field is required.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {

            $requestAll = $request->all();
            $methodArr  = isset($requestAll['method']) ? $requestAll['method'] : array();
            $input = $request->except('_token', 'submit', 'method', 'hid_method_id');

            $userrole = new AuthroleModel($input);
            $userrole->updated_id = $loginAdminId;
            $userrole->updated_at = now();
            if ($userrole->save()) {
                $userrole->saveMethodRights($userrole->role_id, $methodArr);
            }
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
        $userrole = AuthroleModel::find($id);
        $modules = ModuleModel::with('modulemethods')
            ->where('module_id', '!=', 44)
            ->where('status', '=', Config('commonconstants.status_val.1'))
            ->orderBy('title', 'ASC')
            ->get();
        $maxTdCnt = 0;
        foreach ($modules as $key => $module) {
            if (!empty($module->getModuleMethods($id)) && $maxTdCnt < count($module->getModuleMethods($id))) {
                $maxTdCnt = count($module->getModuleMethods($id));
            }
        }

        // $moduleMethods = ModuleMethodModel::all();
        $roleModuleMethodRightsArr = RoleModuleMethodRightsModel::select('method_id')->where('role_id', '=', $userrole->role_id)->get()->toArray();

        $selectedMethodIDArr = Arr::flatten($roleModuleMethodRightsArr);

        $editDataAtrArr = ["login_admin_id" => self::getLoggedInAdminId(), "title" => __('admin.edit_admnrole_user_txt')];

        return view('themes.backend.pages.adminrole.updateform', compact('userrole', 'editDataAtrArr', 'modules', 'maxTdCnt', 'selectedMethodIDArr'));
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
            'title' => 'required',
        ], [
            'title.required' => 'The role name field is required.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {

            $requestAll = $request->all();
            $methodArr  = isset($requestAll['method']) ? $requestAll['method'] : array();

            $input = $request->except('_token', '_method', 'submit', 'method', 'hid_method_id');

            $userrole = AuthroleModel::find($id);
            foreach ($input as $key => $value) {
                if (trim($value) == '')
                    continue;
                else
                    $userrole->$key = trim($value);
            }
            $userrole->updated_id = $loginAdminId;
            $userrole->updated_at = now();
            $userrole->save();
            // $userrole->saveMethodRights($id,$methodArr);
            $userrole->role_id > 1 ? $userrole->saveMethodRights($id, $methodArr) : '';
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
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
        
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                AuthroleModel::destroy($checkboxArr);
                RoleModuleMethodRightsModel::whereIn('role_id', $checkboxArr)->forceDelete();
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
