<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scrips extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scrips';

    protected $primaryKey = 'scrp_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scrip_name',
        'type',
        'industry',
        'actual_scrip',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'scrp_id',
    ];


    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = Scrips::select($fields);

        $scripName = isset($filterArr['scrip_name']) ? $filterArr['scrip_name'] : null;
        $query->where('scrip_name', '=', $scripName);

        if ($orderBy == false && $order == false) {
            $orderBy = 'scrp_id';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public static function getData($filterArr = false, $fields = false)
    {
        // \DB::enableQueryLog();

        if ($fields == false) {
            $fields = ['*'];
        }
        $query = Scrips::select($fields);

        $scripName = isset($filterArr['scrip_name']) ? $filterArr['scrip_name'] : null;
        if($scripName != '' && $scripName != null){
            $query->where('scrip_name', '=', $scripName);
        }

        $scripNameLike = isset($filterArr['scrip_name_like']) ? $filterArr['scrip_name_like'] : null;
        $query->where('scrip_name', 'like', $scripNameLike.'%');

        return $query->get()->first();
        // $query->get()->first();
        // $quries = \DB::getQueryLog();
        // dd($quries);
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

    public function scopeSearch($query, $fltrDataArr)
    {
        if (empty($fltrDataArr)) {
            return $query;
        } else {
            $scripName = $fltrDataArr['scrip_name'] ?? '';
            if ($scripName) {
                $query->where('scrip_name', 'LIKE', "%{$scripName}%");
            }
            $type = $fltrDataArr['type'] ?? '';
            if ($type) {
                $query->where('type', $type);
            }
            $industry = $fltrDataArr['industry'] ?? '';
            if ($industry) {
                $query->where('industry', $industry);
            }
            $actualScrip = $fltrDataArr['actual_scrip'] ?? '';
            if ($actualScrip) {
                $query->where('actual_scrip', 'LIKE', "%{$actualScrip}%");
            }

            $dbDtFrmt = Config('commonconstants.y_m_d_frmt');

            $updatedAt = $fltrDataArr['updated_at'] ?? '';
            if ($updatedAt) {
                $updatedAtArr = explode(" - ", $updatedAt);
                if (!empty($updatedAtArr)) {
                    $uaStartDate = date($dbDtFrmt, strtotime($updatedAtArr[0])) . ' 00:00:00';
                    $uaEndDate = date($dbDtFrmt, strtotime($updatedAtArr[1])) . ' 23:59:59';
                }
                $query->whereBetween('updated_at', [$uaStartDate, $uaEndDate]);
            }
        }
        return $query;
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
