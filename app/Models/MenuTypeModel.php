<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\MenuModel;

class MenuTypeModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_type';

    protected $primaryKey = 'menu_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'menu_name',
        'menu_for',
        'c_order',
        'status',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'menu_type_id'
    ];



    public function menus()
    {
        return $this->hasMany(MenuModel::class, 'menu_type_id')->where('status', '=', 1)->orderBy('c_order', 'asc');
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



    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */

    public static function getMenu($menu_for = 'p', $menu_name = '', $append_container_class = '', $ul_class = 'ul-navbar')
    {
        $query = MenuTypeModel::with(['menus' => function ($query) {
            $query->where(['parent_menu_id' => 0]);
        }])->where(['menu_for' => $menu_for, 'status' => 1]);
        if ($menu_name)
            $query->where(['menu_name' => trim($menu_name)]);
        $menuTypeModel = $query->orderBy('c_order', 'asc')
            ->first();
        $menuHtml = '';
        if ($menuTypeModel && $menuTypeModel->menus->count() > 0) {
            if ($append_container_class != '') {
                $menuHtml .= '<div class="' . $append_container_class . '">';
            }
            $menuHtml .= '<ul class="' . $ul_class . '">';
            foreach ($menuTypeModel->menus as $menu) {
                $image_url = $menu->image_url ? '<span><img src="' . $menu->image_url . '" alt="' . $menu->label . '"></span>' : '';
                $target = $menu->link_target ? ('target="' . $menu->link_target . '"') : '';
                $cssClass = $menu->menu_class ? ('class="' . $menu->menu_class . '"') : '';
                $hint = $menu->hint ? 'title="' . $menu->hint . '"' : '';

                $link = '/';
                if ($menu->is_link) {
                    $link = $menu->external_link;
                } else if ($slug = $menu->getModulePageName()) {
                    $link = $slug;
                }
                if (request()->is(ltrim($link, '/')))
                    $cssClass = $cssClass . ' active';

                if ($cssClass)
                    $cssClass = 'class="' . trim($cssClass) . '"';

                $menuHtml .= '<li ' . $cssClass . '  ' . $hint . ' id="menu_' . $menu->menu_type_id . '_' . $menu->menu_id . '">';

                if (isset($menu->menuchildren) && $menu->menuchildren->count() > 0) {
                    $menuHtml .= '<span class="sub_menu_pretext">' . $menu->label . '</span><ul class="sub_menu">';
                    foreach ($menu->menuchildren as $menuchild) {
                        if ($menuchild->is_link) {
                            $link = $menuchild->external_link;
                        } else if ($slug = $menuchild->getModulePageName()) {
                            $link = $slug;
                        }
                        $image_url = $menuchild->image_url ? '<span><img src="' . $menuchild->image_url . '" alt="' . $menuchild->label . '"></span>' : '';
                        $target = $menuchild->link_target ? ('target="' . $menuchild->link_target . '"') : '';
                        $cssClass = $menuchild->link_target ? ('class="' . $menuchild->menu_class . '"') : '';
                        $hint = $menuchild->hint ? 'title="' . $menuchild->hint . '"' : '';

                        if (request()->is(ltrim($link, '/')))
                            $cssClass = $cssClass . ' active';

                        if ($cssClass)
                            $cssClass = 'class="' . trim($cssClass) . '"';

                        $menuHtml .= '<li ' . $cssClass . ' ' . $hint . ' id="menu_' . $menuchild->menu_type_id . '_' . $menuchild->menu_id . '"><a href="' . $link . '" ' . $target . '>' . $menuchild->label . $image_url . '</a></li>';
                    }
                    $menuHtml .= '</ul>';
                } else {
                    $menuHtml .= '<a href="' . $link . '" ' . $target . '>' . $menu->label . $image_url . '</a>';
                }
                $menuHtml .= '</li>';
            }
            $menuHtml .= '</ul>';
            if ($append_container_class != '') {
                $menuHtml .= '</div>';
            }
        }

        return $menuHtml;
    }
    public static function getMenuV2($menu_for = 'p', $menu_name = '', $append_container_class = '', $ul_class = 'ul-navbar')
    {
        $query = MenuTypeModel::with(['menus' => function ($query) {
            $query->where(['parent_menu_id' => 0]);
        }])->where(['menu_for' => $menu_for, 'status' => 1]);
        if ($menu_name)
            $query->where(['menu_name' => trim($menu_name)]);
        $menuTypeModel = $query->orderBy('c_order', 'asc')
            ->first();
        $menuHtml = '';
        if ($menuTypeModel && $menuTypeModel->menus->count() > 0) {
            if ($append_container_class != '') {
                $menuHtml .= '<div class="' . $append_container_class . '">';
            }
            $menuHtml .= '<ul class="' . $ul_class . '">';
            foreach ($menuTypeModel->menus as $menu) {
                $image_url = $menu->image_url ? '<span><img src="' . $menu->image_url . '" alt="' . $menu->label . '"></span>' : '';
                $target = $menu->link_target ? ('target="' . $menu->link_target . '"') : '';
                $cssClass = $menu->menu_class ? ('class="' . $menu->menu_class . '"') : '';
                $hint = $menu->hint ? 'title="' . $menu->hint . '"' : '';

                $link = '/';
                if ($menu->is_link) {
                    $link = $menu->external_link;
                } else if ($slug = $menu->getModulePageName()) {
                    $link = $slug;
                }
                if (request()->is(ltrim($link, '/')))
                    $cssClass = $cssClass . ' active';

                if ($cssClass)
                    $cssClass = 'class="' . trim($cssClass) . '"';

                $menuHtml .= '<li ' . $cssClass . '  ' . $hint . ' id="menu_' . $menu->menu_type_id . '_' . $menu->menu_id . '">';

                if (isset($menu->menuchildren) && $menu->menuchildren->count() > 0) {
                    $menuHtml .= '<span class="sub_menu_pretext">' . $menu->label . '</span><ul class="sub_menu">';
                    foreach ($menu->menuchildren as $menuchild) {
                        if ($menuchild->is_link) {
                            $link = $menuchild->external_link;
                        } else if ($slug = $menuchild->getModulePageName()) {
                            $link = $slug;
                        }
                        $image_url = $menuchild->image_url ? '<span><img src="' . $menuchild->image_url . '" alt="' . $menuchild->label . '"></span>' : '';
                        $target = $menuchild->link_target ? ('target="' . $menuchild->link_target . '"') : '';
                        $cssClass = $menuchild->link_target ? ('class="' . $menuchild->menu_class . '"') : '';
                        $hint = $menuchild->hint ? 'title="' . $menuchild->hint . '"' : '';

                        if (request()->is(ltrim($link, '/')))
                            $cssClass = $cssClass . ' active';

                        if ($cssClass)
                            $cssClass = 'class="' . trim($cssClass) . '"';

                        $menuHtml .= '<li ' . $cssClass . ' ' . $hint . ' id="menu_' . $menuchild->menu_type_id . '_' . $menuchild->menu_id . '"><a href="' . $link . '" ' . $target . '>' . $menuchild->label . $image_url . '</a></li>';
                    }
                    $menuHtml .= '</ul>';
                } else {
                    $menuHtml .= '<a href="' . $link . '" ' . $target . '>' . $menu->label . $image_url . '</a>';
                }
                $menuHtml .= '</li>';
            }
            $menuHtml .= '</ul>';
            if ($append_container_class != '') {
                $menuHtml .= '</div>';
            }
        }

        return $menuHtml;
    }

    public static function getCustomMenu($menu_for = 'p', $menu_name = '')
    {
        $query = MenuTypeModel::with(['menus' => function ($query) {
            $query->where(['parent_menu_id' => 0]);
        }])->where(['menu_for' => $menu_for, 'status' => 1]);
        if ($menu_name)
            $query->where(['menu_name' => trim($menu_name)]);
        $menuTypeModel = $query->orderBy('c_order', 'asc')
            ->first();
        $menuHtml = '';
        if ($menuTypeModel && $menuTypeModel->menus->count() > 0) {
            $menuHtml .= '<ul class="navbar-nav d-flex align-items-center">';
            foreach ($menuTypeModel->menus as $menu) {
                $image_url = $menu->image_url ? '<figure><img src="' . $menu->image_url . '" alt="' . $menu->label . '"></figure>' : '';
                $target = $menu->link_target ? ('target="' . $menu->link_target . '"') : '';
                $cssClass = $menu->menu_class ? $menu->menu_class : '';
                $hint = $menu->hint ? 'title="' . $menu->hint . '"' : '';

                $link = '/';
                if ($menu->is_link) {
                    $link = $menu->external_link;
                } else if ($slug = $menu->getModulePageName()) {
                    $link = $slug;
                }

                if (request()->is(ltrim($link, '/')))
                    $cssClass = $cssClass . ' active';
                if ($cssClass)
                    $cssClass = 'class="' . trim($cssClass) . '"';

                $menuHtml .= '<li ' . $cssClass . '  ' . $hint . ' id="menu_' . $menu->menu_type_id . '_' . $menu->menu_id . '">';

                $menuHtml .= '<a href="' . $link . '" ' . $target . ' class="nav-link">' . $image_url;
                $menuHtml .= $menu->label;
                $menuHtml .= '</a>';
                $menuHtml .= '</li>';
            }
            $menuHtml .= '</ul>';
        }

        return $menuHtml;
    }

    public static function getCustomPrimaryMenu($menu_for = 'p', $menu_name = '', $append_container_class = '')
    {
        $currentURL = url()->current();

        $query = MenuTypeModel::with(['menus' => function ($query) {
            $query->where(['parent_menu_id' => 0]);
        }])->where(['menu_for' => $menu_for, 'status' => 1]);
        if ($menu_name)
            $query->where(['menu_name' => trim($menu_name)]);
        $menuTypeModel = $query->orderBy('c_order', 'asc')
            ->first();
        $menuHtml = '';
        if ($menuTypeModel && $menuTypeModel->menus->count() > 0) {
            $menuHtml .= '<nav class="' . $append_container_class . '"><ul class="navbar-nav d-flex align-items-center">';
            foreach ($menuTypeModel->menus as $key => $menu) {
                $image_url  = $menu->image_url ? '<span><img src="' . $menu->image_url . '" alt="' . $menu->label . '"></span>' : '';
                $target     = $menu->link_target ? ('target="' . $menu->link_target . '"') : '';
                $cssClass   = $menu->menu_class ? $menu->menu_class : '';
                $hint       = $menu->hint ? 'title="' . $menu->hint . '"' : '';

                $link = '/';
                if ($menu->is_link) {
                    $link = $menu->external_link;
                } elseif ($slug = $menu->getModulePageName()) {
                    $link = $slug;
                }

                if (isset($menu->menuchildren) && $menu->menuchildren->count() > 0)
                    $cssClass = $cssClass . ' nav-item dropdown';
                if (request()->is(ltrim($link, '/')))
                    $cssClass = $cssClass . ' active';
                if ($cssClass)
                    $cssClass = 'class="' . trim($cssClass) . '"';

                $menuHtml .= '<li ' . $cssClass . '  ' . $hint . ' id="menu_' . $menu->menu_type_id . '_' . $menu->menu_id . '">';

                if (isset($menu->menuchildren) && $menu->menuchildren->count() > 0) {
                    $menuHtml .= '<a class="nav-link dropdown-toggle" href="' . $link . '" ' . $target . ' id="navbarDropdown_' . $menu->menu_type_id . '_' . $menu->menu_id . '" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $menu->label . $image_url . '</a>';
                    $menuHtml .= '<div class="dropdown-menu" aria-labelledby="navbarDropdown_' . $menu->menu_type_id . '_' . $menu->menu_id . '">';
                    foreach ($menu->menuchildren as $key => $menuchild) {
                        $menuGrandChildren = isset($menuchild->menuchildren) && $menuchild->menuchildren->count() > 0 ? $menuchild->menuchildren : '';
                        /* if (!$menuGrandChildren && $key == 0) {
                            $menuHtml .= '<div class="subMenu"><ul>';
                        } */

                        $image_url  = $menuchild->image_url ? '<span><img src="' . $menuchild->image_url . '" alt="' . $menuchild->label . '"></span>' : '';
                        $target     = $menuchild->link_target ? ('target="' . $menuchild->link_target . '"') : '';
                        $cssClass   = $menuchild->menu_class ? $menuchild->menu_class : '';
                        /* if (request()->is(ltrim($link, '/')))
                            $cssClass = $cssClass . ' active'; */

                        if ($cssClass)
                            $cssClass = trim($cssClass);

                        $hint       = $menuchild->hint ? 'title="' . $menuchild->hint . '"' : '';

                        $link = '/';
                        if ($menuchild->is_link) {
                            $link = $menuchild->external_link;
                        } else if ($slug = $menuchild->getModulePageName()) {
                            $link = $slug;
                        }

                        if ($menuGrandChildren) {
                            $cssClass = 'class="subMenu ' . $cssClass . '"';
                            $menuHtml .= '<div ' . $cssClass . '><h4>' . $menuchild->label . '</h4><ul>';
                            foreach ($menuGrandChildren as $key => $menuGrandChild) {
                                $link = '/';
                                if ($menuGrandChild->is_link) {
                                    $link = $menuGrandChild->external_link;
                                } else if ($slug = $menuGrandChild->getModulePageName()) {
                                    $link = $slug;
                                }
                                $image_url  = $menuGrandChild->image_url ? '<span><img src="' . $menuGrandChild->image_url . '" alt="' . $menuGrandChild->label . '"></span>' : '';
                                $target     = $menuGrandChild->link_target ? ('target="' . $menuGrandChild->link_target . '"') : '';
                                $cssClass   = $menuGrandChild->menu_class ? $menuGrandChild->menu_class : '';
                                if (request()->is(ltrim($link, '/')))
                                    $cssClass = $cssClass . ' active';

                                if ($cssClass)
                                    $cssClass = 'class="' . trim($cssClass) . '"';

                                $hint       = $menuGrandChild->hint ? 'title="' . $menuGrandChild->hint . '"' : '';
                                $menuHtml .= '<li ' . $cssClass . ' id="menu_' . $menuGrandChild->menu_type_id . '_' . $menuGrandChild->menu_id . '"><a href="' . $link . '" ' . $target . ' ' . $hint . ' >' . $menuGrandChild->label . $image_url . '</a></li>';
                            }
                            $menuHtml .= '</ul></div>';
                        } else {
                            if ($cssClass)
                                $cssClass = 'class="' . trim($cssClass) . '"';

                            $menuHtml .= '<a href="' . $link . '" ' . $target . ' ' . $hint . ' ' . $cssClass . '>' . $menuchild->label . $image_url . '</a>';
                        }
                    }
                    /* if (!$menuGrandChildren) {
                        $menuHtml .= '</ul></div>';
                    } */
                    $menuHtml .= '</div>';
                } else {
                    $menuHtml .= '<a href="' . $link . '" ' . $target . '>' . $menu->label . $image_url . '</a>';
                }
                $menuHtml .= '</li>';
            }
            $menuHtml .= '</ul></nav>';
        }
        return $menuHtml;
    }


    public function getMenuforAssoc()
    {
        return array('p' => 'Primary', 's' => 'Sidebar', 'f' => 'Footer', 'o' => 'Others');
    }

    public function checkDuplicateMenufor($menu_for)
    {
        $list = ['p', 's', 'f'];
        $check = MenuTypeModel::whereIn('menu_for', $list)->where('menu_for', '=', $menu_for)->count();
        if ($check > 0)
            return true;
        return false;
    }

    public function updateDuplicateMenufor()
    {
        $list = ['p', 's', 'f'];
        $duplicateModel = MenuTypeModel::whereIn('menu_for', $list)->where('menu_for', '=', $this->menu_for)->where('menu_type_id', '!=', $this->menu_type_id)->first();
        if ($duplicateModel) {
            $duplicateModel->menu_for = 'o';
            $duplicateModel->save();
        }
    }
    public function getTopMenu($menu_for = 'p', $menu_name = '', $append_container_class = '', $ul_class = 'ul-navbar'){
        $query = MenuTypeModel::with(['menus' => function ($query) {
            $query->where(['parent_menu_id' => 0]);
        }])->where(['menu_for' => $menu_for, 'status' => 1]);
        if ($menu_name)
            $query->where(['menu_name' => trim($menu_name)]);
        $menuTypeModel = $query->orderBy('c_order', 'asc')
            ->first();
            $menuhtml=' <div class="navbar-nav">';
            foreach($menuTypeModel->menus as $key=>$val){
                $link = '/';
                if ($val->is_link) {
                    $link = $val->external_link;
                } elseif ($slug = $val->getModulePageName()) {
                    $link = $slug;
                }
                if($val->menuchildren->count()>0){
                    $menuhtml .="<li class='nav-item dropdown'>";
                    $menuhtml .='<a  id="menu_' . $val->menu_type_id . '_' . $val->menu_id . '"  class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.$val->label.'</a>';
                    $menuhtml .='<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    foreach($val->menuchildren as $childKey=>$childVal){
                        $Childlink = '/';
                        if ($childVal->is_link) {
                            $Childlink = $childVal->external_link;
                        } else if ($slug = $childVal->getModulePageName()) {
                            $Childlink = $slug;
                        }
                        $menuhtml .='<li><a id="menu_child_' . $val->menu_type_id . '_' . $val->menu_id . '_' . $val->menchildKeyu_id . '" class="dropdown-item" href="'.$Childlink.'">'.$childVal->label.'</a></li>';
                        }
                    $menuhtml .='</ul>';
                    $menuhtml .="</li>";
                }else{
                    $menuhtml .='  <a chilsdcout="'.$val->menuchildren->count().'" id="menu_' . $val->menu_type_id . '_' . $val->menu_id . '" class="nav-link" href="'.$link.'" target="'.$val->link_target.'">'.$val->label.'</a>';

                }
            }
            $menuhtml .='</div>';
            return $menuhtml;
    }
}
