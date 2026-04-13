<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleClassModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'module_class';

    protected $primaryKey = 'class_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_name',
        'slug',
        'info',
        'status'
    ];

    protected $guarded = [
        'class_id',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getClassAssoc()
    {
        $moduleClassesModel =  ModuleClassModel::join('modules', 'modules.class_id', '=', 'module_class.class_id')
            ->where(['modules.has_templates' => 'y', 'modules.status' => 1, 'module_class.status' => 1])
            ->orderBy('module_class.class_name', 'asc')
            ->pluck('module_class.class_name', 'module_class.class_id');
        if ($moduleClassesModel) {
            return $moduleClassesModel;
        }
        return false;
    }



    #== Get class ID by class name ==#

    public static function getClassIdByname($class_name)
    {
        return ModuleClassModel::where(['class_name' => $class_name, 'status' => 1])->value('class_id');
    }

    #== Get class ID by model name ==#
    public static function getClassIdBymodel($model_name)
    {
        return ModuleClassModel::where(['model_name' => $model_name, 'status' => 1])->value('class_id');
    }

    public static function getClassModel($class_id)
    {
        $class_name = ModuleClassModel::where(['class_id' => $class_id, 'status' => 1])->value('class_name');
        if ($class_name) {
            $moduleName = current(explode('Controller', $class_name));
            // return '\\App\\' . '\\Models\\' . $moduleName . 'Model';
            return '\App\Models\\' . $moduleName . 'Model';
        }
        return false;
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
