<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\CustomFieldGroupValueModel;
use App\Models\MediaModel;
use App\Models\AdminModel;
use App\Models\CustomFieldGroupTypeClassTemplateModel;

class CustomFieldGroupTypeModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'custom_field_group_type';

    protected $primaryKey = 'cf_group_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cf_group_id',
        'field_name',
        'field_type',
        'field_for',
        'field_options',
        'c_order',
        'status',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'cf_group_type_id',
    ];

    protected $casts = [
        'field_options' => 'array'
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

    public function cfgrouptypevalues()
    {
        return $this->hasMany(CustomFieldGroupValueModel::class, 'cf_group_type_id');
    }

    public function cfgtclasstemplates()
    {
        return $this->hasMany(CustomFieldGroupTypeClassTemplateModel::class, 'cf_group_type_id');
    }

    public function getCfGrouptypeValue($cf_gt_class_template_id, $data_id, $onlyValue = true)
    {
        if ($this->cf_group_type_id > 0 && $cf_gt_class_template_id > 0 && $data_id > 0) {
            return $onlyValue ? (CustomFieldGroupValueModel::where(['cf_group_type_id' => $this->cf_group_type_id, 'cf_gt_class_template_id' => $cf_gt_class_template_id, 'data_id' => $data_id])->value('field_value')) : (CustomFieldGroupValueModel::where(['cf_group_type_id' => $this->cf_group_type_id, 'cf_gt_class_template_id' => $cf_gt_class_template_id, 'data_id' => $data_id])->first());
        }

        return false;
    }

    public function getCfGrouptypeMediaValue($media_id)
    {
        if ($this->field_type == 'image') {
            return MediaModel::where('media_id', '=', $media_id)->first();
        }

        return false;
    }

    public function getCfFor()
    {
        if ($this->field_for) {
            return __('admin.cf.' . $this->field_for);
        }
    }

    public function getCfForAssoc()
    {
        return ['a' => 'All', 'w' => 'Website', 'ap' => 'App'];
    }

    /*
    ** Delete Cf group type with cfgtclasstemplates and cfgtvalues
    */
    public function deleteCfGroupType()
    {
        if ($this->cf_group_type_id > 0) {
            if ($this->cfgtclasstemplates && $this->cfgtclasstemplates->count() > 0) {
                foreach ($this->cfgtclasstemplates as $cfgtclasstemplateModel) {
                    $cfgtclasstemplateModel->deleteCfGroupCT();
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
