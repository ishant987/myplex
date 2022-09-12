<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

use App\Models\AuthroleModel;
use Illuminate\Support\Facades\Hash;

class AdminModel extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'username',
        'password',
        'display_name',
        'first_name',
        'last_name',
        'email',
        'website',
        'status',
        'updated_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = [
        'admin_id',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function role()
    {
        return $this->hasOne(AuthroleModel::class, 'role_id', 'role_id');
    }

    public function updatedby()
    {
        return $this->belongsTo(AdminModel::class, 'updated_id');
    }

    public static function getRoleList()
    {
        return AuthroleModel::pluck('title', 'role_id')->toArray();
    }

    public static function verifySecret($adminId, $secret)
    {
        // \DB::enableQueryLog();
        $dtMdl = AdminModel::select('admin_id', 'secret')->where(['admin_id' => $adminId, 'status' => 1])->first();
        if($dtMdl){
            $newSecret = Hash::check($secret, $dtMdl->secret);
            if ($newSecret) {
                return $dtMdl->admin_id;
            } else {
                return 0;
            }
        }
        // $dtMdl = \DB::getQueryLog();
        // dd($dtMdl);
    }
}
