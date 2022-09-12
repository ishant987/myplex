<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundCore extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fund_core';

    protected $primaryKey = 'fc_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'cor',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'fc_id',
    ];


    public static function list($fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = FundCore::select($fields);

        if ($orderBy == false && $order == false) {
            $orderBy = 'fc_id';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */
}
