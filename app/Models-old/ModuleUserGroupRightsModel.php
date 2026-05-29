<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Auth;

use App\Models\ModuleModel;
use App\Models\AdminModel;

class ModuleUserGroupRightsModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'module_user_group_rights';

    protected $primaryKey = 'm_u_g_a_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_id',
        'u_g_id',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'm_u_g_a_id',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function module()
    {
        return $this->belongsTo(ModuleModel::class, 'module_id');
    }

    public function createdby()
    {
        return $this->belongsTo(AdminModel::class, 'created_id');
    }

    public function updatedby()
    {
        return $this->belongsTo(AdminModel::class, 'updated_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */

    public static function checkPermissionRight($controller_name)
    {
        $data['success'] = true;
        $module_id = ModuleModel::getModuleIdByClasname($controller_name);
        if ($module_id > 0) {
            $u_id = (Auth::check()) ? Auth::user()->u_id : 0;

            $userModules = 0;
            $isModuleSet = $hasModuleAccessRights = false;
            $modules = ModuleUserGroupRightsModel::where(['module_id' => $module_id])->count();
            if ($u_id > 0) {
                $groups = Auth::user()->groups->pluck('u_g_id')->toArray();
                if (count($groups) > 0)
                    $userModules = ModuleUserGroupRightsModel::where(['module_id' => $module_id])->whereIn('u_g_id', $groups)->count();
            }
            $isModuleSet             = $modules > 0 ? true : $isModuleSet;
            $hasModuleAccessRights     = $userModules > 0 ? true : $hasModuleAccessRights;

            if ($isModuleSet) {
                if ($hasModuleAccessRights)
                    $data['success'] = true;
                else {
                    $data['success'] = false;
                    $data['redirectURL'] = $u_id > 0 ? abort(403, 'Restricted Module access. Please contact system administrator.') : route('web.login');
                }
            }
        }
        return $data;
    }
}
