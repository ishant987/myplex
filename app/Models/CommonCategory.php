<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\MediaModel;

class CommonCategory extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'common_category';

  protected $primaryKey = 'cc_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'type',
    'title',
    'slug',
    'descp',
    'media_id',
    'parent',
    'c_order',
    'status',
    'updated_id'
  ];

  protected $guarded = [
    'cc_id',
  ];


  public function media()
  {
    return $this->hasOne(MediaModel::class, 'media_id', 'media_id')->select('media_id', 'path', 'title', 'alt');
  }

  public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }

    $query = CommonCategory::select($fields)->with(['media', 'mediaicon']);

    $type = isset($filterArr['type']) ? $filterArr['type'] : "";
    if ($type != "") {
      $query->where('type', '=', $type);
    }

    $category_ids = isset($filterArr['category_ids']) ? $filterArr['category_ids'] : [];

    if (is_array($category_ids) && count($category_ids)) {
      $query->where(function ($query) use ($category_ids) {
        foreach ($category_ids as $key => $value) {
          $query->orWhere('cc_id', $value);
        }
        return $query;
      });
    }

    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }

    if (isset($filterArr['parent'])) {
      $query->where('parent', '=', $filterArr['parent']);
    }

    if ($orderBy == false && $order == false) {
      $orderBy = 'cc_id';
      $order = 'DESC';
    }
    $query->orderBy($orderBy, $order);

    $dtListArr = $perPage ? $query->paginate($perPage) : $query->get();

    $random = isset($filterArr['random']) ? intval($filterArr['random']) : 0;
    if ($random > 0) {
      $dtListArr = $dtListArr->random($random);
    }

    $take = isset($filterArr['take']) ? intval($filterArr['take']) : 0;
    if ($take > 0) {
      $dtListArr = $dtListArr->take($take);
    }

    return $dtListArr;
  }

  public static function getData($filterArr = false, $fields = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }
    $query = CommonCategory::with(['media'])->select($fields);

    $type = isset($filterArr['type']) ? $filterArr['type'] : "";
    if ($type != "") {
      $query->where('type', '=', $type);
    }

    $slug = isset($filterArr['slug']) ? $filterArr['slug'] : "";
    if ($slug != "") {
      $query->where('slug', '=', $slug);
    }

    $cId = isset($filterArr['cc_id']) ? intval($filterArr['cc_id']) : 0;
    if ($cId > 0) {
      $query->where('cc_id', '=', $cId);
    }

    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }

    $dtListArr = $query->get()->first();

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

  public function parentcat()
  {
    return $this->hasOne(CommonCategory::class, 'cc_id', 'parent');
  }

  public static function getCategoryList($type)
  {
    $dtListArr = CommonCategory::where(['type' => $type, 'status' => Config('commonconstants.status_val.1')])->pluck('title', 'cc_id')->toArray();

    return $dtListArr;
  }

  public static function listWithParent($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }
    $query = CommonCategory::with('parentcat')->select($fields);

    $type = isset($filterArr['type']) ? $filterArr['type'] : "";
    if ($type != "") {
      $query->where('type', '=', $type);
    }
    $typeIn = !empty($filterArr['type_in']) ? $filterArr['type_in'] : [];
    if (!empty($typeIn)) {
      $query->whereIn('type', $typeIn);
    }
    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }

    if ($orderBy == false && $order == false) {
      $orderBy = 'cc_id';
      $order = 'DESC';
    }

    $query->orderBy($orderBy, $order);
    $dtListArr = $perPage ? $query->paginate($perPage) : $query->get();

    return $dtListArr;
  }

  /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */

  public function children()
  {
    return $this->hasMany(CommonCategory::class, 'parent', 'cc_id')->where('status', '=', Config('commonconstants.status_val.1'));
  }
}
