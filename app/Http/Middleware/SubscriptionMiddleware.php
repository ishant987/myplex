<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

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
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->u_id;

            // Retrieve user details
            $userdetails = User::where('u_id', $userId)->first();

            // Parse and compare subscription expiry date
            $expiry_datetime = Carbon::parse($userdetails->subscription_expiry_date);
            $today = Carbon::now();

            if ($expiry_datetime->isPast()) {
                // Redirect to the subscription lock route if the subscription has expired
                return redirect()->route('user.subscription_lock');
            }
        }

        // Proceed with the request
        return $next($request);
    }
}

