<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corpus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'corpus';

    protected $primaryKey = 'corpus_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'fund',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'corpus_id',
    ];


    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = Corpus::select($fields);

        $fundId = isset($filterArr['fund_id']) ? $filterArr['fund_id'] : 0;
        if($fundId > 0){
            $query->where('fund_id', '=', $fundId);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'corpus_id';
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
