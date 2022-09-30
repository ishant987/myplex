<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\RoleModuleMethodRightsModel;
use App\Models\ModuleModel;

class ModuleMethodModel extends Model
{
   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'module_methods';

   protected $primaryKey = 'method_id';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'module_id',
      'title',
      'method_name',
      'route_link',
      'affected_route_link',
      'is_left_nav',
      'is_external_link',
      'c_order',
      'updated_id'
   ];

   protected $guarded = [
      'method_id',
   ];

   public function module()
   {
      return $this->hasOne(ModuleModel::class, 'module_id', 'module_id');
   }

   public function modulemethodrights()
   {
      return $this->hasMany(RoleModuleMethodRightsModel::class, 'method_id');
   }
}
