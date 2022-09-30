<?php
namespace App\Http\View\Composers;
use Illuminate\View\View;

use App\Models\ModuleModel;
use App\Models\MenuTypeModel;

class HeaderAndFooterComposer{
/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view)
	{
		$webTopQuickLinkMenuNew = MenuTypeModel::getTopMenu('o', 'top-header-new', '', '');
		$view->with('webtopquicklinkmenuNew', $webTopQuickLinkMenuNew);

        $webFooterCompanyLinks = MenuTypeModel::getMenu('o', 'footer-company', '', '');
		$view->with('webFooterCompanyLinks', $webFooterCompanyLinks);

		$webFooterBusinessLinks = MenuTypeModel::getMenu('o', 'footer-business-type', '', '');
		$view->with('webFooterBusinessLinks', $webFooterBusinessLinks);

		$webFooterProductsLinks = MenuTypeModel::getMenu('o', 'footer-products', '', '');
		$view->with('webFooterProductsLinks', $webFooterProductsLinks);

		$webFooterExploreLinks = MenuTypeModel::getMenu('o', 'footer-explore', '', '');
		$view->with('webFooterExploreLinks', $webFooterExploreLinks);
	}
}