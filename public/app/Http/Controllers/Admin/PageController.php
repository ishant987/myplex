<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use Illuminate\Support\Arr;

use App\Lib\Admin\App;
use App\Lib\Core\Core;
use App\Lib\App\Common;

use App\Models\PageModel;
use App\Models\TemplateModel;
use App\Models\CustomFieldGroupModel;
use App\Models\CustomFieldGroupValueModel;

class PageController extends BaseController
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
        $dataListModel = PageModel::with('media','parentpage','template')->orderBy('page_id', 'DESC')->get();

        $coreObj = new App();

        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $moduleAtrArr = Arr::only( self::getModuleVars(), ['flds_hide', 'bool_false'] );
        $targetBlank = Config('commonconstants.target_opt1');

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.page.create.custom'), 'edit' => App::hasAccessToMethod($this->className, 'admin.page.edit.custom'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deletepage')];
        
        return view('themes.backend.pages.page.index', compact('dataListModel', 'listDataAtrArr', 'statusAtrArr', 'moduleAtrArr', 'targetBlank', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($templateId = false)
    {
        $moduleAtrArr = self::getModuleVars();

        $templateAssoc = [];
        $templateCfObj = [];
        if($this->class_id > 0)
        {
            $templateAssoc = TemplateModel::getTemplateAssoc($this->class_id);
            if($templateId>0)
            {
                $templateCfObj = CustomFieldGroupModel::getGroupwiseCfTypes($this->class_id,$templateId);
            }
            
            // App::printR($templateCfObj);
        }
        
        return view('themes.backend.pages.page.createform', compact('moduleAtrArr', 'templateId', 'templateAssoc', 'templateCfObj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $templateAssoc = $rulesDataArr = $input = [];
        $templateId = $request->input('template_id')?$request->input('template_id'):0;

        if($this->class_id > 0)
        {
            $templateAssoc = TemplateModel::getTemplateAssoc($this->class_id);
            if($templateId>0)
                $rulesDataArr = CustomFieldGroupModel::getGroupwiseCfRequiredTypes($this->class_id,$templateId);
        }       

        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $rulesArr = [
            'title' => 'required',
            'slug' => 'required',
            'status' => 'required|integer',
            'c_order' => 'nullable|integer'
        ];
        $rulesMsgArr = [
            'c_order.integer' => __('admin.validation.c_order.integer')
        ];

        if(isset($templateAssoc) && count($templateAssoc)>0)
        {
            $rulesArr = array_merge($rulesArr, ['template_id' => 'required']);
            $rulesMsgArr = array_merge($rulesMsgArr, ['template_id.required' => __('admin.validation.required.template')]);
        }
        if(is_array($rulesDataArr) && count($rulesDataArr)>0)
        {
            $rulesArr = array_merge($rulesArr, $rulesDataArr['rules']);
            $rulesMsgArr = array_merge($rulesMsgArr, $rulesDataArr['rulesMsgs']);
        }
        $validator = Validator::make($request->all(), $rulesArr, $rulesMsgArr);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {

            $excldInputArr = ['_token', 'submit'];

            $inputAll = $request->except($excldInputArr); 

            foreach ($inputAll as $key => $value) 
            {
                if(substr( $key, 0, 3 ) === "cf_" ){
                    continue;
                }
                else{
                    $input[$key] = trim($value);
                }
            }
            
            $store = new PageModel($input);

            $reqSlug        = isset($input['slug']) ? $input['slug'] : $input['title'];
            $store->slug    = Common::generateSlug($reqSlug, 'pages');

            $fldsHide   = $adminLang['page']['flds_hide'];
            $boolFalse  = $commonconstants['bool_false'];

            if( $fldsHide['image'] == $boolFalse ){
                $media_id = intval($input['media_id']);
                $store->media_id = $media_id > 0 ? $media_id : 0;
            }
            else{
                $store->media_id = 0;
            }
            if( $fldsHide['parent'] == $boolFalse ){
                $parent = intval($input['parent']);
                $store->parent = $parent > 0 ? $parent : 0;
            }
            else{
                $store->parent = 0;
            }
            if( $fldsHide['c_order'] == $boolFalse ){
                $c_order = intval($input['c_order']);
                $store->c_order = $c_order > 0 ? $c_order : 0;
            }
            else{
                $store->c_order = 0;
            }

            $store->updated_id = $loginAdminId;

            if($store->save()){
                $cfGroupValueModel = new CustomFieldGroupValueModel;
                $cfGroupValueModel->saveCfGroupDataValues($this->class_id,$store->page_id,$templateId,$request->all());

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $reqTemplateId=0)
    {
        $dataArr = PageModel::find($id);
        // $oldTemplateId = $dataArr->template_id;

        $moduleAtrArr = array_merge( self::getModuleVars(), array( "media_folder" => Core::getUploadedURL(Config('commonconstants.media_dir_name')) ) );

        $templateId = $reqTemplateId;

        $templateAssoc = [];
        $templateCfObj = [];
        if($this->class_id > 0)
        {
            $templateAssoc = TemplateModel::getTemplateAssoc($this->class_id);
            if($templateId>0)
            {
                $templateCfObj = CustomFieldGroupModel::getGroupwiseCfTypes($this->class_id,$templateId);
            }
        }
        
        $editDataAtrArr = ["title"=>__('admin.page.edit_txt'), "route"=>'page.edit'];
        
        return view('themes.backend.pages.page.updateform', compact('dataArr', 'moduleAtrArr', 'editDataAtrArr', 'templateAssoc','templateCfObj','templateId'));
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
        $templateAssoc = $rulesDataArr = [];
        $templateId = $request->input('template_id')?$request->input('template_id'):0;

        if($this->class_id > 0)
        {
            $templateAssoc = TemplateModel::getTemplateAssoc($this->class_id);
            if($templateId>0)
                $rulesDataArr = CustomFieldGroupModel::getGroupwiseCfRequiredTypes($this->class_id,$templateId);
        }       

        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $rulesArr = [
            'title' => 'required',
            'slug' => 'required',
            'status' => 'required|integer',
            'c_order' => 'nullable|integer'
        ];
        $rulesMsgArr = [
            'c_order.integer' => __('admin.validation.c_order.integer')
        ];

        if(isset($templateAssoc) && count($templateAssoc)>0)
        {
            $rulesArr = array_merge($rulesArr,['template_id' => 'required']);
            $rulesMsgArr = array_merge($rulesMsgArr,['template_id.required' => __('admin.validation.required.template')]);
        }
        if(is_array($rulesDataArr) && count($rulesDataArr)>0)
        {
            $rulesArr = array_merge($rulesArr,$rulesDataArr['rules']);
            $rulesMsgArr = array_merge($rulesMsgArr,$rulesDataArr['rulesMsgs']);
        }
        $validator = Validator::make($request->all(), $rulesArr,$rulesMsgArr);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {
            $excldInputArr = ['_method', '_token', 'submit', 'template_id', 'files'];
            $input = $request->except($excldInputArr); 

            $store = PageModel::find($id);
            foreach ($input as $key => $value) 
            {
                if(substr( $key, 0, 3 ) === "cf_" ){
                    continue;
                }
                else{
                    $store->$key = trim($value);
                }
            }

            $reqSlug = (isset($store->slug) && $store->slug)?$store->slug:$store->title;
            $store->slug = Common::generateSlug($reqSlug, 'pages', '', 'page_id !='.$id);

            $fldsHide   = $adminLang['page']['flds_hide'];
            $boolFalse  = $commonconstants['bool_false'];

            if( $fldsHide['image'] == $boolFalse ){
                $media_id = intval($input['media_id']);
                $store->media_id = $media_id > 0 ? $media_id : 0;
            }
            else{
                $store->media_id = 0;
            }
            if( $fldsHide['parent'] == $boolFalse ){
                $parent = intval($input['parent']);
                $store->parent = $parent > 0 ? $parent : 0;
            }
            else{
                $store->parent = 0;
            }
            if( $fldsHide['c_order'] == $boolFalse ){
                $c_order = intval($input['c_order']);
                $store->c_order = $c_order > 0 ? $c_order : 0;
            }
            else{
                $store->c_order = 0;
            }

            $store->template_id = $templateId;
            $store->updated_id = $loginAdminId;

            if($store->save()){
                $cfGroupValueModel = new CustomFieldGroupValueModel;
                $cfGroupValueModel->saveCfGroupDataValues($this->class_id,$store->page_id,$templateId,$request->all());
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

    public function deletedata(Request $request)
    {
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {                
                if($this->class_id > 0)
                {
                    \DB::beginTransaction();

                    $cfGroupValueModel = new CustomFieldGroupValueModel;
                    foreach ($checkboxArr as $key => $data_id)
                    {
                        $cfGroupValueModel->resetCfGroupDataValues($this->class_id,$data_id);
                        $delModel = PageModel::where('page_id','=',$data_id)->delete();
                        if($delModel > 0){
                            \DB::commit();
                        }
                        else{
                            \DB::rollBack();
                        }
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



    /*Other functions*/
    public function getModuleVars(){
        return ["parent" => PageModel::orderBy('title', 'ASC')->pluck('title', 'page_id')->toArray(), "status" => App::getStatusLblTyp2Arr(), "flds_hide" => __('admin.page.flds_hide'), "bool_false" => Config('commonconstants.bool_false'), "field_type" => Config('adminconstants.field_type')];
    }
}