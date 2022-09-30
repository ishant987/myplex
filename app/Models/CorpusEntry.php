<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CorpusEntry extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'corpus_entry';

    protected $primaryKey = 'ce_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_code',
        'entry_date',
        'corpus_entry',
        'percentage_change',
        'corpus_change',
        'publish',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'ce_id',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getActiveAUMs()
    {
        return DB::select('CALL active_aums()');
    }

    public static function getPublishReadyDate()
    {
        $dtMdl = CorpusEntry::select('entry_date')->where('publish', 'n')->groupBy('entry_date')->orderBy('entry_date', 'asc')->get()->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }

    public static function getLastPublishedDate($fundCode = false)
    {
        $query = CorpusEntry::select('entry_date');
        if ($fundCode) {
            $query->where('fund_code', $fundCode);
        }
        $dtMdl = $query->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }

    public static function getFirstPublishedDate($fundCode = false)
    {
        $query = CorpusEntry::select('entry_date');
        if ($fundCode) {
            $query->where('fund_code', $fundCode);
        }
        $dtMdl = $query->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'asc')->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }

    public static function getModuleVars()
    {
        $commonLang = __('common');

        return ["published" => ['n' => $commonLang['yes_no_txt']['n'], 'y' => $commonLang['yes_no_txt']['y']]];
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


    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */
}
