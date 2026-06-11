<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\AuthroleModel;
use App\Models\ModuleModel;
use App\Models\MethodModel;

class RoleModuleMethodRightsModel extends Model
{
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'role_module_method_rights';

	protected $primaryKey = 'role_module_method_right_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'role_id',
		'module_id',
		'method_id',
		'deleted_at'
	];

	protected $guarded = [
		'role_module_method_right_id',
	];

	public function role()
	{
		return $this->hasOne(AuthroleModel::class, 'module_id', 'module_id');
	}

	public function module()
	{
		return $this->hasOne(ModuleModel::class, 'module_id', 'module_id');
	}

	public function method()
	{
		return $this->hasOne(MethodModel::class, 'module_id', 'module_id');
	}
}
