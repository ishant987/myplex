<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyRatioCalculation extends Model
{
    use HasFactory;
    public function fund()
    {
        return $this->hasOne(FundMaster::class, 'fund_code', 'fund_code');
    }

    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        // $tableName = (new MonthlyRatioCalculation)->getTable();
        // dd($tableName);
        if ($fields == false) {
            $fields = ['*'];
        }

        $query = MonthlyRatioCalculation::select($fields);
		// dd($query);

        $fundCode = isset($filterArr['fund_code']) ? $filterArr['fund_code'] : '';
        if ($fundCode != '') {
            $query->where('fund_code', '=', $fundCode);
        }

        $fundTypeId = isset($filterArr['fund_type_id']) ? $filterArr['fund_type_id'] : '';
        if ($fundTypeId != '') {
            $query->whereHas('fund', function ($query) use ($fundTypeId) {
                $query->where('fund_type_id', $fundTypeId);
            });
        }

        $fund_name = isset($filterArr['fund_name']) ? $filterArr['fund_name'] : '';
        if ($fund_name != '') {
            $query->where('fund_name', '=', $fund_name);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'fund_name';
            $order = 'ASC';
        }

        $query->orderBy($orderBy, $order);

        $lastQuery = $query->toSql();
        // echo $lastQuery;die;
        // dd($query->get());

        return $perPage ? $query->paginate($perPage) : $query->get();
    }
}
