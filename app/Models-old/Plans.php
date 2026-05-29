<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Lib\Core\Useful;
use App\Lib\Admin\App;

use App\Models\AdminModel;

class Plans extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'plans';

  protected $primaryKey = 'p_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'plan_name',
    'description',
    'amount',
    'plan_type',
    'duration',
    'duration_name',
    'free_trial',
    'show_on_wa',
    'c_order',
    'status',
    'created_id',
    'updated_id',
  ];

  protected $guarded = [
    'p_id',
  ];


  public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }

    $query = Plans::select($fields);

    $status = isset($filterArr['status']) ? $filterArr['status'] : '';
    if ($status) {
      $query->where('status', '=', $status);
    }

    $show_on_wa = isset($filterArr['show_on_wa']) ? $filterArr['show_on_wa'] : '';
    if ($show_on_wa != '') {
      $query->where('show_on_wa', '=', $filterArr['show_on_wa']);
    }

    $free_trial = isset($filterArr['free_trial']) ? $filterArr['free_trial'] : '';
    if ($free_trial != '') {
      $query->where('free_trial', '=', $filterArr['free_trial']);
    }

    if ($orderBy == false && $order == false) {
      $orderBy = 'p_id';
      $order = 'DESC';
    }
    $query->orderBy($orderBy, $order);
    return $perPage ? $query->paginate($perPage) : $query->get();
  }

  public static function getData($filterArr = [], $fields = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }
    $query = Plans::select($fields);

    $status = isset($filterArr['status']) ? $filterArr['status'] : '';
    if ($status) {
      $query->where('status', '=', $status);
    }

    $dataId = isset($filterArr['p_id']) ? intval($filterArr['p_id']) : 0;
    if ($dataId > 0) {
      $query->where('p_id', '=', $dataId);
    }

    $free_trial = isset($filterArr['free_trial']) ? $filterArr['free_trial'] : '';
    if ($free_trial) {
      $query->where('free_trial', '=', $free_trial);
    }

    $plan_type = isset($filterArr['plan_type']) ? $filterArr['plan_type'] : '';
    if ($plan_type) {
      $query->where('plan_type', '=', $plan_type);
    }

    return $query->first();
  }

  public static function captureFreeTrailPlan($dataArr)
  {
    $commonconstants = Config('commonconstants');

    $planRow = Plans::getData(["free_trial" => $commonconstants['y_n_val'][1], 'status' => $commonconstants['status_val'][1]]);
    if ($planRow) {
      $userId = intval($dataArr['u_id']);
      $cuBy = $dataArr['created_by'];

      $today = date($commonconstants['y_m_d_frmt']);
      $endDate = Useful::dateadd(date($commonconstants['d_m_y_frmt']), $planRow->duration);

      $storeUs = new UserSubscription();

      $storeUs->p_id = $planRow->p_id;
      $storeUs->plan_type = $planRow->plan_type;
      $storeUs->start_date = $today;
      $storeUs->end_date = $endDate;
      $storeUs->status = $commonconstants['subscription_status_val']['value'][0];
      $storeUs->u_id = $userId;
      $storeUs->created_by = $cuBy;
      $storeUs->created_id = $userId;
      $storeUs->updated_by = $cuBy;
      $storeUs->updated_id = $userId;
      return $storeUs->save();
    }
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

    return ["plan_type" => $commonconstants['plan_type'], "yes_no" => App::getYesNoArr()];
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
