<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller as Controller;

use Auth;

use App\Models\ModuleClassModel;
// use App\UserSubscription;

class BaseController extends Controller
{
    public $page_path ;

    public function __construct()
    {
        $this->page_path =env('PAGE_PATHS','web.pages');
    }
    public static function getClassIdByname($class_name)
    {
        return ModuleClassModel::getClassIdByname($class_name);
    }

    public static function getClassIdBymodel($model_name)
    {
        return ModuleClassModel::getClassIdBymodel($model_name);
    }

    public static function getDefData()
    {
        $appTitle = Config('app.name');
        return array("def_img_ttl" => $appTitle, "def_img_alt" => $appTitle);
    }

    public static function getLoggedInUserId()
    {
        return (Auth::check()) ? Auth::user()->u_id : 0;
    }

    public static function getLoggedInUserProfileInfo()
    {
        return (Auth::check()) ? Auth::user() : [];
    }

    /* public static function getLoggedInUserSubscriptionInfo()
    {
        $response = [];
        if (Auth::check()) {
            $response = UserSubscription::getUserSubscriptionInfo(self::getLoggedInUserId());
        }
        return $response;
    } */
}
