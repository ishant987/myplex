<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Illuminate\Support\Arr;

use App\Lib\Admin\App;

use App\Models\UserGroupModel;
use App\Models\UserGroupRelModel;

class UsergroupController extends BaseController
{
    public $className;

    public function __construct(){
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
        $dataListModel = UserGroupModel::getUserGroupList('', ["*"], 'u_g_id', 'DESC');
        $coreObj = new App();
        $listDataAtrArr = Arr::except( $coreObj->getListDataAtr(), ['alert_css'] );

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.usergroup.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.usergroup.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deleteusergroup')];
        
        return view('themes.backend.pages.usergroup.index', compact('dataListModel', 'listDataAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sbsUsrObj = UserGroupModel::usersList();

        return view('themes.backend.pages.usergroup.createform', compact('sbsUsrObj'));
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
        $adminconstants = Config('adminconstants');
        $message = __('message');
        $admin = __('admin');

        $validator = Validator::make($request->all(), [
            'group_name' => 'required|unique:user_group',
            'assigned_to' => 'nullable|array|min:1'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit', 'assigned_from', 'assigned_to', 'q'); 

            $store = new UserGroupModel($input);

            $store->updated_id = $loginAdminId;

            if( $store->save() ){
                $usersArr = $request->input('assigned_to');
                if( !empty( $usersArr ) ){
                    $store2 = [];
                    foreach ($usersArr as $key => $value) {
                        $store2[$key] = ['u_g_id' => $store->u_g_id, 'u_id' => $value, 'updated_id' => $loginAdminId];
                    } 
                    $totInsrt = UserGroupRelModel::insert($store2);
                    if($totInsrt == 0){
                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                    }
                }
            }
        } catch (QueryException $exception) {
            if($loginAdminId == Config('commonconstants.def_super_admin_id')){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            }
        }

        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['add'])->with('title', $admin['success_ttl']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = UserGroupModel::find($id);
        $sbsUsrObj = UserGroupModel::usersList();
        $slctdSbsUsrObj = UserGroupRelModel::getUserGroupRelUsersList(['u_g_id' => $id]);

        $editDataAtrArr = ["title"=>__('subscribeduser.user_group.edit_txt'), "route"=>'usergroup.edit'];
        
        return view('themes.backend.pages.usergroup.updateform', compact('dataArr', 'editDataAtrArr', 'sbsUsrObj', 'slctdSbsUsrObj'));
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
        $adminconstants = Config('adminconstants');
        $message = __('message');
        $admin = __('admin');

        $validator = Validator::make($request->all(), [
            'group_name' => 'required|unique:user_group,group_name,'.$id.',u_g_id',
            'assigned_to' => 'nullable|array|min:1'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_method', '_token', 'submit', 'assigned_from', 'assigned_to', 'q'); 

            $store = UserGroupModel::find($id);

            foreach ($input as $key => $value) 
            {
                $store->$key = trim($value);
            }

            $store->updated_id = $loginAdminId;
            
            if($store->save()){
                $usersArr = $request->input('assigned_to');
                if( !empty( $usersArr ) ){
                    $delModel = UserGroupRelModel::where('u_g_id', $id)->whereNotIn('u_id', $usersArr)->delete();

                    $store2 = [];
                    foreach ($usersArr as $key => $value) {
                        $rowDataObj = UserGroupRelModel::getUserGroupRelData($value, $id, ['u_g_r_id','deleted_at']);
                        if($rowDataObj){
                            if($rowDataObj->deleted_at){
                                $rowDataObj->updated_id = $loginAdminId;
                                $rowDataObj->deleted_at = NULL;
                                $totAfctd = $rowDataObj->save();
                            }
                            else{
                                $store2 = ['updated_id' => $loginAdminId];
                                $totAfctd = UserGroupRelModel::where(['u_g_r_id' => $rowDataObj->u_g_r_id, 'u_g_id' => $id, 'u_id' => $value])->update($store2);
                            }
                        }
                        else{
                            $store2 = ['u_g_id' => $id, 'u_id' => $value, 'updated_id' => $loginAdminId];
                            $totAfctd = UserGroupRelModel::insert($store2);
                        }
                    } 
                    
                    if($totAfctd == 0){
                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
                    }
                }
            }
        } catch (QueryException $exception) {
            if($loginAdminId == Config('commonconstants.def_super_admin_id')){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
            }
        }

        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['update'])->with('title', $admin['success_ttl']);
    }

    public function deletedata(Request $request)
    {
        try {   
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {
                \App\Models\UserGroupRelModel::whereIn('u_g_id', $checkboxArr)->forceDelete();
                UserGroupModel::delete($checkboxArr);
            }
        } catch (QueryException $exception) {
            if($loginAdminId == Config('commonconstants.def_super_admin_id')){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }
        
        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }
}