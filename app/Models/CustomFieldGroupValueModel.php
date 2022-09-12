<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\CustomFieldGroupModel;
use App\Models\MediaModel;
use App\Models\AdminModel;

class CustomFieldGroupValueModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'custom_field_group_type_values';

    protected $primaryKey = 'cf_group_type_value_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cf_group_type_id',
        'data_id',
        'field_value',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'cf_group_type_value_id',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function createdby()
    {
        return $this->belongsTo(AdminModel::class, 'created_id');
    }

    public function updatedby()
    {
        return $this->belongsTo(AdminModel::class, 'updated_id');
    }

    public function cfgrouptype()
    {
        return $this->belongsTo(CustomFieldGroupTypeModel::class, 'cf_group_type_id');
    }

    /*
    ** Save the template of Cf values of particular with table data...
    */
    public function saveCfGroupDataValues($class_id, $data_id, $template_id, $input)
    {
        if ($class_id > 0 && $template_id > 0 && $data_id > 0 && is_array($input) && count($input) > 0) {
            $templateCfObj = CustomFieldGroupModel::getGroupwiseCfTypes($class_id, $template_id);
            if ($templateCfObj && $templateCfObj->count() > 0) {
                $loggedUserID = auth()->guard('admin')->user()->admin_id;
                foreach ($templateCfObj as $cfgroup) {
                    if (isset($cfgroup->cfgrouptypes) && $cfgroup->cfgrouptypes->count() > 0) {
                        foreach ($cfgroup->cfgrouptypes as $cf_gt) {
                            $cf_group_type_id = $cf_gt->cf_group_type_id;
                            $cf_gt_class_template_id = isset($cf_gt->cfgtclasstemplates[0]->cf_gt_class_template_id) ? $cf_gt->cfgtclasstemplates[0]->cf_gt_class_template_id : 0;
                            if ($cf_gt_class_template_id > 0) {
                                $field = 'cf_' . $cf_gt->field_type . '_' . $cf_group_type_id . '_' . $cf_gt_class_template_id;
                                $field_value = isset($input[$field]) ? $input[$field] : '';

                                if ($field_value) {
                                    $cfGroupValueModel = $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id, $data_id, false);
                                    if ($cfGroupValueModel) {
                                        $cfGroupValueModel->field_value        = $field_value;
                                        $cfGroupValueModel->updated_id         = $loggedUserID;
                                        $cfGroupValueModel->save();
                                    } else {
                                        $cfGroupValueModel = new CustomFieldGroupValueModel();
                                        $cfGroupValueModel->cf_group_type_id   = $cf_group_type_id;
                                        $cfGroupValueModel->cf_gt_class_template_id = $cf_gt_class_template_id;
                                        $cfGroupValueModel->data_id            = $data_id;
                                        $cfGroupValueModel->field_value        = $field_value;
                                        $cfGroupValueModel->created_id         = $loggedUserID;
                                        $cfGroupValueModel->updated_id         = 0;
                                        $cfGroupValueModel->updated_at         = null;
                                        $cfGroupValueModel->save();
                                    }
                                } else {
                                    CustomFieldGroupValueModel::where(['data_id' => $data_id, 'cf_group_type_id' => $cf_group_type_id, 'cf_gt_class_template_id' => $cf_gt_class_template_id])->delete();
                                }
                            }
                        }
                    }
                }
            }

            #== Delete the other template group values of module(if choosed another while edit) ==#
            $this->resetOtherTemplateCfGroupDataValues($class_id, $data_id, $template_id);
        } else {
            $this->resetCfGroupDataValues($class_id, $data_id);
        }
    }

    /*
    ** Reset Cf values of the class with table data..
    */
    public static function resetCfGroupDataValues($class_id, $data_id = 0, $dataInArr = [])
    {
        if ($class_id > 0 && ($data_id > 0 || count($dataInArr) > 0)) {
            $query = CustomFieldGroupValueModel::join('custom_field_group_type_class_template', 'custom_field_group_type_class_template.cf_gt_class_template_id', '=', 'custom_field_group_type_values.cf_gt_class_template_id');
            if ($data_id > 0) {
                $query = $query->where('custom_field_group_type_values.data_id', '=', $data_id);
            }
            if (count($dataInArr) > 0) {
                $query = $query->whereIn('custom_field_group_type_values.data_id', $dataInArr);
            }
            $query = $query->where('custom_field_group_type_class_template.class_id', '=', $class_id);
            $query = $query->delete();
        }
    }

    /*
    ** Reset the Old template Cf values of particular class with table row datas....
    */
    public function resetOtherTemplateCfGroupDataValues($class_id, $data_id, $template_id)
    {
        if ($class_id > 0 && $data_id > 0 && $template_id > 0) {
            CustomFieldGroupValueModel::join('custom_field_group_type_class_template', 'custom_field_group_type_class_template.cf_gt_class_template_id', '=', 'custom_field_group_type_values.cf_gt_class_template_id')->where(['custom_field_group_type_values.data_id' => $data_id, 'custom_field_group_type_class_template.class_id' => $class_id])->where('custom_field_group_type_class_template.template_id', '!=', $template_id)->delete();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */


    /*
    ** Return the active Cf values for particular class and table in array ....
    */
    public static function getCfGroupDataValues($class_id, $template_id, $data_id, $field_forArr = [])
    {
        $cfArr = [];
        if ($class_id > 0 && $data_id > 0 && $template_id > 0) {
            $query = CustomFieldGroupValueModel::join('custom_field_group_type_class_template', 'custom_field_group_type_class_template.cf_gt_class_template_id', '=', 'custom_field_group_type_values.cf_gt_class_template_id')->join('custom_field_group_type', 'custom_field_group_type_class_template.cf_group_type_id', '=', 'custom_field_group_type.cf_group_type_id')->where(['custom_field_group_type_values.data_id' => $data_id, 'custom_field_group_type_class_template.class_id' => $class_id, 'custom_field_group_type_class_template.template_id' => $template_id]);

            if (count($field_forArr) > 0) {
                $query->whereIn('custom_field_group_type.field_for', $field_forArr);
            }
            $cfGroupValuesModel = $query->orderBy('c_order', 'ASC')->get();

            if ($cfGroupValuesModel) {
                $commonconstants = Config('commonconstants');
                $fieldTypeImage = $commonconstants['field_type_image'];

                foreach ($cfGroupValuesModel as $cfGroupValueModel) {
                    if (isset($cfGroupValueModel->cfgrouptype)) {
                        $cfGtModel = $cfGroupValueModel->cfgrouptype;

                        $fieldFor     = $cfGtModel->field_for;
                        $fieldType  = $cfGtModel->field_type;
                        $fieldName     = $cfGtModel->field_name;
                        $fieldOptions     = $cfGtModel->field_options;
                        $status     = $cfGtModel->status;

                        if ($fieldType && $status) {
                            $fieldValue = $cfGroupValueModel->field_value;
                            switch ($fieldType) {
                                case $fieldTypeImage:
                                    $fieldValue = intval($fieldValue);
                                    if ($fieldValue > 0) {
                                        $mediaPath = MediaModel::getMediaPath($fieldValue);
                                        $fieldValue = $mediaPath;
                                    }
                                    break;
                            }

                            $cfArr[$fieldName]['field_for'] = $fieldFor;
                            $cfArr[$fieldName]['field_label'] = $fieldOptions['label'];
                            $cfArr[$fieldName]['type']      = $fieldType;
                            $cfArr[$fieldName]['value']     = $fieldValue;
                        }
                    }
                }
            }
        }
        return $cfArr;
    }
}
