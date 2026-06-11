<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\UserGroupModel;

class ModuleUserGroupRelModel extends Model
{
    use SoftDeletes;

    protected $table = 'module_user_group_rel';

    protected $primaryKey = 'm_u_g_r_id';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'u_g_id',
        'type',
        'data_id',
        'updated_id',
    ];

    protected $guarded = [
        'm_u_g_r_id',
    ];


    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getModuleUserGroupRelList($fltrArr = false, $fields = false, $orderBy = false, $order = false)
    {
        if ($fields == false) {
            $fields = ['u_g_id'];
        }

        $query = ModuleUserGroupRelModel::select($fields)->with('usergroup')->where(['type' => $fltrArr['type'], 'data_id' => $fltrArr['data_id']]);

        if ($orderBy == false && $order == false) {
            $orderBy = 'u_g_id';
            $order = 'ASC';
        }

        return $query->orderBy($orderBy, $order)->get();
    }

    public function usergroup()
    {
        return $this->hasOne(UserGroupModel::class, 'u_g_id', 'u_g_id');
    }

    public static function getModuleUserGroupRelData($fltrArr, $fields = false)
    {
        if ($fields == false) {
            $fields = ["*"];
        }
        return ModuleUserGroupRelModel::withTrashed()->select($fields)->where(['type' => $fltrArr['type'], 'data_id' => $fltrArr['data_id'], 'u_g_id' => $fltrArr['u_g_id']])->first();
    }
}
