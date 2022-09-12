<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ModuleClassTemplatesModel;
use App\Models\CustomFieldGroupTypeClassTemplateModel;
use App\Models\AdminModel;

use App\Lib\App\Common;

class TemplateModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'template';

    protected $primaryKey = 'template_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'descp',
        'c_order',
        'status',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'template_id',
    ];

    public function setTitleAttribute($value)
    {
        $reqSlug        = strtolower($value);
        $this->attributes['title'] = $value;
        if (!$this->template_id) {
            $this->attributes['slug'] = Common::generateSlug($reqSlug, 'template');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function classtemplate()
    {
        return $this->belongsTo(ModuleClassTemplatesModel::class, 'template_id', 'template_id');
    }

    public function cfgtclasstemplates()
    {
        return $this->hasMany(CustomFieldGroupTypeClassTemplateModel::class, 'template_id', 'template_id');
    }

    public function createdby()
    {
        return $this->belongsTo(AdminModel::class, 'created_id');
    }

    public function updatedby()
    {
        return $this->belongsTo(AdminModel::class, 'updated_id');
    }

    public static function getTemplateAssoc($class_id)
    {
        if ($class_id > 0) {
            $templateModel =  TemplateModel::join('module_class_templates', 'module_class_templates.template_id', '=', 'template.template_id')
                ->where(['module_class_templates.class_id' => $class_id, 'template.status' => 1])
                ->orderBy('template.title', 'asc')
                ->pluck('template.title', 'template.template_id');
            if ($templateModel) {
                return $templateModel;
            }
        }
        return false;
    }

    public function saveTemplateClass()
    {
        if ($this->template_id > 0 && $this->class_id > 0) {
            $loggedUserID = auth()->guard('admin')->user()->admin_id;
            $moduleClassTemplateModel = ModuleClassTemplatesModel::where(['template_id' => $this->template_id])->first();
            if ($moduleClassTemplateModel) {
                if ($moduleClassTemplateModel->class_id != $this->class_id) {
                    #==Reset tables (custom fields) ==#
                    $this->flushCustomFieldsData();

                    #==Update the new class_id ==#
                    $moduleClassTemplateModel->class_id     = $this->class_id;
                    $moduleClassTemplateModel->updated_id     = $loggedUserID;
                    if ($moduleClassTemplateModel->save()) {
                        return $moduleClassTemplateModel->module_template_id;
                    }
                } else {
                    return $moduleClassTemplateModel->module_template_id;
                }
            } else {
                $moduleClassTemplateModel = new ModuleClassTemplatesModel;
                $moduleClassTemplateModel->class_id     = $this->class_id;
                $moduleClassTemplateModel->template_id     = $this->template_id;
                $moduleClassTemplateModel->created_id     = $loggedUserID;
                $moduleClassTemplateModel->updated_at     = NULL;
                if ($moduleClassTemplateModel->save()) {
                    return $moduleClassTemplateModel->module_template_id;
                }
            }
        }
        return false;
    }

    #== Flush All related template data ==#
    public function flushData()
    {
        if (isset($this->classtemplate) && $this->classtemplate->template_id > 0) {
            if ($this->classtemplate->delete()) {
                $this->flushCustomFieldsData();
            }
        }
    }

    #== Flush related template sustom fields datas one by one ==#
    public function flushCustomFieldsData()
    {
        if (isset($this->cfgtclasstemplates) && $this->cfgtclasstemplates->count() > 0) {
            foreach ($this->cfgtclasstemplates as $cfgtclasstemplate) {
                #==delete custom group type values one by one==#
                if (isset($cfgtclasstemplate->cfgtvalues) && $cfgtclasstemplate->cfgtvalues->count() > 0) {
                    foreach ($cfgtclasstemplate->cfgtvalues as $cfgtvalue) {
                        $cfgtvalue->delete();
                    }
                }
                #==Delete the group type class template relation table ==#
                $cfgtclasstemplate->delete();
            }
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
    public function getTemplateByID($value = '')
    {
        if ($this->template_id) {
            $query = TemplateModel::where(['template_id' => $this->template_id]);
            if ($value) {
                $query = $query->value($value);
            } else {
                $query->first();
            }
            return $query;
        }
        return false;
    }
}
