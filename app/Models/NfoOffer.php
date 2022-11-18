<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\MediaModel;
use App\Models\FundType;
use App\Models\IndicesMaster;

class NfoOffer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nfo_offer';

    protected $primaryKey = 'no_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'fund_name',
        'fund_opening',
        'fund_closing',
        'ft_id',
        'minimum_investment',
        'plan',
        'options',
        'entry_load',
        'exit_load',
        'thereafter',
        'objective',
        'idc_id',
        'fund_manager',
        'aa_col1_value',
        'aa_col1_text',
        'aa_col2_value',
        'aa_col2_text',
        'ces_row1_col1_text',
        'ces_row1_col2_text',
        'ces_row1_col3_text',
        'ces_row2_col1_text',
        'ces_row2_col2_text',
        'ces_row2_col3_text',
        'idea_distiller',
        'fund_house_aaum',
        'fund_manager_experience',
        'uniqness',
        'return',
        'risk',
        'operability',
        'oomph_factor',
        'media_id',
        'post_date',
        'file',
        'link',
        'status',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'no_id',
    ];


    public function media()
    {
        return $this->hasOne(MediaModel::class, 'media_id', 'media_id');
    }

    public function fundtype()
    {
        return $this->hasOne(FundType::class, 'ft_id', 'ft_id');
    }

    public function indices()
    {
        return $this->hasOne(IndicesMaster::class, 'idc_id', 'idc_id');
    }

    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = NfoOffer::select($fields)->with('fundtype');

        $fund_name = isset($filterArr['fund_name']) ? $filterArr['fund_name'] : null;
        if($fund_name != null){
            $query->where('fund_name', '=', $fund_name);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'no_id';
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
        $query = NfoOffer::select($fields)->with(['media','fundtype','indices']);

        $no_id = isset($filterArr['no_id']) ? intval($filterArr['no_id']) : 0;
        if ($no_id > 0) {
            $query->where('no_id', '=', $no_id);
        }
        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }
        $type = isset($filterArr['type']) ? $filterArr['type'] : null;
        if($type != null){
            $query->where('type', '=', $type);
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

    public static function schemeDnaList()
    {
        $dataArr =  [];
        for ($i = 1; $i <= 5; $i++) {
            $dataArr[$i] = $i;
        }
        return $dataArr;
    }

    public static function getModuleVars()
    {
        return ["fund_type_list" => FundType::list('', ['ft_id', 'name']), "index_list" => IndicesMaster::list(['status' => Config('commonconstants.status_val.1')], ['idc_id', 'name']), 'type' => Config('commonconstants.nfo_monitor_type'), 'scheme_dna_list' => self::schemeDnaList()];
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
        return NfoOffer::selectRaw('DATE_FORMAT(post_date, "%Y") AS year, COUNT(no_id) AS tot')->where(['status' => $commonconstants['status_val'][1], 'type' => $commonconstants['nfo_monitor_type']['value'][2]])->groupByRaw('year')->orderByRaw('year DESC')->get();
        // dd(\DB::getQueryLog()); // Show results of log

        // return $dataObj;
    }

    public static function frontList($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        $commonconstants = Config('commonconstants');

        if ($fields == false) {
            $fields = ['no_id','fund_name','objective','post_date','media_id'];
        }
        $query = NfoOffer::select($fields)->where(['status' => $commonconstants['status_val'][1], 'type' => $commonconstants['nfo_monitor_type']['value'][2]]);
        $fund_name = isset($filterArr['fund_name']) ? $filterArr['fund_name'] : null;
        if($fund_name != null){
            $query->where('fund_name', '=', $fund_name);
        }
        
        $year = isset($filterArr['year']) ? $filterArr['year'] : null;
        if($year != null){
            $query->whereRaw('DATE_FORMAT(post_date, "%Y") ='.$year);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'post_date';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        $query->with('media');
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
