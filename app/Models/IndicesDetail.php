<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IndicesDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indices_detail';

    protected $primaryKey = 'idcd_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'entry_date',
        'closing_value',
        'holiday',
        'percentage_change',
        'publish',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'idcd_id',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getActiveIndices()
    {
        return DB::select('CALL active_indices()');
    }

    public static function getPublishReadyDate()
    {
        $dtMdl = IndicesDetail::select('entry_date')->where('publish', 'n')->groupBy('entry_date')->orderBy('entry_date', 'asc')->get()->first();
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
            $name = $fltrDataArr['name'] ?? '';
            if ($name) {
                $query->where('name', '=', $name);
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
        $indices = $fltrDataArr['indices'] ?? '';
        if ($missingDate != '' && $indices != '') {
            $missingDateArr = explode(" - ", $missingDate);
            if (!empty($missingDateArr)) {
                $startDate = $missingDateArr[0];
                $endDate = $missingDateArr[1];
            }
            return DB::select("CALL find_missing_date_indices('" . $indices . "', '" . $startDate . "', '" . $endDate . "')");
        } else {
            return [];
        }
    }

    public static function getClosingValue($indicesName, $entryDate)
    {
        $dataMdl = DB::select("CALL find_closing_value_indices('" . $indicesName . "', '" . $entryDate . "')");
        return $dataMdl ? $dataMdl[0]->closing_value : 0;
    }

    public static function getLastPublishedDate($indicesName)
    {
        $dtMdl = IndicesDetail::select('entry_date')->where('name', $indicesName)->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }
    public static function getFirstPublishedDate($indicesName)
    {
        $dtMdl = IndicesDetail::select('entry_date')->where('name', $indicesName)->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'asc')->first();
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
