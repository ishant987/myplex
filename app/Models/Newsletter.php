<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'newsletter';

  protected $primaryKey = 'n_id';

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
    'email',
    'created_at'
  ];

  protected $guarded = [
    'n_id',
  ];


  public static function getData($email, $fields = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }
    return Newsletter::select($fields)->where('email', $email)->get()->first();
  }

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
    return Newsletter::select('n_id')->count();
  }

  public function scopeSearch($query, $fltrDataArr)
  {
    if (empty($fltrDataArr)) {
      return $query;
    } else {
      $email = $fltrDataArr['email'] ?? '';
      if ($email) {
        $query->where('email', 'LIKE', '%' . $email . '%');
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
