<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;

use Validator;
use App\Lib\Admin\App;

use App\Models\CustomFieldGroupModel;
use App\Models\CustomFieldGroupTypeModel;

class CustomfieldController extends BaseController
{
    public $className;
    public $class_id;

    public function __construct(){
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
        $this->class_id = self::getClassIdByname($this->className);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataListModel = CustomFieldGroupModel::orderBy('c_order', 'ASC')->get();

        $coreObj = new App();

        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.customfield.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.customfield.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deletecustomfield')];
        
        return view('themes.backend.pages.customfield.index', compact('dataListModel', 'listDataAtrArr', 'statusAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $statsArr = App::getStatusLblTyp2Arr();
        return view('themes.backend.pages.customfield.createform',compact('statsArr'));
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
        $messageLang = __('message');
        $adminLang = __('admin');

        $rulesArr = [
            'title' => 'required',
            'status' => 'required|integer',
            'c_order' => 'nullable|integer'
        ];
        $rulesMsgArr = [
            'c_order.integer' => __('admin.validation.c_order.integer')
        ];

        $request->validate($rulesArr, $rulesMsgArr);

        try {

            $excldInputArr = ['_token', 'submit'];

            $inputAll = $request->except($excldInputArr); 

            foreach ($inputAll as $key => $value) 
            {
                $input[$key] = trim($value);
            }

            $store = new CustomFieldGroupModel($input);

            $c_order = intval($input['c_order']);
            $store->c_order = $c_order > 0 ? $c_order : 0;
            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;

            if($store->save()){
                \DB::commit();

                return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['add'])->with('title', $adminLang['success_ttl']);
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['data_saved'])->with('title', $adminLang['error_ttl']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataArr = CustomFieldGroupModel::find($id);
        
        $coreObj = new App();

        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();
        
        $dataListModel = CustomFieldGroupTypeModel::where(['cf_group_id'=>$id])->orderBy('c_order', 'ASC')->get();

        $moduleAtrArr = array_merge(array("status" => App::getStatusLblTyp2Arr()[$dataArr['status']]) );
        
        $editDataAtrArr = ["title"=>__('admin.customfield.show_txt'), "titlegt"=>__('admin.customfield.gt_txt'), "route"=>'customfield.show'];
        
        return view('themes.backend.pages.customfield.show', compact('dataArr', 'moduleAtrArr', 'editDataAtrArr','dataListModel','listDataAtrArr', 'statusAtrArr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = CustomFieldGroupModel::find($id);

        $moduleAtrArr = array_merge(array("status" => App::getStatusLblTyp2Arr()) );
        
        $editDataAtrArr = ["title"=>__('admin.customfield.edit_txt'), "route"=>'customfield.edit'];
        
        return view('themes.backend.pages.customfield.updateform', compact('dataArr', 'moduleAtrArr', 'editDataAtrArr'));
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
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $rulesArr = [
            'title' => 'required',
            'status' => 'required|integer',
            'c_order' => 'nullable|integer'
        ];
        $rulesMsgArr = [
            'c_order.integer' => __('admin.validation.c_order.integer')
        ];
        $input = $request->validate($rulesArr,$rulesMsgArr);

        \DB::beginTransaction();

        try {
            $excldInputArr = ['_method', '_token', 'submit'];
            $input = $request->except($excldInputArr); 

            $store = CustomFieldGroupModel::find($id);

            foreach ($input as $key => $value) 
            {
                $store->$key = trim($value);
            }

            $c_order = intval($input['c_order']);
            $store->c_order = $c_order > 0 ? $c_order : 0;            
            $store->updated_id = $loginAdminId;

            if($store->save()){
                \DB::commit();

                return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['update'])->with('title', $adminLang['success_ttl']);
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['update'])->with('title', $adminLang['error_ttl']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletedata(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {
                \DB::beginTransaction();
                    
                foreach ($checkboxArr as $key => $cf_group_id)
                {
                    $cfGroupModel = CustomFieldGroupModel::find($cf_group_id);
                    $delModel = $cfGroupModel->deleteCfGroup();
                    if($delModel > 0){
                        \DB::commit();
                    }
                    else{
                        \DB::rollBack();
                    }
                }
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['delete'])->with('title', $adminLang['error_ttl']);
            }
        }
        
        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['delete'])->with('title', $adminLang['success_ttl']);
    }
}
