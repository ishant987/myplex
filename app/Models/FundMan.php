<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\MediaModel;

class FundMan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fund_man';

    protected $primaryKey = 'fm_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'media_id',
        'designation',
        'company_name',
        'synopsis',
        'description',
        'disclaimer',
        'disclaimer_note',
        'status',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'fm_id',
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
        $query = FundMan::select($fields);

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        $dataIdNotIn = isset($filterArr['data_id_not_in']) ? intval($filterArr['data_id_not_in']) : 0;
        if ($dataIdNotIn > 0) {
            $query->whereNotIn('fm_id', [$dataIdNotIn]);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'fm_id';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        $dtListArr = $perPage ? $query->paginate($perPage) : $query->get();

        $take = isset($filterArr['take']) ? intval($filterArr['take']) : 0;
        if ($take > 0) {
            $dtListArr = $dtListArr->take($take);
        }

        return $dtListArr;
    }

    public static function getData($filterArr = false, $fields = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = FundMan::select($fields);

        $slug = isset($filterArr['slug']) ? $filterArr['slug'] : '';
        if ($slug) {
            $query->where('slug', '=', $slug);
        }
        $fm_id = isset($filterArr['fm_id']) ? intval($filterArr['fm_id']) : 0;
        if ($fm_id > 0) {
            $query->where('fm_id', '=', $fm_id);
        }
        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        return $query->get()->first();
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

    public static function getModuleVars()
    {
        $commonconstants = Config('commonconstants');

        return ["view_txt" => __('admin.view_txt'), "target" => $commonconstants['target_opt1']];
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
