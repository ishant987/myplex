<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Lib\Admin\App;

use App\Models\MenuModel;
use App\Models\MenuTypeModel;

class MenuController extends BaseController
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
    public function index($mtid=false)
    {
        $dataListModel = $pagesListModel = [];
    	$menuModel = New MenuModel();
        $menuTypeModel = New MenuTypeModel();
       	$menuTypeAssoc = $menuModel->getMenuTypesAssoc();
        $mtid = (int) ($mtid?$mtid:$menuModel->getDefaultMenuType());

        $menuModel->menu_type_id = $mtid;
        $dataListModel = $menuModel->getMenu();
        $pagesListModel = array(self::getClassIdByname('PageController')=>$menuModel->getPages());

        $menuforAssoc = $menuTypeModel->getMenuforAssoc();
        // echo "<pre>";
        // print_r($menuTypeAssoc);
        // die();

        $roleRights = ['add' => App::hasAccessToMethod('MenutypeController', 'admin.menutype.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.menu.edit'), 'delete' => App::hasAccessToMethod('MenutypeController', 'admin.menutype.destroy.custom')];

        return view('themes.backend.pages.menu.index', compact('dataListModel', 'pagesListModel', 'menuTypeAssoc', 'mtid', 'menuforAssoc', 'roleRights'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $rulesArr = [
        //     // 'link_url' => 'nullable|url',
        //     'link_text' => 'required_if:link_url,null',
        // ];
        // $rulesMsgArr = [];
        // $validator = Validator::make($request->all(), $rulesArr, $rulesMsgArr);

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }
        
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        try {

            $excldInputArr = ['_token', 'add_page_menu_btn', 'add_engagement_menu_btn', 'add_segment_menu_btn', 'add_brand_menu_btn', 'add_custom_menu_btn'];
            $input = $request->except($excldInputArr); 

            $menu_type_id = $input['menu_type_id'];
            $data = [];
            if(isset($input['add_menu_id']) && count($input['add_menu_id'])>0)
            {             
                foreach ($input['add_menu_id'] as $class_id => $dataArr) 
                {
                    if($class_id>0)
                    {
                        foreach ($dataArr as $dataID => $label) {
                            $data[] = array('menu_type_id'=>$menu_type_id,'class_id'=>$class_id,'data_id'=>$dataID,'label'=>$label,'is_link'=>0,'external_link'=>NULL,'c_order'=>0,'status'=>1,'created_id'=>$loginAdminId);
                        }
                    }
                }   
            }
            if($input['link_text'] && $input['link_url']){
                $data[] = array('menu_type_id'=>$menu_type_id,'class_id'=>0,'data_id'=>0,'label'=>$input['link_text'],'is_link'=>1,'external_link'=>$input['link_url'],'c_order'=>0,'status'=>1,'created_id'=>$loginAdminId);
            }

            // print_r($data);
            // die();

            if($data && MenuModel::insert($data))
            {
                return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['add'])->with('title', $adminLang['success_ttl']);    
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['sel_data'])->with('title', $adminLang['error_ttl'])->withInput();
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
        // die();
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        try {

            $excldInputArr = ['_token', '_method', 'submit'];
            $input = $request->except($excldInputArr);
            $data = [];
            if(isset($input['menu_item']) && count($input['menu_item'])>0)
            {             
                foreach ($input['menu_item'] as $menu_id => $dataArr) 
                {
                    if($menu_id>0)
                    {
                       $menuModel = MenuModel::where(['menu_id'=>$menu_id])->first();
                       if($menuModel)
                       {
                            $menuModel->label = $dataArr['label'];
                            $menuModel->c_order = $dataArr['c_order'];
                            if(isset($dataArr['external_link']))
                                $menuModel->external_link = $dataArr['external_link'];
                            if(isset($dataArr['target']))
                                $menuModel->link_target = $dataArr['target'];
                            else
                                $menuModel->link_target = NULL;
                            $menuModel->image_url = $dataArr['image_url'];
                            $menuModel->menu_class = $dataArr['menu_class'];
                            if(isset($dataArr['parent_menu_id']) && $dataArr['parent_menu_id']>0)
                                $menuModel->parent_menu_id = (int) $dataArr['parent_menu_id'];
                            $menuModel->updated_id = $loginAdminId;
                            $menuModel->save();
                       } 
                    }
                }   
            }
            return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['add'])->with('title', $adminLang['success_ttl']);             
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
        $loginAdminId = self::getLoggedInAdminId();

        $menuModel = MenuModel::with('menuchildren')->where(['menu_id'=>$id])->first();
        if($menuModel && isset($menuModel->menuchildren) && $menuModel->menuchildren->count())
        {
            foreach ($menuModel->menuchildren as $key => $menuChild) {
                $menuChild->parent_menu_id = 0;
                $menuChild->updated_id = $loginAdminId;
                $menuChild->save();
            }
        }
        menuModel::destroy($id);
        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['delete'])->with('title', $adminLang['success_ttl']);
    }

}
