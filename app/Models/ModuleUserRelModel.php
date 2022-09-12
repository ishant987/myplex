<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class ModuleUserRelModel extends Model
{
    use SoftDeletes;

    protected $table = 'module_user_rel';

    protected $primaryKey = 'mur_id';

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
        'u_id',
        'type',
        'data_id',
        'updated_id',
    ];

    protected $guarded = [
        'mur_id',
    ];


    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getModuleUserRelList($fltrArr = false, $fields = false, $orderBy = false, $order = false)
    {
        if ($fields == false) {
            $fields = ['mur_id', 'u_id'];
        }

        $query = ModuleUserRelModel::select($fields)->with('users')->where(['type' => $fltrArr['type'], 'data_id' => $fltrArr['data_id']]);

        if ($orderBy == false && $order == false) {
            $orderBy = 'mur_id';
            $order = 'ASC';
        }

        return $query->orderBy($orderBy, $order)->get();
    }

    public function users()
    {
        return $this->hasOne(User::class, 'u_id', 'u_id');
    }

    public static function getModuleUserRelData($fltrArr, $fields = false)
    {
        if ($fields == false) {
            $fields = ["*"];
        }
        return ModuleUserRelModel::withTrashed()->select($fields)->where(['type' => $fltrArr['type'], 'data_id' => $fltrArr['data_id'], 'u_id' => $fltrArr['u_id']])->first();
    }
}
