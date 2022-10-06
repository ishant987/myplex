<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\App\Common;
use App\Lib\Admin\App;

use App\Models\TemplateModel;
use App\Models\ModuleClassModel;

class TemplateController extends BaseController
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
        $dataListModel = TemplateModel::orderBy('template_id', 'DESC')->get();

        $coreObj = new App();

        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $commonconstants = Config('commonconstants');
        
        $fldsHide = __('admin.template.flds_hide');
        $boolFalse = $commonconstants['bool_false'];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.template.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.template.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deletetemplate')];
        
        return view('themes.backend.pages.template.index', compact('dataListModel', 'listDataAtrArr', 'statusAtrArr', 'fldsHide', 'boolFalse', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusArr = App::getStatusLblTyp2Arr();
        $templatesArr =  ModuleClassModel::getClassAssoc();

        $commonconstants = Config('commonconstants');

        $fldsHide = __('admin.template.flds_hide');
        $boolFalse = $commonconstants['bool_false']; 

        return view('themes.backend.pages.template.createform',compact('statusArr', 'templatesArr', 'fldsHide', 'boolFalse'));
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

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required',
            'class_id' => 'required|integer',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'c_order.integer' => __('admin.validation.c_order.integer'),
            'class_id.required' => __('admin.validation.required.class_id'),
            'class_id.integer' => __('admin.validation.integer.class_id')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit'); 

            \DB::beginTransaction();

            $store = new TemplateModel($input);

            $reqSlug        = isset($input['slug']) ? $input['slug'] : $input['title'];
            $store->slug    = Common::generateSlug($reqSlug, 'template');

            $fldsHide = __('admin.template.flds_hide');
            $boolFalse = $commonconstants['bool_false']; 

            if( $fldsHide['c_order'] == $boolFalse ){
                $c_order = intval($input['c_order']);
                $store->c_order = $c_order > 0 ? $c_order : 0;
            }

            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;

            if($store->save())
            {
            	$class_id = intval($input['class_id']);
            	$store->class_id = $class_id;
            	if($store->saveTemplateClass())
            	{
            		\DB::commit();
            	}
            	else{
            		\DB::rollBack();
            	}
            }
            else{
            	\DB::rollBack();
            }


        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['data_saved'])->with('title', $adminLang['error_ttl']);
            }
        }

        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['add'])->with('title', $adminLang['success_ttl']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = TemplateModel::find($id);

        $statusArr = App::getStatusLblTyp2Arr();
        $templatesArr =  ModuleClassModel::getClassAssoc();

        $commonconstants = Config('commonconstants');

        $fldsHide = __('admin.template.flds_hide');
        $boolFalse = $commonconstants['bool_false'];

        $editDataAtrArr = ["title"=>__('admin.template.edit_txt'), "route"=>'template.edit'];
        
        return view('themes.backend.pages.template.updateform', compact('dataArr', 'statusArr', 'editDataAtrArr', 'templatesArr', 'fldsHide', 'boolFalse'));
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

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required',
            'class_id' => 'required|integer',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'c_order.integer' => __('admin.validation.c_order.integer'),
            'class_id.required' => __('admin.validation.required.class_id'),
            'class_id.integer' => __('admin.validation.integer.class_id')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_method', '_token', 'submit'); 

            \DB::beginTransaction();

            $store = TemplateModel::find($id);

            foreach ($input as $key => $value) 
            {
                if($key == 'class_id'){
                	continue;
                }
                elseif($key == 'c_order'){
                    $c_order = intval($input['c_order']);
                    $store->c_order = $c_order > 0 ? $c_order : 0;
                }
                else{
                    $store->$key = trim($value);
                }
            }

            $reqSlug = (isset($store->slug) && $store->slug)?$store->slug:$store->title;
            $store->slug = Common::generateSlug($reqSlug, 'template', '', 'template_id !='.$id);

            $store->updated_id = $loginAdminId;
            if($store->save())
            {
            	$class_id = intval($input['class_id']);
            	$store->class_id = $class_id;
            	if($store->saveTemplateClass())
            	{
            		\DB::commit();
            	}
            	else{
            		\DB::rollBack();
            	}
            }
            else{
            	\DB::rollBack();
            }

        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['update'])->with('title', $adminLang['error_ttl']);
            }
        }

        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['update'])->with('title', $adminLang['success_ttl']);
    }

    public function deleteData(Request $request)
    {
    	$adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $loginAdminId = self::getLoggedInAdminId();
        try {   
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {
                \DB::beginTransaction();

                $templatesModel = TemplateModel::whereIn('template_id', $checkboxArr)->get();
                if($templatesModel)
                {
                	foreach ($templatesModel as $key => $templateModel) {
                		$templateModel->flushData();
                	}
                }

                $delModel = TemplateModel::whereIn('template_id', $checkboxArr)->delete();
                if($delModel > 0){
                    \DB::commit();
                }
                else{
                    \DB::rollBack();
                }
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if($loginAdminId == Config('commonconstants.def_super_admin_id')){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $adminLang['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $messageLang['error']['delete'])->with('title', $adminLang['error_ttl']);
            }
        }
        
        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['delete'])->with('title', $adminLang['success_ttl']);
    }
}
