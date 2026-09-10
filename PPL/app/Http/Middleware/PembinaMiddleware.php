<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembinaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('web-guru')->check()) {
            return redirect()->route('login')->withErrors(['username' => 'Silakan login terlebih dahulu']);
        }

        $guru = Auth::guard('web-guru')->user();

        // Cek apakah guru adalah pembina (berdasarkan kolom role_guru atau relasi ekstrakurikuler)
        $isPembina = ($guru->role_guru === 'pembina' || $guru->ekstrakurikuler()->exists() || session('role_guru') === 'pembina');

        if ($isPembina) {
            if (session('role_guru') !== 'pembina') {
                session()->put('role_guru', 'pembina');
            }

            return $next($request);
        }

        return redirect()->route('guru.dashboard')->with('error', 'Akses fitur ekstrakurikuler hanya untuk guru pembina.');
    }
}
