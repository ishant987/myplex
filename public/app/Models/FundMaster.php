<?php

namespace App\Models;

use App\Lib\Admin\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;

use App\Models\AdminModel;
use App\Models\FundTerm;
use App\Models\FundType;
use App\Models\IndicesMaster;
use App\Models\FundCore;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FundMaster extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fund_master';

    protected $primaryKey = 'fund_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_name',
        'fund_code',
        'fund_manager',
        'fund_type_id',
        'fund_term_id',
        'face_value',
        'risk_free_return',
        'fund_opened',
        'period',
        'remarks',
        'cost',
        'indices_name',
        'fund_house',
        'classification',
        'status',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'fund_id',
    ];


    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }

        $with = isset($filterArr['with']) ? $filterArr['with'] : '';
        if ($with == 'yes') {
            $query = FundMaster::with(['fundtype', 'fundterm'])->select($fields);
        } elseif (is_array($with)) {
            $query = FundMaster::with($with)->select($fields);
        } else {
            $query = FundMaster::select($fields);
        }

        $fundCode = isset($filterArr['fund_code']) ? $filterArr['fund_code'] : '';
        if ($fundCode != '') {
            $query->where('fund_code', '=', $fundCode);
        }

        $fundTypeId = isset($filterArr['fund_type_id']) ? $filterArr['fund_type_id'] : '';
        if ($fundTypeId != '') {
            $query->where('fund_type_id', '=', $fundTypeId);
        }

        $fund_house = isset($filterArr['fund_house']) ? $filterArr['fund_house'] : '';
        if ($fund_house != '') {
            $query->where('fund_house', '=', $fund_house);
        }

        $classification = isset($filterArr['classification']) ? $filterArr['classification'] : '';
        if ($classification != '') {
            $query->where('classification', '=', $classification);
        }

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'fund_id';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
		/*$query->limit(2);*/
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public static function getData($filterArr = false, $fields = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = FundMaster::select($fields);

        $fundCode = isset($filterArr['fund_code']) ? $filterArr['fund_code'] : null;
        if ($fundCode != '' && $fundCode != null) {
            $query->where('fund_code', '=', $fundCode);
        }

        $fundName = isset($filterArr['fund_name']) ? $filterArr['fund_name'] : null;
        if ($fundName != '' && $fundName != null) {
            $query->where('fund_name', '=', $fundName);
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

    public function fundtype()
    {
        return $this->hasOne(FundType::class, 'ft_id', 'fund_type_id');
    }

    public function fundterm()
    {
        return $this->hasOne(FundTerm::class, 'ftm_id', 'fund_term_id');
    }

    public function fundcore()
    {
        return $this->hasOne(FundCore::class, 'fund_id', 'fund_id');
    }

    public static function getAllFundHouses()
    {
        $dtArr = [];
        $dtList = FundMaster::select('fund_house')->where('status', '=', Config('commonconstants.status_val.1'))->where('fund_house', '!=', 'NULL')->orWhere('fund_house', '!=', '')->distinct()->orderBy('fund_house', 'ASC')->get();
        if ($dtList) {
            $dtArr = Arr::flatten($dtList->toArray());
        }
        return json_encode($dtArr);
    }

    public static function getModuleVars()
    {
        return ["fund_type_list" => FundType::list(['ft_id', 'name']), "fund_term_list" => FundTerm::list(['ftm_id', 'term']), "index_list" => IndicesMaster::list(['status' => Config('commonconstants.status_val.1')], ['idc_id', 'name']), "fund_house_list" => self::getAllFundHouses(), 'status_list' => App::getStatusLblTyp2Atr()];
    }

    public function scopeSearch($query, $fltrDataArr)
    {
        if (empty($fltrDataArr)) {
            return $query;
        } else {
            $fundName = $fltrDataArr['fund_name'] ?? '';
            if ($fundName) {
                $query->where('fund_name', 'LIKE', "%{$fundName}%");
            }
            $fundCode = $fltrDataArr['fund_code'] ?? '';
            if ($fundCode) {
                $query->where('fund_code', $fundCode);
            }
            $fundTypeId = $fltrDataArr['fund_type_id'] ?? '';
            if ($fundTypeId > 0) {
                $query->where('fund_type_id', $fundTypeId);
            }
            $fundTermId = $fltrDataArr['fund_term_id'] ?? '';
            if ($fundTermId > 0) {
                $query->where('fund_term_id', $fundTermId);
            }
            $status = isset($fltrDataArr['status']) ? intval($fltrDataArr['status']) : 0;
            if ($status > 0) {
                $query->where('status', $status);
            }

            $dbDtFrmt = Config('commonconstants.y_m_d_frmt');

            $fundOpened = $fltrDataArr['fund_opened'] ?? '';
            if ($fundOpened) {
                $fundOpenedArr = explode(" - ", $fundOpened);
                if (!empty($fundOpenedArr)) {
                    $foStartDate = date($dbDtFrmt, strtotime($fundOpenedArr[0]));
                    $foEndDate = date($dbDtFrmt, strtotime($fundOpenedArr[1]));
                }
                $query->whereBetween('fund_opened', [$foStartDate, $foEndDate]);
            }
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

    public static function noCorlist()
    {
        $dbPrfx = DB::getTablePrefix();

        return FundMaster::with('fundtype', 'fundterm')->where('status', '=', Config('commonconstants.status_val.1'))
            ->whereNotExists(function ($query) use ($dbPrfx) {
                $query->select(DB::raw(1))
                    ->from('fund_core')
                    ->whereRaw($dbPrfx . 'fund_master.fund_id = ' . $dbPrfx . 'fund_core.fund_id');
            })->get();
    }


    public function getOpeningDateAttribute()
    {
        $commonconstants = Config('commonconstants');
        return $this->fund_opened ? Carbon::parse($this->fund_opened)->format($commonconstants['d_m_y_frmt2']) : 'NA';
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
