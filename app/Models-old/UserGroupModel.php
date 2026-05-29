<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\AdminModel;

class UserGroupModel extends Model
{

    protected $table = 'user_group';

    protected $primaryKey = 'u_g_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_name',
        'descp',
        'c_order',
        'updated_id',
    ];

    protected $guarded = [
        'u_g_id',
    ];


    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function updatedby()
    {
        return $this->belongsTo(AdminModel::class, 'updated_id');
    }

    public static function getUserGroupList($fltrArr = false, $fields = false, $orderBy = false, $order = false)
    {
        if ($fields == false) {
            $fields = ['u_g_id', 'group_name'];
        }

        $query = UserGroupModel::select($fields);

        $u_g_id_in = isset($fltrArr['u_g_id_in']) ? $fltrArr['u_g_id_in'] : "";

        if ($u_g_id_in) {
            $query->whereIn('u_g_id', $u_g_id_in);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'group_name';
            $order = 'ASC';
        }

        return $query->orderBy($orderBy, $order)->get();
    }

    public static function usersList()
    {
        $fields = "u_id, CONCAT(" . addcslashes('CONCAT_WS(" ", f_name, l_name)', "'") . ", ' (', email, ')') AS fullinfo";

        $query = User::selectRaw($fields);

        return $query->orderBy('fullinfo', 'ASC')->get();
    }
}
