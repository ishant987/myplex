<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnforceSingleSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionId = $request->session()->getId();

            if ($user->session_token && $user->session_token !== $sessionId) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('web.login')
                    ->with('alert', Config('frontconstants.alert_css.2'))
                    ->with('message', 'Your account was logged in from another device.')
                    ->with('title', __('web.error_ttl'));
            }

            if ($user->session_token !== $sessionId || !$user->is_session_active) {
                $user->forceFill([
                    'session_token' => $sessionId,
                    'is_session_active' => true,
                ])->save();
            }
        }

        return $next($request);
    }
}
