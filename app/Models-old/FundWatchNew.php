<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundWatchNew extends Model
{
    use HasFactory;
    protected $table = 'fund_watch_new';
    protected $fillable = [
        'fund_code',
        'logo',
        'preamble',
        'team',
        'philosophy',
        'investment_style',
        'composition_analysis_top',
        'composition_analysis_bottom',
        'feedback',
        'status',
        'updated_id',
    ];

    public function fundDetails(){
        return $this->hasOne('App\Models\FundMaster','fund_code','fund_code');
    }
    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $fields = ['id', 'fund_code', 'logo', 'preamble', 'created_at','updated_at'];
        $query = FundWatchNew::select($fields);

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'id';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order)->with('fundDetails');
        return $perPage ? $query->paginate($perPage) : $query->get();
    }
}
