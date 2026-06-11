<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFundHousePerformance extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'monthly_fund_house_performance';

    protected $primaryKey = 'mfhp_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dated',
        'fund_type_id',
        'timespan',
        'fund_code',
        'cagr',
        'cagr_rank',
        'cagr_rank_improvement',
        'ret_less_idx',
        'ret_less_idx_rank',
        'ret_less_idx_rank_improvement',
        'jensen',
        'jensen_rank',
        'jensen_rank_improvement',
        'beta',
        'beta_rank',
        'beta_rank_improvement',
        'co_var',
        'co_var_rank',
        'co_var_rank_improvement',
        'created_id',
        'updated_id',
        'migration_at'
    ];

    protected $guarded = [
        'mfhp_id',
    ];



    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */
}
