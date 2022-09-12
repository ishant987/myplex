<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Lib\Core\Core;

use App\Models\AdminModel;

class FundSuggestion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fund_suggestion';

    protected $primaryKey = 'fs_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'file',
        'c_order',
        'status',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'fs_id',
    ];


    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = FundSuggestion::select($fields);

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'fs_id';
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
        $query = FundSuggestion::select($fields);

        $fs_id = isset($filterArr['fs_id']) ? intval($filterArr['fs_id']) : 0;
        if ($fs_id > 0) {
            $query->where('fs_id', '=', $fs_id);
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

        return ["view_txt" => __('admin.view_txt'), "target" => $commonconstants['target_opt1'], "media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name'])];
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
