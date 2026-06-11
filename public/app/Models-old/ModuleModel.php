<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ModuleClassModel;
use App\Models\ModuleMethodModel;

class ModuleModel extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'modules';

  protected $primaryKey = 'module_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'class_id',
    'has_templates',
    'set_user_rights',
    'title',
    'label',
    'info',
    'class_name',
    'is_menu',
    'c_order',
    'parent_module_id',
    'status'
  ];

  protected $guarded = [
    'module_id',
  ];



  public function moduleclass()
  {
    return $this->belongsTo(ModuleClassModel::class, 'class_id');
  }

  public function modulemethods()
  {
    return $this->hasMany(ModuleMethodModel::class, 'module_id', 'module_id')->where('is_left_nav', '=', 1)->orderBy('c_order', 'asc');
  }

  public function modulechildren()
  {
    return $this->hasMany(ModuleModel::class, 'parent_module_id');
  }

  public function getPermissionableModuleMethods($role_id)
  {
    if ($this->module_id) {
      return ModuleMethodModel::join('role_module_method_rights', 'role_module_method_rights.method_id', '=', 'module_methods.method_id')
        ->where([
          'module_methods.module_id' => $this->module_id,
          'role_module_method_rights.role_id' => $role_id,
          'role_module_method_rights.deleted_at' => NULL,
          'module_methods.is_left_nav' => 1
        ])
        ->orderBy('module_methods.c_order', 'asc')
        ->get(['module_methods.*']);
    }
    return false;
  }

  public function getModuleMethods($role_id = 0)
  {
    if ($this->module_id) {
      $query =  ModuleMethodModel::where(['module_id' => $this->module_id, 'affected_route_link' => NULL]);
      if ($role_id != 1) {
        $query->where(['access_role_id' => 0]);
      }
      return $query->get();
    }
    return false;
  }

  /*public function getAccessibleTemplateModules()
     {
        $query =  ModuleModel::where(['has_templates'=>'y','status'=>1])
                  ->orderBy('module_methods.c_order', 'asc')
                  ->get(['module_methods.*']);
     }*/

  public static function getModuleIdByClasname($class_name)
  {
    return ModuleModel::join('module_class', 'modules.class_id', '=', 'module_class.class_id')
      ->where([
        'module_class.class_name' => $class_name,
        'module_class.status' => 1
      ])
      ->orderBy('modules.c_order', 'asc')
      ->value('module_id');
  }

  public static function getModuleIdByClasId($class_id)
  {
    return ModuleModel::where(['class_id' => $class_id])->value('module_id');
  }
}
