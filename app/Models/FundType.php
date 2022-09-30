<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;

class FundType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fund_type';

    protected $primaryKey = 'ft_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active_passive',
        'monthly_performance',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'ft_id',
    ];


    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = FundType::select($fields);

        $name = isset($filterArr['name']) ? $filterArr['name'] : '';
        if ($name != '') {
            $query->where('name', '=', $name);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'ft_id';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function currencycor()
    {
        return $this->hasOne(CurrencyCor::class, 'ft_id', 'ft_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function getModuleVars()
    {
        $commonconstants = Config('commonconstants');

        return ["active_passive" => $commonconstants['active_passive'], "monthly_performance" => $commonconstants['monthly_performance']];
    }

    public function updatedby()
    {
        return $this->belongsTo(AdminModel::class, 'updated_id');
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
