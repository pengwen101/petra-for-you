<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            if (!$admin->active) {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'Your account is inactive.');
            }
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
