<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PembinaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guard('web-guru')->check() && session('role_guru') === 'pembina') {
           return $next($request);
            
        }else{
           return redirect()->route('login')->withErrors(['username' => 'Akses tidak diizinkan']);
        }
        
    }
}
