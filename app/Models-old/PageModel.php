<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Lib\Core\Core;

use App\Models\TemplateModel;
use App\Models\MediaModel;
use App\Models\AdminModel;

class PageModel extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'pages';

  protected $primaryKey = 'page_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'slug',
    'descp',
    'media_id',
    'parent',
    'template_id',
    'note',
    'meta_title',
    'meta_key',
    'meta_descp',
    'c_order',
    'status',
    'updated_id'
  ];

  protected $guarded = [
    'page_id'
  ];



  public function media()
  {
    return $this->hasOne(MediaModel::class, 'media_id', 'media_id');
  }

  public static function pageList($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }

    $with = isset($filterArr['with']) ? $filterArr['with'] : '';
    if ($with != '') {
      $query = PageModel::with($with)->select($fields);
    } else {
      $query = PageModel::select($fields);
    }

    $idArr = isset($filterArr['ids']) ? $filterArr['ids'] : [];
    if (!empty($idArr)) {
      $query->whereIn('page_id', $idArr);
    }
    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }
    $parent = isset($filterArr['parent']) ? intval($filterArr['parent']) : 0;
    if ($parent > 0) {
      $query->where('parent', '=', $parent);
    }

    if ($orderBy == false && $order == false) {
      $orderBy = 'page_id';
      $order = 'DESC';
    }

    $query->orderBy($orderBy, $order);
    return $perPage ? $query->paginate($perPage) : $query->get();
  }

  public static function getData($class_id = 0, $slug = false, $dataId = 0, $fields = false, $filterArr = false)
  {
    $status = Config('commonconstants.status_val.1');
    if ($fields == false) {
      $fields = ['page_id', 'template_id', 'title', 'slug', 'descp', 'media_id', 'meta_title', 'meta_key', 'meta_descp'];
    }
    $dataArr = self::getPageData($class_id, $dataId, $status, $fields, $slug, $filterArr);
    // echo "<pre>";
    //     print_r($dataArr);
    //     echo "</pre>";
    //     die();
    return $dataArr;
  }


  /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

  public function parentpage()
  {
    return $this->hasOne(PageModel::class, 'page_id', 'parent');
  }

  public function updatedby()
  {
    return $this->hasOne(AdminModel::class, 'admin_id', 'updated_id');
  }

  public function template()
  {
    return $this->hasOne(TemplateModel::class, 'template_id', 'template_id');
  }



  /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */

  public static function getPageData($class_id = 0, $dataId = 0, $status = 0, $fields = false, $slug = false, $filterArr = false)
  {
    if ($fields == false) {
      $fields = ['page_id', 'template_id', 'title', 'descp', 'media_id'];
    }
    $query = PageModel::with('media')->select($fields);

    if ($status > 0) {
      $where = ['status' => $status];
      $query->where($where);
    }
    if ($dataId > 0) {
      $where = ['page_id' => $dataId];
    }
    if ($slug != false) {
      $where = ['slug' => $slug];
    }
    $dataObj = $query->where($where)->first();

    $responseArr = [];
    if ($dataObj) {
      $commonconstants = Config('commonconstants');

      $rowData = $dataObj->toArray();

      $mediaFolder = Core::getUploadedURL($commonconstants['media_dir_name']);

      $responseArr['media_folder'] = $mediaFolder;

      $responseArr = array_merge($responseArr, $rowData);

      if (isset($rowData['media_id'])) {

        if (!empty($rowData['media'])) {
          $responseArr['image_name'] = $rowData['media']['path'];
          $responseArr['image_path'] = $mediaFolder . $rowData['media']['path'];
          $responseArr['image_alt'] = $rowData['media']['alt'];
          $responseArr['image_title'] = $rowData['media']['title'];
        } else {
          $responseArr['image_name'] = '';
          $responseArr['image_path'] = '';
          $responseArr['image_alt'] = '';
          $responseArr['image_title'] = '';
        }
      }
      // unset($responseArr['page_id']);
      unset($responseArr['media_id']);
      unset($responseArr['media']);
      unset($responseArr['media']['media_id']);
      unset($responseArr['media']['path']);

      if (isset($rowData['page_id'])) {
        $pageId = intval($rowData['page_id']);
        $template_id = (isset($rowData['template_id'])) ? intval($rowData['template_id']) : 46;

        if ($class_id > 0 && $template_id > 0 && $pageId > 0) {
          if (isset($filterArr['cf_types']) && !empty($filterArr['cf_types'])) {
            $field_forArr = $filterArr['cf_types'];
          } else {
            $field_forArr = [$commonconstants['medium']['value'][0], $commonconstants['medium']['value'][1], $commonconstants['medium']['value'][2]];
          }
          $cfArr = CustomFieldGroupValueModel::getCfGroupDataValues($class_id, $template_id, $pageId, $field_forArr);
          if (is_array($cfArr) && count($cfArr) > 0) {
            $responseArr['custom_fields'] = $cfArr;
          }
        }
      }
    }
    return $responseArr;
  }

  /*
    ** Get total count of particular template used.
    */
  public function getTemplateCountByTemplateID()
  {
    if (isset($this->template_id) && $this->template_id > 0)
      return PageModel::where(['template_id' => $this->template_id])->count();
    return false;
  }

  public function getPageName()
  {
    if (isset($this->template_id) && $this->template_id > 0) {
      $templateModel = new TemplateModel;
      $templateModel->template_id = $this->template_id;
      $templateSlug = $templateModel->getTemplateByID($value = 'slug');
      $total = (int) $this->getTemplateCountByTemplateID();
      if ($total > 1)
        return '/' . strtolower($templateSlug) . '/' . $this->slug;
      else
        return '/' . strtolower($templateSlug);
    }
    return false;
  }
}
