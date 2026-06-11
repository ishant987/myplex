<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Lib\Core\MobileDetect;

use App\SettingsModel;

class SiteController extends BaseController
{
    public function detectMobile()
    {
        $optionKeyArr = ['google_play_app_link','apple_store_app_link'];
        $settingsArr = SettingsModel::getSettingsArr($optionKeyArr);
    	if($settingsArr && count($settingsArr)>0)
    	{	
    		#..IOS
    		$mdObj = new MobileDetect();
    		if($mdObj->isiOS())
    		{
    			$appleStoreAppLink = $settingsArr['apple_store_app_link'];
		        if($appleStoreAppLink != ""){
		          return redirect($appleStoreAppLink);
		        }
    		}
    		#..Android
    		if( $mdObj->isAndroidOS() )
    		{
		        $googlePlayAppLink = $settingsArr['google_play_app_link'];
		        if($googlePlayAppLink != ""){
		          return redirect($googlePlayAppLink);
		        }
		    }
    	}
    	return abort(404);
    }
}