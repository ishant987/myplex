<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;

use App\Models\MenuTypeModel;
use App\Models\TemplateModel;
use App\Models\PageModel;
use App\Models\ModuleClassModel;
use App\Models\AdminModel;

class MenuModel extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'menu';

  protected $primaryKey = 'menu_id';

  public $menu_data;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'menu_type_id',
    'class_id',
    'data_id',
    'label',
    'hint',
    'is_link',
    'external_link',
    'link_target',
    'menu_class',
    'image_url',
    'parent_menu_id',
    'c_order',
    'status',
    'created_id',
    'updated_id'
  ];

  protected $guarded = [
    'menu_type_id'
  ];

  protected $casts = [
    'menu_data' => 'array'
  ];


  public function menutype()
  {
    return $this->hasOne(MenuTypeModel::class, 'menu_type_id');
  }

  public function moduleclass()
  {
    return $this->hasOne(ModuleClassModel::class, 'class_id', 'class_id');
  }

  public function menuchildren()
  {
    return $this->hasMany(MenuModel::class, 'parent_menu_id')->orderBy('c_order', 'asc');
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
    return $this->hasOne(AdminModel::class, 'admin_id', 'updated_id');
  }

  public function getMenuTypesAssoc()
  {
    return MenuTypeModel::where('status', '=', 1)->orderBy('c_order', 'asc')->orderBy('menu_name', 'asc')->get(['menu_type_id', 'menu_name', 'label', 'menu_for'])->toArray();
  }

  public function getAllParentIDsByMenuID($menu_id)
  {
    $parentMenuIdArr = [];
    $parent_menu_id = MenuModel::where('menu_id', '=', $menu_id)->value('parent_menu_id');
    if ($parent_menu_id > 0) {
      array_push($parentMenuIdArr, $parent_menu_id);
      self::getAllParentIDsByMenuID($parent_menu_id);
    }
    return $parentMenuIdArr;
  }

  public function getChildIDsByMenuID($menu_id)
  {
    $menuModel = MenuModel::where('parent_menu_id', '=', $menu_id)->get('menu_id')->toArray();
    if ($menuModel) {
      return Arr::flatten($menuModel);
    }
  }

  public function getSubMenuAssoc()
  {
    $query = MenuModel::where(['menu_type_id' => $this->menu_type_id, 'status' => 1])
      ->where('menu_id', '!=', $this->menu_id);
    if ($this->parent_menu_id > 0) {
      $query->where('menu_id', '!=', $this->parent_menu_id);
      $allParentIDs = self::getAllParentIDsByMenuID($this->parent_menu_id);
      if ($allParentIDs && count($allParentIDs) > 0)
        $query->whereNotIn('menu_id', $allParentIDs);
      $allChildIDs = self::getChildIDsByMenuID($this->menu_id);
      if ($allChildIDs && count($allChildIDs) > 0)
        $query->whereNotIn('menu_id', $allChildIDs);
    }
    $query = $query->orderBy('label', 'ASC')->orderBy('c_order', 'asc')->get();
    return $query;
  }

  public function getMenu()
  {
    if (isset($this->menu_type_id) && $this->menu_type_id > 0) {
      return MenuModel::where(['menu_type_id' => $this->menu_type_id, 'parent_menu_id' => 0, 'status' => 1])->orderBy('c_order', 'asc')->orderBy('label', 'asc')->get();
    }
    return false;
  }

  public function getDefaultMenuType()
  {
    return MenuTypeModel::where('status', '=', 1)->orderBy('menu_for', 'asc')->orderBy('menu_name', 'asc')->value('menu_type_id');
  }

  public function getPages()
  {
    return PageModel::select('page_id', 'title', 'c_order')->where(['status' => 1])->orderBy('title', 'ASC')->orderBy('c_order', 'asc')->get();
  }



  /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */

  public function getModulePageName()
  {
    if ($this->class_id > 0 && $this->data_id > 0 && isset($this->moduleclass)) {
      $class_name = $this->moduleclass->class_name;
      $model_name = $this->moduleclass->model_name;
      if ($class_name) {
        $class_slug = $this->moduleclass->slug;
        $moduleName = current(explode('Controller', $class_name));
        // $modelName = '\\App\\' . '\\Models\\' . $model_name;
        $modelName = '\App\Models\\' . $model_name;
        $classModel = new $modelName();
        $refId = $classModel->getKeyName();
        $dataModel = $classModel->where($refId, '=', $this->data_id)->first();
        if ($dataModel) {
          $page = Config('webconstants.page_txt');
          if ($page == $moduleName) {
            if (isset($dataModel->template_id) && $dataModel->template_id > 0) {
              $templateModel = new TemplateModel;
              $templateModel->template_id = $dataModel->template_id;
              $templateSlug = $templateModel->getTemplateByID($value = 'slug');
              if ($templateSlug && strtolower($page) != $templateSlug) {
                $classModel->template_id = $dataModel->template_id;
                $total = (int) $classModel->getTemplateCountByTemplateID();
                if ($total > 1)
                  return '/' . strtolower($templateSlug) . '/' . $dataModel->slug;
                else
                  return '/' . strtolower($templateSlug);
              }
            }
            return '/' . strtolower($moduleName) . '/' . $dataModel->slug;
          } else {
            return '/' . strtolower($class_slug) . '/' . $dataModel->slug;
          }
        }
      }
    }
    return false;
  }
}
