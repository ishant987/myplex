<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\MediaModel;

class Teams extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'teams';

  protected $primaryKey = 'team_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'media_id',
    'designation',
    'linkedin_link',
    'c_order',
    'status',
    'updated_id'
  ];

  protected $guarded = [
    'team_id',
  ];


  public function media()
  {
    return $this->hasOne(MediaModel::class, 'media_id', 'media_id');
  }

  public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }
    $query = Teams::with('media')->select($fields);

    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }

    if ($orderBy == false && $order == false) {
      $orderBy = 'team_id';
      $order = 'DESC';
    }

    $query->orderBy($orderBy, $order);
    $dtListArr = $perPage ? $query->paginate($perPage) : $query->get();

    return $dtListArr;
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
