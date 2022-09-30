<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

use App\Models\Plans;
use App\Models\User;
use App\Models\AdminModel;
// use App\Models\UserOrders;

class UserSubscription extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_subscription';

    protected $primaryKey = 'us_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'u_id',
        'p_id',
        'plan_type',
        'start_date',
        'end_date',
        'status',
        'created_by',
        'created_id',
        'updated_by',
        'updated_id',
    ];

    protected $guarded = [
        'us_id',
    ];


    public static function getData($filterArr = [], $fields = false)
    {
        // DB::enableQueryLog(); // Enable query log

        if ($fields === false) {
            $fields = ['*'];
        }

        $with = isset($filterArr['with']) ? $filterArr['with'] : '';
        if ($with != '') {
            $query = UserSubscription::with($with)->select($fields);
        } else {
            $query = UserSubscription::select($fields);
        }

        $status = isset($filterArr['status']) ? $filterArr['status'] : '';
        if ($status) {
            $query->where('status', '=', $status);
        }

        $dataId = isset($filterArr['us_id']) ? intval($filterArr['us_id']) : 0;
        if ($dataId > 0) {
            $query->where('us_id', '=', $dataId);
        }

        $u_id = isset($filterArr['u_id']) ? intval($filterArr['u_id']) : 0;
        if ($u_id > 0) {
            $query->where('u_id', '=', $u_id);
        }

        $commonconstants = Config('commonconstants');

        $check_subscription = isset($filterArr['check_subscription']) ? $filterArr['check_subscription'] : '';
        if ($check_subscription == $commonconstants['y_n_val'][1]) {
            $today = date($commonconstants['y_m_d_frmt']);

            $query->where([['plan_type', '=', $commonconstants['plan_type']['value'][1]], ['start_date', '<=', $today], ['end_date', '>=', $today]]);

            // $query->orWhere(function ($query)  use ($today) {
            //   $query->where([['start_date', '<=', $today], ['end_date', '>=', $today]]);
            //   $query->where('plan_type', '=', 'lp');
            // });

            $nVal = $commonconstants['y_n_val'][2];
            $query->whereHas('plans', function ($query) use ($nVal) {
                $query->where('free_trial', '=', $nVal);
            });
        }

        $dataModel =  $query->first();

        // dd(DB::getQueryLog()); // Show results of log

        return $dataModel;
    }

    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        // DB::enableQueryLog(); // Enable query log
        $commonconstants = Config('commonconstants');

        if ($fields == false) {
            $fields = ['*'];
        }

        $with = isset($filterArr['with']) ? $filterArr['with'] : '';
        if ($with) {
            $query = UserSubscription::with($with)->select($fields);
        } else {
            $query = UserSubscription::select($fields);
        }

        $status = isset($filterArr['status']) ? $filterArr['status'] : '';
        if ($status) {
            $query->where('status', '=', $status);
        }

        $plan_type = isset($filterArr['plan_type']) ? $filterArr['plan_type'] : '';
        if ($plan_type != '') {
            $query->where('plan_type', '=', $filterArr['plan_type']);
        }

        $endDate = isset($filterArr['end_date']) ? $filterArr['end_date'] : '';
        if ($endDate != '') {
            $query->where([['plan_type', '=', $commonconstants['plan_type']['value'][1]], ['end_date', '=', $endDate]]);
        }

        $check_expiry = isset($filterArr['check_expiry']) ? $filterArr['check_expiry'] : '';
        if ($check_expiry == $commonconstants['y_n_val'][1]) {
            $nVal = $commonconstants['y_n_val'][2];
            $query->whereHas('plans', function ($query) use ($nVal) {
                $query->where('free_trial', '=', $nVal);
            });

            $status = $commonconstants['status_val'][1];
            $query->whereHas('user', function ($query) use ($status) {
                $query->where('status', '=', $status);
            });
        }

        $check_trial = isset($filterArr['check_trial']) ? $filterArr['check_trial'] : '';
        if ($check_trial == $commonconstants['y_n_val'][1]) {
            $yVal = $commonconstants['y_n_val'][1];
            $query->whereHas('plans', function ($query) use ($yVal) {
                $query->where('free_trial', '=', $yVal);
            });

            $status = $commonconstants['status_val'][1];
            $query->whereHas('user', function ($query) use ($status) {
                $query->where('status', '=', $status);
            });
        }

        $u_id = isset($filterArr['u_id']) ? intval($filterArr['u_id']) : 0;
        if ($u_id > 0) {
            $query->where('u_id', '=', $u_id);
        }

        $dbDtFrmt = $commonconstants['db_dt_tm_frmt'];

        $subPeriod = isset($filterArr['sub_period_date']) ? $filterArr['sub_period_date'] : '';
        if ($subPeriod != '') {
            $subPeriodArr = explode(" - ", $subPeriod);
            if (!empty($subPeriodArr)) {
                $StartDate = date($dbDtFrmt, strtotime($subPeriodArr[0])) . ' 00:00:00';
                $EndDate = date($dbDtFrmt, strtotime($subPeriodArr[1])) . ' 23:59:59';
            }
            $query->where('start_date', '>', $StartDate);
            $query->where('end_date', '<', $EndDate);
        }

        $addedDate = isset($filterArr['added_date']) ? $filterArr['added_date'] : '';
        if ($addedDate != '') {
            $addedDateArr = explode(" - ", $addedDate);
            if (!empty($addedDateArr)) {
                $StartDate = date($dbDtFrmt, strtotime($addedDateArr[0])) . ' 00:00:00';
                $EndDate = date($dbDtFrmt, strtotime($addedDateArr[1])) . ' 23:59:59';
            }
            $query->whereBetween('created_at', [$StartDate, $EndDate]);
        }

        $search = isset($filterArr['search']) ? $filterArr['search'] : '';
        if ($search != '') {
            $query->whereHas('plans', function ($query) use ($search) {
                $query->where('plan_name', 'LIKE', '%' . $search . '%');
            });
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'us_id';
            $order = 'DESC';
        }
        $query->orderBy($orderBy, $order);
        $listModel = $perPage ? $query->paginate($perPage) : $query->get();

        // dd(DB::getQueryLog()); // Show results of log

        return $listModel;
    }

    public function plans()
    {
        return $this->hasOne(Plans::class, 'p_id', 'p_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'u_id', 'u_id');
    }

    public static function getStatusArr()
    {
        $sbsStatus = Config('commonconstants.subscription_status_val');
        $sbsStatusVal = $sbsStatus['value'];
        $sbsStatusTxt = $sbsStatus['text'];
        return array($sbsStatusVal[0] => $sbsStatusTxt[$sbsStatusVal[0]], $sbsStatusVal[1] => $sbsStatusTxt[$sbsStatusVal[1]]);
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

    public function updatedbyuser()
    {
        return $this->belongsTo(User::class, 'updated_id');
    }

    public static function dataListAdmin($fltrDataArr = false, $orderBy = false, $order = false, $perPage = false)
    {
        // DB::enableQueryLog(); // Enable query log

        $dbPrfx = DB::getTablePrefix();

        $commonconstants = Config('commonconstants');
        $yVal = $commonconstants['y_n_val'][1];

        $query = UserSubscription::select('us_id', 'user_subscription.u_id', 'user_subscription.p_id', 'users.u_id AS user_id', 'users.email AS email', 'users.mobile AS mobile', 'users.created_at AS created_at', 'plans.no_of_tests AS no_of_tests')
            ->selectRaw(addcslashes('CONCAT_WS(" ", ' . $dbPrfx . 'users.f_name, ' . $dbPrfx . 'users.l_name) AS name', "'"))
            ->leftJoin('users', function ($join) {
                $join->on('users.u_id', '=', 'user_subscription.u_id');
            })
            ->leftJoin('rpt_tests', function ($join) {
                $join->on('users.u_id', '=', 'rpt_tests.u_id');
            })
            ->leftJoin('plans', function ($join) use ($yVal) {
                $join->on('plans.p_id', '=', 'user_subscription.p_id')->where('plans.free_trial', '=', $yVal);
            })->where('user_subscription.plan_type', '=', $commonconstants['plan_type']['value'][1])->where('plans.free_trial', '=', $yVal)
            ->groupBy('user_subscription.u_id');

        $name = $fltrDataArr['name'] ?? '';
        if ($name) {
            $query->where('users.f_name', 'LIKE', "%{$name}%")->orWhere('users.l_name', 'LIKE', "%{$name}%");
        }

        $email = $fltrDataArr['email'] ?? '';
        if ($email) {
            $query->where('users.email', '=', $email);
        }

        $mobile = $fltrDataArr['mobile'] ?? '';
        if ($mobile) {
            $query->where('users.mobile', '=', $mobile);
        }

        $dbDtFrmt = $commonconstants['y_m_d_frmt'];

        $createdAt = $fltrDataArr['created_at'] ?? '';
        if ($createdAt) {
            $createdAtArr = explode(" - ", $createdAt);
            if (!empty($createdAtArr)) {
                $uaStartDate = date($dbDtFrmt, strtotime($createdAtArr[0])) . ' 00:00:00';
                $uaEndDate = date($dbDtFrmt, strtotime($createdAtArr[1])) . ' 23:59:59';
            }
            $query->whereBetween('users.created_at', [$uaStartDate, $uaEndDate]);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'user_subscription.updated_at';
            $order = 'DESC';
        }
        $query->orderBy($orderBy, $order);

        $dataObj = $perPage ? $query->paginate($perPage) : $query->get();

        // dd(DB::getQueryLog()); // Show results of log

        return $dataObj;
    }

    public static function dataReportList($fltrDataArr = false, $orderBy = false, $order = false, $perPage = false)
    {
        // DB::enableQueryLog(); // Enable query log

        $dbPrfx = DB::getTablePrefix();

        $commonconstants = Config('commonconstants');
        $nVal = $commonconstants['y_n_val'][2];

        $query = UserSubscription::select('us_id', 'start_date', 'end_date', 'user_subscription.u_id', 'user_subscription.p_id', 'users.u_id AS user_id', 'users.email AS email', 'plans.plan_name AS plan_name', 'plans.duration AS duration', 'plans.duration_name AS duration_name')
            ->selectRaw(addcslashes('CONCAT_WS(" ", ' . $dbPrfx . 'users.f_name, ' . $dbPrfx . 'users.l_name) AS name', "'"))
            ->leftJoin('users', function ($join) {
                $join->on('users.u_id', '=', 'user_subscription.u_id');
            })
            ->leftJoin('plans', function ($join) use ($nVal) {
                $join->on('plans.p_id', '=', 'user_subscription.p_id')->where('plans.free_trial', '=', $nVal);
            })->where('user_subscription.plan_type', '=', $commonconstants['plan_type']['value'][1])->where('plans.free_trial', '=', $nVal);

        $plan_id = isset($fltrDataArr['plan_id']) ? intval($fltrDataArr['plan_id']) : 0;
        if ($plan_id > 0) {
            $query->where('user_subscription.p_id', '=', $plan_id);
        }

        $name = $fltrDataArr['name'] ?? '';
        if ($name) {
            $query->where('users.f_name', 'LIKE', "%{$name}%")->orWhere('users.l_name', 'LIKE', "%{$name}%");
        }

        $email = $fltrDataArr['email'] ?? '';
        if ($email) {
            $query->where('users.email', '=', $email);
        }

        $duration = isset($fltrDataArr['duration']) ? $fltrDataArr['duration'] : '';
        if ($duration) {
            $query->where('plans.duration', '=', $duration)->orWhere('plans.duration_name', '=', $duration);
        }

        $dbDtFrmt = $commonconstants['y_m_d_frmt'];

        $startDate = $fltrDataArr['start_date'] ?? '';
        if ($startDate) {
            $startDateArr = explode(" - ", $startDate);
            if (!empty($startDateArr)) {
                $nwStartDate = date($dbDtFrmt, strtotime($startDateArr[0])) . ' 00:00:00';
                $nwEndDate = date($dbDtFrmt, strtotime($startDateArr[1])) . ' 23:59:59';
            }
            $query->whereBetween('user_subscription.start_date', [$nwStartDate, $nwEndDate]);
        }

        $endDate = $fltrDataArr['end_date'] ?? '';
        if ($endDate) {
            $endDateArr = explode(" - ", $endDate);
            if (!empty($endDateArr)) {
                $nwStartDate2 = date($dbDtFrmt, strtotime($endDateArr[0])) . ' 00:00:00';
                $nwEndDate2 = date($dbDtFrmt, strtotime($endDateArr[1])) . ' 23:59:59';
            }
            $query->whereBetween('user_subscription.end_date', [$nwStartDate2, $nwEndDate2]);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'user_subscription.updated_at';
            $order = 'DESC';
        }
        $query->orderBy($orderBy, $order);

        $dataObj = $perPage ? $query->paginate($perPage) : $query->get();

        // dd(DB::getQueryLog()); // Show results of log

        return $dataObj;
    }


    /*
      |--------------------------------------------------------------------------
      | Frontent (API / Website) Methods / Functions
      |--------------------------------------------------------------------------
      |
      | The following functions are used for api panel.
      |
      */
    public function getStartDateFrontAttribute()
    {
        return date(Config('commonconstants.d_m_y_frmt2'), strtotime($this->start_date));
    }
    public function getEndDateFrontAttribute()
    {
        return date(Config('commonconstants.d_m_y_frmt2'), strtotime($this->end_date));
    }
    public function getAddedDateFrontAttribute()
    {
        return date(Config('commonconstants.d_m_y_frmt2'), strtotime($this->created_at));
    }
    public static function getUserSubscriptionInfo($userId)
    {
        $response = [];
        $commonconstants = Config('commonconstants');
        $dataRow = self::getData(["u_id" => $userId, "with" => 'plans']);
        // dd($dataRow);
        if ($dataRow) {
            $active = $commonconstants['subscription_status_val']['value'][0];
            $expired = $commonconstants['subscription_status_val']['value'][1];
            $planType = $dataRow->plan_type;
            if ($planType == $commonconstants['plan_type']['value'][0]) {
                $response = ['s_type' => $planType, 's_status' => $active, 's_start_date' => '', 'free_trial' => ''];
            } elseif ($planType == $commonconstants['plan_type']['value'][1]) {
                $status = $dataRow->status;
                $today = date($commonconstants['y_m_d_frmt']);
                $startDate = $dataRow->start_date;
                $endDate = $dataRow->end_date;
                if (($status == $active) && ($startDate < $today && $endDate < $today)) {
                    $status = $expired;
                }
                $dateFormat = $commonconstants['d_m_y_frmt2'];
                $response = ['s_type' => $planType, 's_status' => $status, 's_start_date' => date($dateFormat, strtotime($startDate)), 's_end_date' => date($dateFormat, strtotime($endDate)), 'free_trial' => $dataRow->plans ? $dataRow->plans->free_trial : ''];
            }
        } else {
            $response = ['s_type' => "normal", 's_status' => 'na', 's_start_date' => '', 's_end_date' => '', 'free_trial' => ''];
        }
        return $response;
    }

    public static function isActiveSubscription($userId)
    {
        $response = false;
        $data = self::getUserSubscriptionInfo($userId);
        if (!empty($data)) {
            $response = ($data['s_status'] == Config('commonconstants.subscription_status_val.value.0')) ? true : false;
        }
        return $response;
    }

    // public function order()
    // {
    //     return $this->hasOne(UserOrders::class, 'o_id', 'o_id');
    // }
}
