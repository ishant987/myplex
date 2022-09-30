<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Lib\Core\Core;

use App\Models\AdminModel;

class FundWatch extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fund_watch';

    protected $primaryKey = 'fw_id';

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
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'fw_id',
    ];


    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = FundWatch::select($fields);

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'fw_id';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public static function getData($filterArr = false, $fields = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = FundWatch::select($fields);

        $fw_id = isset($filterArr['fw_id']) ? intval($filterArr['fw_id']) : 0;
        if ($fw_id > 0) {
            $query->where('fw_id', '=', $fw_id);
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

    public static function archiveGroupList()
    {
        $commonconstants = Config('commonconstants');

        // \DB::enableQueryLog(); // Enable query log
        return FundWatch::selectRaw('DATE_FORMAT(created_at, "%Y") AS year, COUNT(fw_id) AS tot')->where(['status' => $commonconstants['status_val'][1]])->groupByRaw('year')->orderByRaw('year DESC')->get();
        // dd(\DB::getQueryLog()); // Show results of log

        // return $dataObj;
    }

    public static function frontList($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        $commonconstants = Config('commonconstants');

        if ($fields == false) {
            $fields = ['fw_id', 'title', 'description', 'created_at'];
        }
        $query = FundWatch::select($fields)->where(['status' => $commonconstants['status_val'][1]]);

        $year = isset($filterArr['year']) ? $filterArr['year'] : null;
        if ($year != null) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y") =' . $year);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'created_at';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        $dtListArr = $perPage ? $query->paginate($perPage) : $query->get();

        $random = isset($filterArr['random']) ? intval($filterArr['random']) : 0;
        if ($random > 0) {
            $dtListArr = $dtListArr->random($random);
        }

        $take = isset($filterArr['take']) ? intval($filterArr['take']) : 0;
        if ($take > 0) {
            $dtListArr = $dtListArr->take($take);
        }

        return $dtListArr;
    }
}
