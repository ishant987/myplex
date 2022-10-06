<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

use App\Lib\Core\Core;

use App\Models\SettingsModel;

class FrontendincludesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $optionKeyArr = ['title', 'logo', 'to_email', 'quick_link_1', 'quick_link_2', 'quick_contact_label', 'address', 'contact1', 'contact2', 'welcome_txt', 'facebook', 'twitter', 'linkedin'];
        $dataArr = SettingsModel::getSettingsArr($optionKeyArr, Config('commonconstants.status_val.1'));
        if (!empty($dataArr)) {
            $appTitle = Config('app.name');

            $dataArr = array_merge(array("media_folder" => Core::getUploadedURL(Config('commonconstants.setting_dir_name')), "def_img_ttl" => $appTitle, "def_img_alt" => $appTitle), $dataArr);
        }
        $view->with('optsDbArr', $dataArr);
    }
}
