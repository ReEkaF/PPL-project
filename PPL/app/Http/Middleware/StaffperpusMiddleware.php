<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffperpusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated using the 'web-staffakademik' guard
        if (Auth::guard('web-staffperpus')->check()) {
            return $next($request);
        } else {
            return redirect()->route('login')->withErrors(['username' => 'Akses tidak diizinkan']);
        }
    }
}
