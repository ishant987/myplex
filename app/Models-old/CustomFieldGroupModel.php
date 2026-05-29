<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\CustomFieldGroupTypeModel;

class CustomFieldGroupModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'custom_field_group';

    protected $primaryKey = 'cf_group_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'c_order',
        'status',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'cf_group_id',
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

    public function cfgrouptypes()
    {
        return $this->hasMany(CustomFieldGroupTypeModel::class, 'cf_group_id')->where('status', '=', 1)->orderBy('c_order', 'asc');
    }

    public function cfallgrouptypes()
    {
        return $this->hasMany(CustomFieldGroupTypeModel::class, 'cf_group_id');
    }

    #== Return array of groupwise custom fields data types ==#
    public static function getGroupwiseCfTypes($class_id, $template_id)
    {
        if ($class_id > 0 && $template_id > 0) {
            return CustomFieldGroupModel::with(['cfgrouptypes' => function ($q) use ($class_id, $template_id) {
                $q->with(['cfgtclasstemplates' => function ($q2) use ($class_id, $template_id) {
                    $q2->where(['class_id' => $class_id, 'template_id' => $template_id]);
                }])->whereHas('cfgtclasstemplates', function ($q2) use ($class_id, $template_id) {
                    $q2->where(['class_id' => $class_id, 'template_id' => $template_id]);
                });
            }])->whereHas('cfgrouptypes', function ($q) use ($class_id, $template_id) {
                $q->whereHas('cfgtclasstemplates', function ($q2) use ($class_id, $template_id) {
                    $q2->where(['class_id' => $class_id, 'template_id' => $template_id]);
                });
            })->where(['status' => 1])->orderBy('c_order', 'asc')->get();
        }

        return false;
    }

    public static function getGroupwiseCfRequiredTypes($class_id, $template_id)
    {
        if ($class_id > 0 && $template_id > 0) {
            $templateCfObj = self::getGroupwiseCfTypes($class_id, $template_id);

            if ($templateCfObj && $templateCfObj->count() > 0) {
                $cfRequiredRuleArr = $cfRequiredMsgArr = [];
                foreach ($templateCfObj as $cfgroup) {
                    if (isset($cfgroup->cfgrouptypes) && $cfgroup->cfgrouptypes->count() > 0) {
                        foreach ($cfgroup->cfgrouptypes as $cf_gt) {
                            $cf_group_type_id = $cf_gt->cf_group_type_id;
                            $cf_gt_class_template_id = isset($cf_gt->cfgtclasstemplates[0]->cf_gt_class_template_id) ? $cf_gt->cfgtclasstemplates[0]->cf_gt_class_template_id : 0;
                            if ($cf_gt_class_template_id > 0 && $cf_group_type_id > 0) {
                                if ($cf_gt->field_options['required']) {
                                    $field = 'cf_' . $cf_gt->field_type . '_' . $cf_group_type_id . '_' . $cf_gt_class_template_id;
                                    $rule = $cf_gt->field_options['label'] . ' field is required.';
                                    $cfRequiredRuleArr[$field]              = 'required';
                                    $cfRequiredMsgArr[$field . '.required']   = $rule;
                                }
                            }
                        }
                    }
                }
                return array('rules' => $cfRequiredRuleArr, 'rulesMsgs' => $cfRequiredMsgArr);
            }
        }
        return false;
    }

    /*
    ** Delete Cf group  with cfallgrouptypes , cfgtclasstemplates and cfgtvalues
    */
    public function deleteCfGroup()
    {
        if ($this->cf_group_id > 0) {
            if ($this->cfallgrouptypes && $this->cfallgrouptypes->count() > 0) {
                foreach ($this->cfallgrouptypes as $cfgrouptypeModel) {
                    $cfgrouptypeModel->deleteCfGroupType();
                }
            }
            return $this->delete();
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
}
