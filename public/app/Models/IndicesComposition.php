<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicesComposition extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indices_composition';

    protected $primaryKey = 'ic_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_date',
        'indices_name',
        'scrip_name',
        'type',
        'industry',
        'percentage',
        'publish',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'ic_id',
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
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = IndicesComposition::select($fields);

        $entryDate = isset($filterArr['entry_date']) ? $filterArr['entry_date'] : null;
        if($entryDate != '' && $entryDate != null){
            $query->where('entry_date', '=', $entryDate);
        }

        $indicesName = isset($filterArr['indices_name']) ? $filterArr['indices_name'] : null;
        if($indicesName != '' && $indicesName != null){
            $query->where('indices_name', '=', $indicesName);
        }

        $scripName = isset($filterArr['scrip_name']) ? $filterArr['scrip_name'] : null;
        if($scripName != '' && $scripName != null){
            $query->where('scrip_name', '=', $scripName);
        }

        return $query->get()->first();
    }

    public static function getPublishReadyDate(){
        $dtMdl = IndicesComposition::select('entry_date')->where('publish', 'n')->groupBy('entry_date')->orderBy('entry_date', 'asc')->get()->first();
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
            $indicesName = $fltrDataArr['indices_name'] ?? '';
            if ($indicesName) {
                $query->where('indices_name', '=', $indicesName);
            }
            $scripName = $fltrDataArr['scrip_name'] ?? '';
            if ($scripName) {
                $query->where('scrip_name', '=', $scripName);
            }
            $type = $fltrDataArr['type'] ?? '';
            if ($type) {
                $query->where('type', '=', $type);
            }
            $industry = $fltrDataArr['industry'] ?? '';
            if ($industry) {
                $query->where('industry', '=', $industry);
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
