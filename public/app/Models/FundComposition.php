<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundComposition extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fund_composition';

    protected $primaryKey = 'fc_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_date',
        'fund_code',
        'scrip_name',
        'industry',
        'category',
        'content_per',
        'amount',
        'no_of_shares',
        'indices_per',
        'publish',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'fc_id',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getData($filterArr = false, $fields = false)
    {
        // \DB::enableQueryLog();

        if ($fields == false) {
            $fields = ['*'];
        }
        $query = FundComposition::select($fields);

        $fundCode = isset($filterArr['fund_code']) ? $filterArr['fund_code'] : null;
        if ($fundCode != '' && $fundCode != null) {
            $query->where('fund_code', '=', $fundCode);
        }

        $scripName = isset($filterArr['scrip_name']) ? $filterArr['scrip_name'] : null;
        if ($scripName != '' && $scripName != null) {
            $query->where('scrip_name', '=', $scripName);
        }

        $entryDate = isset($filterArr['entry_date']) ? $filterArr['entry_date'] : null;
        if ($entryDate != '' && $entryDate != null) {
            $query->where('entry_date', '=', $entryDate);
        }

        return $query->get()->first();

        // $query->get()->first();
        // $quries = \DB::getQueryLog();
        // dd($quries);
    }

    public static function getPublishReadyDate()
    {
        $dtMdl = FundComposition::select('entry_date')->where('publish', 'n')->groupBy('entry_date')->orderBy('entry_date', 'asc')->get()->first();
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
            $scripName = $fltrDataArr['scrip_name'] ?? '';
            if ($scripName) {
                $query->where('scrip_name', '=', $scripName);
            }
            $industry = $fltrDataArr['industry'] ?? '';
            if ($industry) {
                $query->where('industry', '=', $industry);
            }
            $category = $fltrDataArr['category'] ?? '';
            if ($category) {
                $query->where('category', '=', $category);
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

    public static function getLastPublishedDate($fundCode)
    {
        $dtMdl = FundComposition::select('entry_date')->where('fund_code', $fundCode)->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'desc')->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }
    public static function getFirstPublishedDate($fundCode)
    {
        $dtMdl = FundComposition::select('entry_date')->where('fund_code', $fundCode)->where('publish', 'y')->groupBy('entry_date')->orderBy('entry_date', 'asc')->first();
        return $dtMdl ? $dtMdl->entry_date : '';
    }
}
