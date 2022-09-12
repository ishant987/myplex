<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FundDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fund_detail';

    protected $primaryKey = 'fd_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_code',
        'entry_date',
        'closing_nav',
        'holiday',
        'percentage_change',
        'publish',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'fd_id',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getActiveFunds()
    {
        return DB::select('CALL active_funds()');
    }

    public static function getPublishReadyDate()
    {
        $dtMdl = FundDetail::select('entry_date')->where('publish', 'n')->groupBy('entry_date')->orderBy('entry_date', 'asc')->get()->first();
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

    public function scopeSearch($query, $fltrDataArr)
    {
        if (empty($fltrDataArr)) {
            return $query;
        } else {
            $fundCode = $fltrDataArr['fund_code'] ?? '';
            if ($fundCode) {
                $query->where('fund_code', '=', $fundCode);
            }
            $entryDate = $fltrDataArr['entry_date'] ?? '';
            if ($entryDate) {
                $query->where('entry_date', '=', $entryDate);
            }
        }
        return $query;
    }

    public static function missingList($fltrDataArr = false)
    {
        $startDate = $endDate = '';

        $missingDate = $fltrDataArr['missing_date'] ?? '';
        $fundCode = $fltrDataArr['fund_code'] ?? '';
        if ($missingDate != '' && $fundCode != '') {
            $missingDateArr = explode(" - ", $missingDate);
            if (!empty($missingDateArr)) {
                $startDate = $missingDateArr[0];
                $endDate = $missingDateArr[1];
            }
            return DB::select("CALL find_missing_date_nav('" . $fundCode . "', '" . $startDate . "', '" . $endDate . "')");
        } else {
            return [];
        }
    }

    public static function getClosingValue($fundCode, $entryDate)
    {
        $dataMdl = DB::select("CALL find_closing_nav('" . $fundCode . "', '" . $entryDate . "')");
        return $dataMdl ? $dataMdl[0]->closing_nav : 0;
    }

    public static function getLastPublishedDate($fundCode)
    {
        $dtMdl = FundDetail::select('entry_date')->where('fund_code', $fundCode)->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }
    public static function getFirstPublishedDate($fundCode)
    {
        $dtMdl = FundDetail::select('entry_date')->where('fund_code', $fundCode)->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'asc')->first();
        return $dtMdl ? $dtMdl->entry_date : '';
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
