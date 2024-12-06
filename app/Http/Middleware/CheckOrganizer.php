<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganizer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('organizer')->check()) {
            return redirect()->route('organizer.login');
        }
        return $next($request);
    }
}
