<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\MediaModel;

class KnowTheRatio extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'know_the_ratio';

    protected $primaryKey = 'ktr_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'media_id',
        'status',
        'c_order',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'ktr_id',
    ];


    public function media()
    {
        return $this->hasOne(MediaModel::class, 'media_id', 'media_id');
    }

    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = KnowTheRatio::with('media')->select($fields);

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'ktr_id';
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
}
