<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userdetails = User::where('u_id', $user->u_id)->first() ?: $user;

            if (method_exists($userdetails, 'hasValidAccess') && $userdetails->hasValidAccess()) {
                return $next($request);
            }

            return redirect()->route('user.subscription_lock');
        }

        return $next($request);
    }
}
