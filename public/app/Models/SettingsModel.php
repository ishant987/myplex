<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'options';

  protected $primaryKey = 'option_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'field_type',
    'field_label',
    'option_key',
    'option_value',
    'options_label',
    'options_value',
    'type',
    'field_info',
    'is_required',
    'c_order',
    'status',
    'updated_id',
  ];

  protected $guarded = [
    'option_id',
  ];


  public static function getSettingsArr($optionKeyArr, $status = 0)
  {
    $query = SettingsModel::select('option_key', 'option_value')->whereIn('option_key', $optionKeyArr);
    if ($status > 0) {
      $query->where('status', '=', $status);
    }
    $settingsArr = $query->pluck('option_value', 'option_key')->toArray();
    return ($settingsArr && count($settingsArr) > 0) ? $settingsArr : false;
  }

  public static function getSettingValue($key)
  {
    $dtArr = self::getSettingsArr([$key]);
    return !empty($dtArr) ? $dtArr[$key] : '';
  }


  /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */
  public static function getSettingsFields($type, $status = 0)
  {
    $query = SettingsModel::where('type', '=', $type);

    if ($status > 0) {
      $query->where('status', '=', $status);
    }

    return $query->orderBy('c_order', 'ASC')->get();
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
