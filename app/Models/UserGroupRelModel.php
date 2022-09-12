<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\UserGroupModel;
use App\Models\User;

class UserGroupRelModel extends Model
{
    use SoftDeletes;

    protected $table = 'user_group_rel';

    protected $primaryKey = 'u_g_r_id';

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
        'u_id',
        'updated_id',
    ];

    protected $guarded = [
        'u_g_r_id',
    ];


    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getUserGroupRelList($fltrArr = false, $fields = false, $orderBy = false, $order = false)
    {
        if ($fields == false) {
            $fields = ['u_g_id'];
        }

        $query = UserGroupRelModel::select($fields);

        $with = isset($fltrArr['with']) ? $fltrArr['with'] : "";

        if ($with) {
            $query->with('usergroup');
        }

        $u_id = isset($fltrArr['u_id']) ? $fltrArr['u_id'] : "";

        if ($u_id) {
            $query->where('u_id', '=', $u_id);
        }

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

    public static function getUserGroupRelData($userId, $userGroupId, $fields = false)
    {
        if ($fields == false) {
            $fields = ["*"];
        }
        return UserGroupRelModel::withTrashed()->select($fields)->where(['u_id' => $userId, 'u_g_id' => $userGroupId])->first();
    }

    public static function getUserGroupRelData2($userId, $userGroupId, $fields = false)
    {
        if ($fields == false) {
            $fields = ["*"];
        }
        $dataArr = UserGroupRelModel::select($fields)->where(['u_id' => $userId, 'u_g_id' => $userGroupId])->first();

        return $dataArr;
    }

    public static function getUserGroupRelUsersList($fltrArr = false, $fields = false, $orderBy = false, $order = false)
    {
        if ($fields == false) {
            $fields = ['u_id'];
        }

        $query = UserGroupRelModel::select($fields)->with('usergroup');

        $u_g_id = isset($fltrArr['u_g_id']) ? $fltrArr['u_g_id'] : "";

        if ($u_g_id) {
            $query->where('u_g_id', '=', $u_g_id);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'u_id';
            $order = 'ASC';
        }

        return $query->orderBy($orderBy, $order)->get();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'u_id', 'u_id')->selectRaw("u_id, CONCAT(" . addcslashes('CONCAT_WS(" ", f_name, l_name)', "'") . ", ' (', email, ')') AS fullinfo");
    }
}
