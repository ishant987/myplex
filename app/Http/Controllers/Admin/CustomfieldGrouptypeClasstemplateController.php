<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as BaseController;

use Illuminate\Validation\Rule;

use App\Models\CustomFieldGroupTypeModel;
use App\Models\ModuleClassModel;
use App\Models\TemplateModel;
use App\Models\CustomFieldGroupTypeClassTemplateModel;

class CustomfieldGrouptypeClasstemplateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($cf_group_id, $cf_group_type_id)
    {
        //Get class (has_templates=y) in modules and templates based on module_class_templates table.
        $dataArr = CustomFieldGroupTypeModel::find($cf_group_type_id);

        // echo "<pre>";
        // print_r($dataArr);
        // // die();
        $moduleClassModel = New ModuleClassModel();
        $moduleClassAssoc = $moduleClassModel->getClassAssoc();
        $classTemplatesAssoc = [];

        return view('themes.backend.pages.customfieldgrouptypect.createform',compact('dataArr','moduleClassAssoc','classTemplatesAssoc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $cf_group_id, $cf_group_type_id)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $rulesArr = [
            'class_id' => 'required|integer',
            'template_id' => 'required|integer',            
            'template_id' => Rule::unique('custom_field_group_type_class_template')->where(function ($query) use($cf_group_type_id, $request){
                return $query->where(['cf_group_type_id'=>$cf_group_type_id,'class_id'=>$request->input('class_id'),'template_id'=>$request->input('template_id')]);
            })
        ];
        $rulesMsgArr = [
            'template_id.unique' => 'Module template already taken for this grouptype'
        ];
        
        $request->validate($rulesArr,$rulesMsgArr);

        try {

            $excldInputArr = ['_token', 'submit'];

            $input = $request->except($excldInputArr);

            $store = new CustomFieldGroupTypeClassTemplateModel($input);
            $store->cf_group_type_id = $cf_group_type_id;
            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;

            if($store->save()){
                \DB::commit();

                return redirect()->route('admin.customfield.grouptype.show', [$store->cfgt->cf_group_id, $store->cf_group_type_id])->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['update'])->with('title', $adminLang['success_ttl']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cf_group_id, $cf_group_type_id, $cf_gt_class_template_id)
    {
        //Get class (has_templates=y) in modules and templates based on module_class_templates table.
        $dataArr = CustomFieldGroupTypeClassTemplateModel::find($cf_gt_class_template_id);

        $moduleClassModel = New ModuleClassModel();
        $moduleClassAssoc = $moduleClassModel->getClassAssoc();
        $classTemplatesAssoc = TemplateModel::getTemplateAssoc($dataArr->class_id);

        return view('themes.backend.pages.customfieldgrouptypect.updateform',compact('dataArr','moduleClassAssoc','classTemplatesAssoc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cf_group_id, $cf_group_type_id, $cf_gt_class_template_id)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $rulesArr = [
            'class_id' => 'required|integer',
            'template_id' => 'required|integer',            
            'template_id' => Rule::unique('custom_field_group_type_class_template')->where(function ($query) use($cf_group_type_id, $cf_gt_class_template_id, $request){
                return $query->where(['cf_group_type_id'=>$cf_group_type_id,'class_id'=>$request->input('class_id'),'template_id'=>$request->input('template_id')])->where('cf_gt_class_template_id','!=', $cf_gt_class_template_id);
            })
        ];
        $rulesMsgArr = [
            'template_id.unique' => 'Module template already taken for this grouptype'
        ];
        
        $request->validate($rulesArr,$rulesMsgArr);

        \DB::beginTransaction();

        try {
            $excldInputArr = ['_method', '_token', 'submit'];
            $inputAll = $request->except($excldInputArr); 

            $store = CustomFieldGroupTypeClassTemplateModel::find($cf_gt_class_template_id);
            
            $store->class_id = trim($inputAll['class_id']);
            $store->template_id = trim($inputAll['template_id']);  
            $store->updated_id = $loginAdminId;

            if($store->save()){
                \DB::commit();

                return redirect()->route('admin.customfield.grouptype.show', [$store->cfgt->cf_group_id, $store->cf_group_type_id])->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['update'])->with('title', $adminLang['success_ttl']);
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
                    
                foreach ($checkboxArr as $key => $cf_gt_class_template_id)
                {
                    $cfGroupCTModel = CustomFieldGroupTypeClassTemplateModel::find($cf_gt_class_template_id);
                    $delModel = $cfGroupCTModel->deleteCfGroupCT();
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

    /**
     * Get the templates associated with the class
     */
    public function getTemplateByClassId($class_id)
    {
        return TemplateModel::getTemplateAssoc($class_id);
    }
}
