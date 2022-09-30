<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\App\Common;

use App\Models\MenuTypeModel;

class MenutypeController extends BaseController
{
    public $className;
    public $class_id;

    public function __construct(){
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
        $this->class_id = self::getClassIdByname($this->className);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $mtModel = new MenuTypeModel();     
        $menuforAssoc = $mtModel->getMenuforAssoc();
        return view('themes.backend.pages.menutype.createform',compact('menuforAssoc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rulesArr = [
            'label' => 'required',
            'menu_name' => 'required',
            'menu_for' => 'required',
        ];
        $rulesMsgArr = [];
        $validator = Validator::make($request->all(), $rulesArr, $rulesMsgArr);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        try {

            $excldInputArr = ['_token', 'submit'];
            $input = $request->except($excldInputArr); 

            $mtModel = new MenuTypeModel();
            $reqSlug        = isset($input['menu_name']) ? $input['menu_name'] : $input['label'];
            $input['menu_name']    = Common::generateSlug($reqSlug, 'menu_type','menu_name');
            $input['created_id']   = $loginAdminId;
            $input['updated_id']   = 0;
            $input['c_order']      = isset($input['c_order'])?$input['c_order']:0;
            $input['menu_for']     = $mtModel->checkDuplicateMenufor($input['menu_for'])?'o':$input['menu_for'];
            if($mtObj = $mtModel->create($input))
            {
                return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['add'])->with('title', $adminLang['success_ttl']);
            }
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['data_saved'])->with('title', $adminLang['error_ttl']);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $mtModel = new MenuTypeModel(); 
        $dataArr = MenuTypeModel::find($id);
        $menuforAssoc = $mtModel->getMenuforAssoc();
        $editDataAtrArr = ["title"=>__('admin.menutype.edit_txt'), "route"=>'menutype.edit'];        
        return view('themes.backend.pages.menutype.updateform', compact('dataArr','menuforAssoc', 'editDataAtrArr'));
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
        // echo "<pre>";
        // print_r($request->all());
        // die("OK");

        $templateAssoc = $rulesDataArr = [];      

        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $rulesArr = [
            'label' => 'required',
            'menu_name' => 'required',
            'menu_for' => 'required'
        ];
        $rulesMsgArr = [];

        $validator = Validator::make($request->all(), $rulesArr,$rulesMsgArr);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {
            $excldInputArr = ['_method', '_token', 'submit'];
            $input = $request->except($excldInputArr); 

            $store = menuTypeModel::find($id);

            $store->label = $input['label'];
            $reqSlug = (isset($input['menu_name']) && $input['menu_name'])?$input['menu_name']:$input['label'];
            $store->menu_name = Common::generateSlug($reqSlug, 'menu_type', 'menu_name', 'menu_type_id !='.$id);
            $store->menu_for = $input['menu_for'];
            $store->updated_id = $loginAdminId;

            if($store->save()){

                $store->updateDuplicateMenufor();

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
    public function destroy($id)
    {
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $menuTypeModel = MenuTypeModel::with('menus')->where(['menu_type_id'=>$id])->first();
        if($menuTypeModel){
            if($menuTypeModel->menus && $menuTypeModel->menus->count()>0){
                foreach ($menuTypeModel->menus as $key => $menu) {
                    $menu->delete();
                }
            }
            $menuTypeModel->delete();
            return redirect()->route('admin.menu.index.custom')->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['delete'])->with('title', $adminLang['success_ttl']);
        }
    }
}
