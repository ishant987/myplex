<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\CommonCategory;

class FAQModel extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'faq';

  protected $primaryKey = 'faq_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'slug',
    'descp',
    'cc_id',
    'c_order',
    'status',
    'updated_id'
  ];

  protected $guarded = [
    'faq_id',
  ];


  public function category()
  {
    return $this->hasOne(CommonCategory::class, 'cc_id', 'cc_id')->select(['cc_id', 'title', 'slug']);
  }

  public static function faqList($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false,$limit=false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }
    $query = FAQModel::with('category')->select($fields);

    $catId = isset($filterArr['category_id']) ? intval($filterArr['category_id']) : 0;
    if ($catId > 0) {
      $query->where('cc_id', '=', $catId);
    }
    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }
    if ($limit) {
      $query->limit($limit);
    }

    $search = isset($filterArr['search']) ? $filterArr['search'] : '';
    if ($search != '') {
      $query->where(function ($query) use ($search) {
        return $query
          ->where('title', 'LIKE', '%' . $search . '%')
          ->orWhere('descp', 'LIKE', '%' . $search . '%');
      });
    }

    if ($orderBy == false && $order == false) {
      $orderBy = 'faq_id';
      $order = 'DESC';
    }

    $query->orderBy($orderBy, $order);
    return $perPage ? $query->paginate($perPage) : $query->get();
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
