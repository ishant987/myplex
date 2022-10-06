<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryModel extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'enquiry';

  protected $primaryKey = 'enq_id';

  /**
   * The name of the "updated at" column.
   *
   * @var string
   */
  const UPDATED_AT = null;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'u_id',
    'name',
    'email',
    'mobile',
    'message',
    'created_at'
  ];

  protected $guarded = [
    'enq_id',
  ];



  /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

  public static function getTotalCount()
  {
    return EnquiryModel::select('enq_id')->count();
  }

  public function scopeSearch($query, $fltrDataArr)
  {
    if (empty($fltrDataArr)) {
      return $query;
    } else {
      $name = $fltrDataArr['name'] ?? '';
      if ($name) {
        $query->where('name', 'LIKE', '%' . $name . '%');
      }
      $email = $fltrDataArr['email'] ?? '';
      if ($email) {
        $query->where('email', 'LIKE', '%' . $email . '%');
      }
      $mobile = $fltrDataArr['mobile'] ?? '';
      if ($mobile) {
        $query->where('mobile', 'LIKE', '%' . $mobile . '%');
      }
      $message = $fltrDataArr['message'] ?? '';
      if ($message) {
        $query->where('message', 'LIKE', '%' . $message . '%');
      }

      $dbDtFrmt = Config('commonconstants.y_m_d_frmt');

      $createdAt = $fltrDataArr['created_at'] ?? '';
      if ($createdAt) {
        $createdAtArr = explode(" - ", $createdAt);
        if (!empty($createdAtArr)) {
          $caStartDate = date($dbDtFrmt, strtotime($createdAtArr[0])) . ' 00:00:00';
          $caEndDate = date($dbDtFrmt, strtotime($createdAtArr[1])) . ' 23:59:59';
        }
        $query->whereBetween('created_at', [$caStartDate, $caEndDate]);
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
