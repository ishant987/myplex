<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\ModuleClassModel;

class ModuleClassTemplatesModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'module_class_templates';

    protected $primaryKey = 'module_template_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
        'template_id',
        'created_id',
        'updated_id',
    ];

    protected $guarded = [
        'module_template_id',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function moduleclass()
    {
        return $this->belongsTo(ModuleClassModel::class, 'class_id');
    }

    public function createdby()
    {
        return $this->belongsTo(AdminModel::class, 'created_id');
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
