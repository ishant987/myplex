<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

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

            if (method_exists($user, 'hasActiveSubscription') && $user->hasActiveSubscription()) {
                return $next($request);
            }

            $userdetails = User::where('u_id', $user->u_id)->first();
            $expiryDate = $userdetails?->subscription_expiry_date;

            if (!$expiryDate) {
                return redirect()->route('user.subscription_lock');
            }

            $expiry_datetime = Carbon::parse($expiryDate);

            if ($expiry_datetime->isPast()) {
                return redirect()->route('user.subscription_lock');
            }
        }

        return $next($request);
    }
}
