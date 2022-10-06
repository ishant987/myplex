<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Auth;

use App\Models\ModuleModel;
use App\Models\AdminModel;

class UserGroupPagedataAccessModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_group_pagedata_access';

    protected $primaryKey = 'u_g_pd_a_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_id',
        'u_g_id',
        'data_id',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'u_g_pd_a_id',
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

    public static function hasPageAccess($class_id, $data_id)
    {
        $data['success'] = true;
        if ($class_id > 0 && $data_id > 0) {
            $module_id = ModuleModel::getModuleIdByClasId($class_id);
            if ($module_id > 0) {
                $u_id = (Auth::check()) ? Auth::user()->u_id : 0;

                $userModulePages = 0;
                $isModulePageSet = $hasPageAcces = false;

                $modulePages = UserGroupPagedataAccessModel::where(['module_id' => $module_id, 'data_id' => $data_id])->count();

                if ($u_id > 0) {
                    $groups = Auth::user()->groups->pluck('u_g_id')->toArray();
                    if (count($groups) > 0)
                        $userModulePages = UserGroupPagedataAccessModel::where(['module_id' => $module_id, 'data_id' => $data_id])->whereIn('u_g_id', $groups)->count();
                }

                $isModulePageSet     = $modulePages > 0 ? true : $isModulePageSet;
                $hasPageAcces         = $userModulePages > 0 ? true : $hasPageAcces;

                if ($isModulePageSet) {
                    if ($hasPageAcces)
                        $data['success'] = true;
                    else {
                        $data['success'] = false;
                        $data['redirectURL'] = $u_id > 0 ? abort(403, 'Restricted page access. Please contact system administrator.') : route('web.login');
                    }
                }
            }
        }
        return $data;
    }
}
