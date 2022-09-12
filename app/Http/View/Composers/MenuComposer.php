<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

use App\Models\ModuleModel;
use App\Models\MenuTypeModel;

class MenuComposer
{
	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view)
	{
		if (auth()->guard('admin')->user()) {
			$role_id = auth()->guard('admin')->user()->role_id;
			$menu = '';
			$menu .= '<ul class="pcoded-item pcoded-left-item">';

			// \DB::enableQueryLog(); // Enable query log
			$moduleModel = ModuleModel::with('modulechildren')->whereHas('modulemethods', function ($q) use ($role_id) {
				$q->whereHas('modulemethodrights', function ($q2) use ($role_id) {
					$q2->where('role_id', $role_id);
				});
			})->where(['parent_module_id' => 0, 'status' => 1, 'is_menu' => 1])->orderBy('c_order', 'asc')->get();


			foreach ($moduleModel as $key => $module) {
				$persMethodModels = $module->getPermissionableModuleMethods($role_id);

				if (!empty($persMethodModels) && $persMethodModels->count() > 0) {
					if ($persMethodModels->count() == 1 && $module->modulechildren->count() == 0) {
						$active = request()->routeIs($persMethodModels[0]->route_link) ? 'active' : '';
						$is_external_link = $persMethodModels[0]->is_external_link;
						$route_link = $is_external_link ? $persMethodModels[0]->route_link : route($persMethodModels[0]->route_link);
						$target = $is_external_link ? ' target="_blank"' : '';
						$menu .= '<li class="' . $active . '" ' . $target . '>
						<a href="' . $route_link . '" class="waves-effect waves-dark">
						<span class="pcoded-micon"><i class="ti-view-list"></i><b>D</b></span>
						<span class="pcoded-mtext">' . $module->label . '</span>
						<span class="pcoded-mcaret"></span>
						</a>
						</li>';
						continue;
					}

					$controller = class_basename(\Route::getCurrentRoute()->getActionName());
					list($controller, $action) = explode('@', $controller);
					$parActive = '';
					if (strcmp($controller, $module->class_name) == 0) {
						$parActive = 'active pcoded-trigger';
					}
					if (!$parActive && !empty($module->modulechildren) && $module->modulechildren->count() > 0) {
						foreach ($module->modulechildren as $modulechild) {
							if (strcmp($controller, $modulechild->class_name) == 0) {
								$parActive = 'active pcoded-trigger';
								break;
							}
						}
					}

					$menu .= ' <li class="pcoded-hasmenu ' . $parActive . '">
					<a href="javascript:void(0)" class="waves-effect waves-dark"> <span class="pcoded-micon"><i class="ti-view-list"></i><b>A</b></span> <span class="pcoded-mtext">' . $module->label . '</span> <span class="pcoded-mcaret"></span> </a><ul class="pcoded-submenu">';
					if (!empty($persMethodModels)) {
						$tmpSameModuleMethodNameArr = $sameModuleMethodNameArr = [];
						foreach ($persMethodModels as $key => $chkMenuModule) {
							array_push($tmpSameModuleMethodNameArr, $chkMenuModule->method_name);
							if (in_array($chkMenuModule->method_name, $tmpSameModuleMethodNameArr))
								array_push($sameModuleMethodNameArr, $chkMenuModule->method_name);
						}
						foreach ($persMethodModels as $keym => $menumethod) {
							if (in_array($menumethod->method_name, $sameModuleMethodNameArr))
								$active = (request()->url() == route($menumethod->route_link)) ? 'active' : '';
							else
								$active = request()->routeIs($menumethod->route_link) ? 'active' : '';
							$is_external_link = $menumethod->is_external_link;
							$route_link = $is_external_link ? $menumethod->route_link : route($menumethod->route_link);
							$target = $is_external_link ? ' target="_blank"' : '';
							$menu .= '<li class="' . $active . '">
							<a href="' . $route_link . '" class="waves-effect waves-dark" ' . $target . '> <span class="pcoded-micon"><i class="ti-layout-cta-right"></i><b>A</b></span> <span class="pcoded-mtext" data-i18n="nav.navigate.main">' . $menumethod->title . '</span> <span class="pcoded-mcaret"></span> </a>
							</li>';
						}
					}

					if (!empty($module->modulechildren) && $module->modulechildren->count() > 0) {
						foreach ($module->modulechildren as $keyc => $modulechild) {
							$persChildMethodModels = $modulechild->getPermissionableModuleMethods($role_id);
							if (!empty($persChildMethodModels) && $persChildMethodModels->count() > 0) {
								foreach ($persChildMethodModels as $keymc => $childmenumethod) {
									$active = request()->routeIs($childmenumethod->route_link) ? 'active' : '';
									$is_external_link = $childmenumethod->is_external_link;
									$route_link = $is_external_link ? $childmenumethod->route_link : route($childmenumethod->route_link);
									$target = $is_external_link ? ' target="_blank"' : '';

									$menu .= '<li class="' . $active . '">
									<a href="' . $route_link . '" class="waves-effect waves-dark" ' . $target . '> <span class="pcoded-micon"><i class="ti-layout-cta-right"></i><b>A</b></span> <span class="pcoded-mtext" data-i18n="nav.navigate.main">' . $childmenumethod->title . '</span> <span class="pcoded-mcaret"></span> </a>
									</li>';
								}
							}
						}
					}

					$menu .= '</ul></li>';
				}
			}
			$menu .= '</ul>';
			$view->with('menu', $menu);
		}

		#==Other menu ==#
		/*$webOtherMenu = MenuTypeModel::getMenu('o', 'header_top');
    	$view->with('headertopmenu', $webOtherMenu);*/

		#==Primary menu ==#
		/* $webPrimaryMenu = MenuTypeModel::getCustomMenu('p', '');
		$view->with('webprimarymenu', $webPrimaryMenu); */

		#==Primary menu ==#
		$webPrimaryMenu = MenuTypeModel::getCustomPrimaryMenu('p', '', '');
		$view->with('webprimarymenu', $webPrimaryMenu);

		#==Footer menu ==#
		$webFooterMenu = MenuTypeModel::getMenu('f', '', '', 'footer-links');
		$view->with('webfootermenu', $webFooterMenu);

		$webFooterQuickLinkMenu = MenuTypeModel::getMenu('o', 'footer-2', '', 'footer-links');
		$view->with('webfooterquicklinkmenu', $webFooterQuickLinkMenu);
		
		$webTopQuickLinkMenu = MenuTypeModel::getMenu('o', 'top-header', '', 'navbar-nav d-flex flex-row justify-content-end');
		$view->with('webtopquicklinkmenu', $webTopQuickLinkMenu);

		$webFooterLegalLinkMenu = MenuTypeModel::getMenu('o', 'footer-legal', '', 'footer-legal-links');
		$view->with('webfooterlegallinkmenu', $webFooterLegalLinkMenu);
	}
}
