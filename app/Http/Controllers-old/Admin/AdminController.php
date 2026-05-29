<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Admin\App;

use App\Models\AdminModel;

class AdminController extends BaseController
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
        $dataListModel = AdminModel::with('role')->orderBy('admin_id', 'DESC')->get();
        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp1Atr();
        $othrDataAtrArr = ["login_admin_id" => self::getLoggedInAdminId(), "def_super_admin_id" => Config('commonconstants.def_super_admin_id'), "view_txt" => __('admin.view_txt'), "target" => Config('commonconstants.target_opt1')];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.admin.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.admin.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deleteuser')];

        return view('themes.backend.pages.admin.index', compact('dataListModel', 'listDataAtrArr', 'statusAtrArr', 'othrDataAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$admin = auth()->guard('admin')->user();*/
        $roles = AdminModel::getRoleList();
        $statusArr = App::getStatusLblTyp1Arr();

        /*return view('themes.backend.pages.admin.createform',compact('admin', 'roles', 'statusArr'));*/
        return view('themes.backend.pages.admin.createform', compact('roles', 'statusArr'));
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
            'role_id' => 'required|integer',
            'username' => 'required|unique:admin',
            'display_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:admin',
            'website' => 'nullable|url',
            'secret' => 'nullable|min:2',
            'password' => 'required|min:2',
            'confirm_password' => 'required|same:password',
            'status' => 'required|integer'
        ], [
            'role_id.required' => __('admin.validation.required.role')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit');

            $store = new AdminModel($input);
            $store->secret = bcrypt($request->secret);
            $store->password = bcrypt($request->password);
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
        $dataArr = AdminModel::find($id);
        $roles = AdminModel::getRoleList();

        $editDataAtrArr = ["login_admin_id" => self::getLoggedInAdminId(), "title" => __('admin.edit_admn_user_txt'), "route" => 'admin.edit', "postroute" => 'admin.admin.update'];
        $statusArr = App::getStatusLblTyp1Arr();

        return view('themes.backend.pages.admin.updateform', compact('dataArr', 'roles', 'editDataAtrArr', 'statusArr'));
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
            'role_id' => 'sometimes|required|integer',
            'display_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:admin,email,' . $id . ',admin_id',
            'website' => 'nullable|url',
            'secret' => 'nullable|min:2',
            'password' => 'nullable|min:2'
        ], [
            'role_id.required' => __('admin.validation.required.role')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', '_method', 'submit');

            $store = AdminModel::find($id);
            foreach ($input as $key => $value) {
                if ($key == 'password' || $key == 'secret') {
                    if (trim($value) == '') continue;
                    $store->$key = bcrypt($value);
                } else {
                    $store->$key = trim($value);
                }
            }
            $store->updated_id = $id;
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

    public function editprofile()
    {
        $dataArr = auth()->guard('admin')->user();
        $editDataAtrArr = ["login_admin_id" => 0, "title" => __('admin.edit_profile_txt'), "route" => 'admin.profile', "postroute" => 'admin.profile.update'];

        return view('themes.backend.pages.admin.updateform', compact('dataArr', 'editDataAtrArr'));
    }

    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                AdminModel::destroy($checkboxArr);
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
