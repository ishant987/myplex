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
		$webTopQuickLinkMenuNew = MenuTypeModel::getTopMenu('p', 'primary_menu', '', '');
		$view->with('webtopquicklinkmenuNew', $webTopQuickLinkMenuNew);

        $webFooterCompanyLinks = MenuTypeModel::getMenu('f', '', '', 'footer-links');
		$view->with('webFooterCompanyLinks', $webFooterCompanyLinks);

		$webFooterBusinessLinks = MenuTypeModel::getMenu('o', 'footer-2', '', 'footer-links');
		$view->with('webFooterBusinessLinks', $webFooterBusinessLinks);

		$webFooterProductsLinks =  MenuTypeModel::getMenu('o', 'top-header', '', '');
		$view->with('webFooterProductsLinks', $webFooterProductsLinks);

		$webFooterExploreLinks = MenuTypeModel::getMenu('o', 'footer-explore', '', '');
		$view->with('webFooterExploreLinks', $webFooterExploreLinks);
	}
}