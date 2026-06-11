<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CurrencyDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currency_detail';

    protected $primaryKey = 'cd_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cm_id',
        'entry_date',
        'entry_value',
        'publish',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'cd_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getPublishReadyDate()
    {
        $dtMdl = CurrencyDetail::select('entry_date')->where('publish', 'n')->groupBy('entry_date')->orderBy('entry_date', 'asc')->get()->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }

    public static function getModuleVars()
    {
        $commonLang = __('common');

        return ["holiday" => [0 => $commonLang['yes_no_txt']['n'], 1 => $commonLang['yes_no_txt']['y']], "published" => ['n' => $commonLang['yes_no_txt']['n'], 'y' => $commonLang['yes_no_txt']['y']]];
    }

    public function createdby()
    {
        return $this->belongsTo(AdminModel::class, 'created_id');
    }

    public function adminList($fltrDataArr = false, $orderBy = false, $order = false, $perPage = false)
    {
        // DB::enableQueryLog(); // Enable query log

        $query = CurrencyDetail::select([
            'currency_detail.entry_date',
            'currency_detail.entry_value',
            'currency_detail.publish',
            'currency_detail.created_id',
            'currency_detail.created_at',
            'currency_master.cm_id',
            'currency_master.name AS cur_name',
        ])
            ->join('currency_master', 'currency_master.cm_id', '=', 'currency_detail.cm_id');

        $curName = isset($fltrDataArr['cur_name']) ? $fltrDataArr['cur_name'] : '';
        if ($curName != '') {
            $query->where('currency_master.name', '=', $curName);
        }
        $entryDate = $fltrDataArr['entry_date'] ?? '';
        if ($entryDate) {
            $query->where('entry_date', '=', $entryDate);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'cd_id';
            $order = 'DESC';
        }
        $query->orderBy($orderBy, $order);

        $dataObj = $perPage ? $query->paginate($perPage) : $query->get();

        // dd(DB::getQueryLog()); // Show results of log

        return $dataObj;
    }

    public static function missingList($fltrDataArr = false)
    {
        $startDate = $endDate = '';

        $missingDate = $fltrDataArr['missing_date'] ?? '';
        $currencyId = $fltrDataArr['currency_id'] ?? 0;
        if ($missingDate != '' && $currencyId > 0) {
            $missingDateArr = explode(" - ", $missingDate);
            if (!empty($missingDateArr)) {
                $startDate = $missingDateArr[0];
                $endDate = $missingDateArr[1];
            }
            return DB::select("CALL find_missing_date_currency('" . $currencyId . "', '" . $startDate . "', '" . $endDate . "')");
        } else {
            return [];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */

    public static function getLastPublishedDate($cm_id)
    {
        $dtMdl = CurrencyDetail::select('entry_date')->where('cm_id', $cm_id)->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }
    public static function getFirstPublishedDate($cm_id)
    {
        $dtMdl = CurrencyDetail::select('entry_date')->where('cm_id', $cm_id)->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'asc')->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }
}
