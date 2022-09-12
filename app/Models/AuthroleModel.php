<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\ModuleMethodModel;
use App\Models\RoleModuleMethodRightsModel;
use App\Models\AuthroleModuleRightsModel;
use App\Models\AdminModel;

class AuthroleModel extends Model
{    
	/**
	* The table associated with the model.
	*
	* @var string
	*/
	protected $table = 'auth_roles';

	protected $primaryKey = 'role_id';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [  
		'title', 
		'info',
		'updated_id'
	];

	protected $guarded = [       
		'role_id',
	];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function rolerights(){
    	return $this->hasMany(AuthroleModuleRightsModel::class);
    }

    public function updatedby(){
    	return $this->belongsTo(AdminModel::class, 'updated_id');
    }

    public function saveMethodRights($role_id,$method_id_Arr)
    {
    	DB::beginTransaction();
    	RoleModuleMethodRightsModel::where('role_id','=',$role_id)->delete();
    	//DB::enableQueryLog(); // Enable query log

    	if(count($method_id_Arr)>0)
    	{
	    	foreach ($method_id_Arr as $method_id) 
	    	{
	    		$methodModel = ModuleMethodModel::find($method_id);
	    		if($methodModel)
	    		{
	    			$route_link = $methodModel->route_link;
	    			$module_id 	= $methodModel->module_id;
	    			$rightsModel = RoleModuleMethodRightsModel::withTrashed()->where(['role_id'=>$role_id,'module_id'=>$module_id,'method_id'=>$method_id])->first();
	    			if($rightsModel && !empty($rightsModel))
	    			{
	    				$rightsModel->deleted_at = NULL;
	    				$rightsModel->save();
	    				self::saveLinkedMethdRights($role_id,$route_link);
	    			}
	    			else
	    			{
	    				$rightsModel = New RoleModuleMethodRightsModel();
	    				$rightsModel->role_id 	= $role_id;
	    				$rightsModel->module_id = $module_id;
	    				$rightsModel->method_id = $method_id; 
	    				$rightsModel->save(); 
	    				self::saveLinkedMethdRights($role_id,$route_link); 
	    			}
	    		}
	    	}
	    }
	    $userrole = AuthroleModel::find($role_id);
	    $userrole->updated_id = auth()->guard('admin')->user()->admin_id;
	    $userrole->updated_at = now();
	    $userrole->update();
    	// dd(DB::getQueryLog()); // Show results of log
    	DB::commit();
    }

    public function saveLinkedMethdRights($role_id,$route_link)
    {
    	$methodModels = ModuleMethodModel::where(['affected_route_link'=>$route_link])->get();
    	foreach ($methodModels as $methodModel) 
    	{
    		$module_id 	= $methodModel->module_id;
    		$method_id 	= $methodModel->method_id;
    		$rightsModel = RoleModuleMethodRightsModel::withTrashed()->where(['role_id'=>$role_id,'module_id'=>$module_id,'method_id'=>$method_id])->first();
    		if($rightsModel && !empty($rightsModel))
			{
				$rightsModel->deleted_at = NULL;
				$rightsModel->save();
			}
			else
			{
				$rightsModel = New RoleModuleMethodRightsModel();
				$rightsModel->role_id 	= $role_id;
				$rightsModel->module_id = $module_id;
				$rightsModel->method_id = $method_id; 
				$rightsModel->save();  
			}
    	}
    }
}
