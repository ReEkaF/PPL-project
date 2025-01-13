<?php

namespace App\Http\Controllers;

use App\Models\Superadmin;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\StaffAkademik;
use App\Models\StaffPerpus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            if($googleUser){
                $user = Superadmin::where('email', $googleUser->email)->first();
                if($user){
                    Auth::guard('web-superadmin')->login($user);
                    session()->put('username', $user->username);
                    $user->update([
                        'google_id'=>$googleUser->id,
                        'google_token'=>$googleUser->token,
                    ]);
                    return redirect()->route('superadmin.dashboard');
                }
                $user = Siswa::where('email', $googleUser->email)->first();
                if($user){
                    Auth::guard('web-siswa')->login($user);
                    session()->put('username', $user->username);
                    session()->put('role_siswa', $user->role_siswa);
                    $user->update([
                        'google_id'=>$googleUser->id,
                        'google_token'=>$googleUser->token,
                    ]);
                    return redirect()->route('lihat-jadwal-siswa');
                }
                $user = Guru::where('email', $googleUser->email)->first();
                if($user){
                    Auth::guard('web-guru')->login($user);
                    session()->put('username', $user->username);
                    session()->put('role_siswa', $user->role_guru);
                    $user->update([
                        'google_id'=>$googleUser->id,
                        'google_token'=>$googleUser->token,
                    ]);
                    return redirect()->route('lihat-jadwal-guru');
                }
                $user = StaffAkademik::where('email', $googleUser->email)->first();
                if($user){
                    Auth::guard('web-staffakademik')->login($user);
                    session()->put('username', $user->username);
                    $user->update([
                        'google_id'=>$googleUser->id,
                        'google_token'=>$googleUser->token,
                    ]);
                    return redirect()->route('staff_akademik.dashboard');
                }
                $user = StaffPerpus::where('email', $googleUser->email)->first();
                if($user){
                    Auth::guard('web-staffperpus')->login($user);
                    session()->put('username', $user->username);
                    $user->update([
                        'google_id'=>$googleUser->id,
                        'google_token'=>$googleUser->token,
                    ]);
                    return redirect()->route('staff_perpus.dashboard');
                }
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login gagal.');
        }
    }
}
