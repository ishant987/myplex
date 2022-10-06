<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as BaseController;

use Validator;
use App\Lib\Admin\App;

use App\Models\CustomFieldGroupModel;
use App\Models\CustomFieldGroupTypeClassTemplateModel;
use App\Models\CustomFieldGroupTypeModel;
use App\Models\CustomFieldTypeModel;

class CustomfieldGrouptypeController extends BaseController
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
    public function create($cf_group_id)
    {
        $customFieldTypeModel = New CustomFieldTypeModel();
        $customFieldGroupTypeModel = New CustomFieldGroupTypeModel();
        $dataArr = CustomFieldGroupModel::find($cf_group_id);
        $cfTypeAssoc = $customFieldTypeModel->getCfTypeAssoc();
        $statsArr = App::getStatusLblTyp2Arr();
        $reqArr = App::getYesNoArr();
        $reqArr = array_reverse($reqArr);
        $cfForAssoc = $customFieldGroupTypeModel->getCfForAssoc();

        return view('themes.backend.pages.customfieldgrouptype.createform',compact('dataArr','statsArr','cfTypeAssoc','reqArr','cfForAssoc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $cf_group_id)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $rulesArr = [
            'field_for' => 'required',
            'label' => 'required',
            'status' => 'required|integer',
            'c_order' => 'nullable|integer'
        ];
        $rulesMsgArr = [
            'c_order.integer' => __('admin.validation.c_order.integer')
        ];
        
        $input = $request->validate($rulesArr,$rulesMsgArr);

        try {

            $excldInputArr = ['_token', 'submit'];

            $inputAll = $request->except($excldInputArr);
            
            $field_optionsArr = [];
            $field_optionsArr['type'] = trim($inputAll['field_type']);
            $field_optionsArr['label'] = trim($inputAll['label']);
            $field_optionsArr['placeholder'] = trim($inputAll['placeholder']);
            $field_optionsArr['required'] = trim($inputAll['required'])=='y'?true:false;
            $field_optionsArr['description'] = trim($inputAll['description']);
            $field_optionsArr['instruction'] = trim($inputAll['instruction']);

            $input['cf_group_id'] = $cf_group_id;
            $input['field_name'] = trim($inputAll['field_type']).'_'.time();
            $input['field_type'] = trim($inputAll['field_type']);
            $input['field_for'] = trim($inputAll['field_for']);
            $input['field_options'] = $field_optionsArr;

            $store = new CustomFieldGroupTypeModel($input);

            $c_order = intval($input['c_order']);
            $store->c_order = $c_order > 0 ? $c_order : 0;
            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;

            if($store->save()){
                \DB::commit();

                #==update the field name ==#
                $store->field_name = $store->field_type."_".$store->cf_group_type_id;
                $store->save();

                return redirect()->route('admin.customfield.show', $cf_group_id)->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['add'])->with('title', $adminLang['success_ttl']);
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
    public function show($cf_group_id, $cf_group_type_id)
    {
        $dataArr = CustomFieldGroupTypeModel::find($cf_group_type_id);

        $coreObj = new App();

        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();
        
        $dataListModel = CustomFieldGroupTypeClassTemplateModel::where(['cf_group_type_id'=>$cf_group_type_id,'deleted_flag'=>0])->orderBy('cf_gt_class_template_id', 'ASC')->get();

        $moduleAtrArr = array_merge(array("status" => App::getStatusLblTyp2Arr()[$dataArr['status']]) );
        
        $editDataAtrArr = ["title"=>__('admin.customfield.grouptype.show_txt'), "titlegt"=>__('admin.customfield.grouptype.gtct_txt'), "route"=>'customfield.grouptype.show'];
        
        return view('themes.backend.pages.customfieldgrouptype.show', compact('dataArr', 'moduleAtrArr', 'editDataAtrArr','dataListModel','listDataAtrArr', 'statusAtrArr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cf_group_id, $cf_group_type_id)
    {
        $customFieldTypeModel = New CustomFieldTypeModel();
        $customFieldGroupTypeModel = New CustomFieldGroupTypeModel();
        $cfTypeAssoc = $customFieldTypeModel->getCfTypeAssoc();
        $reqArr = App::getYesNoArr();
        $reqArr = array_reverse($reqArr);
        $cfForAssoc = $customFieldGroupTypeModel->getCfForAssoc();

        $dataArr = CustomFieldGroupTypeModel::find($cf_group_type_id);

        $moduleAtrArr = array_merge(array("status" => App::getStatusLblTyp2Arr()) );
        
        $editDataAtrArr = ["title"=>__('admin.customfield.grouptype.edit_txt'), "route"=>'customfield.grouptype.edit'];
        
        return view('themes.backend.pages.customfieldgrouptype.updateform', compact('dataArr', 'moduleAtrArr', 'editDataAtrArr','cfTypeAssoc','reqArr','cfForAssoc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cf_group_id, $cf_group_type_id)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');
        $messageLang = __('message');
        $adminLang = __('admin');

        $rulesArr = [
            'field_for' => 'required',
            'label' => 'required',
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
            $inputAll = $request->except($excldInputArr); 

            $store = CustomFieldGroupTypeModel::find($cf_group_type_id);
            
            $field_optionsArr = [];
            $field_optionsArr['type'] = trim($inputAll['field_type']);
            $field_optionsArr['label'] = trim($inputAll['label']);
            $field_optionsArr['placeholder'] = trim($inputAll['placeholder']);
            $field_optionsArr['required'] = trim($inputAll['required'])=='y'?true:false;
            $field_optionsArr['description'] = trim($inputAll['description']);
            $field_optionsArr['instruction'] = trim($inputAll['instruction']);
            
            $store->field_type = trim($inputAll['field_type']);
            $store->field_for = trim($inputAll['field_for']);
            $store->field_options = $field_optionsArr;

            $c_order = intval($inputAll['c_order']);
            $store->c_order = $c_order > 0 ? $c_order : 0;            
            $store->status = intval($inputAll['status']);            
            $store->updated_id = $loginAdminId;

            if($store->save()){
                \DB::commit();

                #==update the field name ==#
                $store->field_name = $store->field_type."_".$store->cf_group_type_id;
                $store->save();

                return redirect()->route('admin.customfield.grouptype.show', [$cf_group_id, $store->cf_group_type_id])->with('alert', $adminconstants['alert_css'][1])->with('message', $messageLang['success']['update'])->with('title', $adminLang['success_ttl']);
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
                    
                foreach ($checkboxArr as $key => $cf_group_type_id)
                {
                    $cfGroupTypeModel = CustomFieldGroupTypeModel::find($cf_group_type_id);
                    $delModel = $cfGroupTypeModel->deleteCfGroupType();
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

    public function getDefaultOptionByFieldType($field_type)
    {
        if($field_type)
        {
            return CustomFieldTypeModel::where(['field_type'=>$field_type])->value('field_default_options');
        }
        return false;
    }
}
