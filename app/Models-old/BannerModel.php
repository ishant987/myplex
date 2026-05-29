<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\MediaModel;
use App\Models\AdminModel;

class BannerModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banner';

    protected $primaryKey = 'bnr_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bnr_group',
        'media_id',
        'title',
        'descp',
        'link',
        'link_text',
        'link_target',
        'c_order',
        'status',
        'updated_id'
    ];

    protected $guarded = [
        'bnr_id',
    ];


    public function media()
    {
        return $this->hasOne(MediaModel::class, 'media_id', 'media_id');
    }

    public static function bannerList($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = BannerModel::with('media')->select($fields);

        $bannerGroup = isset($filterArr['bnr_group']) ? $filterArr['bnr_group'] : null;
        $query->where('bnr_group', '=', $bannerGroup);

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'bnr_id';
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

    public static function getBannerGroup()
    {
        return BannerModel::groupBy('bnr_group')->pluck('bnr_group')->toArray();
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
