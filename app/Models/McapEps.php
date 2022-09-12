<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McapEps extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mcap_eps';

    protected $primaryKey = 'me_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scrip_name',
        'entry_date',
        'market_cap',
        'eps',
        'pe',
        'publish',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'me_id',
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
        $query = McapEps::select($fields);

        $scripName = isset($filterArr['scrip_name']) ? $filterArr['scrip_name'] : null;
        if($scripName != '' && $scripName != null){
            $query->where('scrip_name', '=', $scripName);
        }

        $entryDate = isset($filterArr['entry_date']) ? $filterArr['entry_date'] : null;
        if($entryDate != '' && $entryDate != null){
            $query->where('entry_date', '=', $entryDate);
        }

        return $query->get()->first();

        // $query->get()->first();
        // $quries = \DB::getQueryLog();
        // dd($quries);
    }

    public static function getPublishReadyDate(){
        $dtMdl = McapEps::select('entry_date')->where('publish', 'n')->groupBy('entry_date')->orderBy('entry_date', 'asc')->get()->first();
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
            $scripName = $fltrDataArr['scrip_name'] ?? '';
            if ($scripName) {
                $query->where('scrip_name', '=', $scripName);
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
