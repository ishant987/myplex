<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecureAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $authenticatedAt = $request->session()->get('secure_panel_authenticated_at');
        $expiresAt = $authenticatedAt ? now()->createFromTimestamp($authenticatedAt)->addMinutes(30) : null;

        if (!$authenticatedAt || !$expiresAt || $expiresAt->isPast()) {
            $request->session()->forget('secure_panel_authenticated_at');

            return redirect()->route('admin.secure-panel.login');
        }

        $request->session()->put('secure_panel_authenticated_at', now()->timestamp);

        return $next($request);
    }
}
