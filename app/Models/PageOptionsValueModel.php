<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\MediaModel;

class PageOptionsValueModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pg_optns_value';

    protected $primaryKey = 'pg_optn_value_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'pg_option_id',
        'field_value',
        'field_type',
        'field_name',
        'updated_id'
    ];

    protected $guarded = [
        'pg_optn_value_id'
    ];


    public static function getPageCustomFields($dataId, $fields = false)
    {
        if ($fields == false) {
            $fields = ['field_type', 'field_value'];
        }
        return PageOptionsValueModel::with('media')->select($fields)->where('page_id', "=", $dataId)->get();
    }

    public function media()
    {
        return $this->hasOne(MediaModel::class, 'media_id', 'field_value');
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
