<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Lib\Admin\App;

class RedirectIfNotAdmin
{
/**
 * Handle an incoming request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Closure  $next
 * @param  string|null  $guard
 * @return mixed
 */
	public function handle($request, Closure $next, $guard = 'admin')
	{
	    if (!Auth::guard($guard)->check()) {
	        return redirect()->route('admin.login');
	    }

	    if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->role_id>1)
	    {
			$controller = class_basename(\Route::getCurrentRoute()->getActionName());
			list($controller, $action) = explode('@', $controller);
	    	$route = \Request::route()->getName();
	    	
	    	// echo "<pre>";
	    	// print_r(Auth::guard($guard)->user());
	    	// echo "</pre>";
	    	// echo $controller."<>".$action."<br/>";
	    	// echo $route."<br/>";
	    	// die("OK");

	    	if(!App::hasAccessToMethod($controller,$route)){
	    		abort(403, 'Unauthorized page access.');
	    	}
	    }

	    return $next($request);
    }
}  