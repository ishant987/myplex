<?php

namespace App\Http\Middleware;

use Closure;

use App\ModuleUserGroupRightsModel;
use App\ModuleModel;

class GrantAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $controller = class_basename(\Route::getCurrentRoute()->getActionName());
        list($controller, $action) = explode('@', $controller);
        $route = \Request::route()->getName();
        print_r($controller);
        die();
        abort(404, 'Unauthorized page access.');

        $responseArr = ModuleUserGroupRightsModel::checkPermissionRight($controller);
        if($responseArr['success'] === false && isset($responseArr['redirectURL'])){
            return redirect($responseArr['redirectURL']);
        }

        return $next($request);
    }
}
