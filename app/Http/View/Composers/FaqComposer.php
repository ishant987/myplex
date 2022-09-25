<?php
namespace App\Http\View\Composers;
use Illuminate\View\View;

use App\Models\ModuleModel;
use App\Models\FAQModel;

class FaqComposer{
/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view)
	{
        $commonconstants = Config('commonconstants');
        $status = $commonconstants['status_val'][1];
		$faqs = FAQModel::faqList(['category_id' => $commonconstants['def_faq_cat_id'], 'status' => $status], ['title', 'descp', 'faq_id'], 'c_order', 'ASC',3);
		$view->with('faqs', $faqs);
	}
}