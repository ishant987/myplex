<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;

class IndicesMaster extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indices_master';

    protected $primaryKey = 'idc_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'corelation',
        'status',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'idc_id',
    ];


    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = IndicesMaster::select($fields);

        $name = isset($filterArr['name']) ? $filterArr['name'] : '';
        if ($name != '') {
            $query->where('name', '=', $name);
        }

        $corelation = isset($filterArr['corelation']) ? $filterArr['corelation'] : '';
        if ($corelation != '') {
            $query->where('corelation', '=', $corelation);
        }

        $nocor = isset($filterArr['nocor']) ? $filterArr['nocor'] : '';
        if ($nocor == 'yes') {
            $query->where('corelation', '=', '')->orWhere('corelation', '=', NULL);
        }

        $cor = isset($filterArr['cor']) ? $filterArr['cor'] : '';
        if ($cor == 'yes') {
            $query->where('corelation', '!=', '')->orWhere('corelation', '!=', NULL);
        }

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'idc_id';
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
        $query = IndicesMaster::select($fields);

        $corelation = isset($filterArr['corelation']) ? $filterArr['corelation'] : '';
        if ($corelation != '') {
            $query->where('corelation', '=', $corelation);
        }

        $indicesName = isset($filterArr['indices_name']) ? $filterArr['indices_name'] : null;
        if ($indicesName != '' && $indicesName != null) {
            $query->where('name', '=', $indicesName);
        }

        $indicesNameLike = isset($filterArr['indices_name_like']) ? $filterArr['indices_name_like'] : null;
        if ($indicesNameLike != '' && $indicesNameLike != null) {
            $query->where('name', 'like', $indicesNameLike . '%');
        }

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
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


    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */
}
