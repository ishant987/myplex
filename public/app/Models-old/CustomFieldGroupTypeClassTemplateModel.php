<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\ModuleClassModel;
use App\Models\TemplateModel;
use App\Models\CustomFieldGroupTypeModel;
use App\Models\CustomFieldGroupValueModel;

class CustomFieldGroupTypeClassTemplateModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'custom_field_group_type_class_template';

    protected $primaryKey = 'cf_gt_class_template_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cf_group_type_id',
        'class_id',
        'template_id',
        'deleted_flag',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'cf_gt_class_template_id',
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

    public function moduleclass()
    {
        return $this->belongsTo(ModuleClassModel::class, 'class_id');
    }

    public function template()
    {
        return $this->belongsTo(TemplateModel::class, 'template_id');
    }

    public function cfgt()
    {
        return $this->belongsTo(CustomFieldGroupTypeModel::class, 'cf_group_type_id');
    }

    public function cfgtvalues()
    {
        return $this->hasMany(CustomFieldGroupValueModel::class, 'cf_gt_class_template_id');
    }

    /*
    ** Delete Cfct with cfgtvalues by cf_gt_class_template_id..
    */
    public function deleteCfGroupCT()
    {
        if ($this->cf_gt_class_template_id > 0) {
            if ($this->cfgtvalues && $this->cfgtvalues->count() > 0) {
                foreach ($this->cfgtvalues as $cfgtvalueModel) {
                    $cfgtvalueModel->delete();
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
