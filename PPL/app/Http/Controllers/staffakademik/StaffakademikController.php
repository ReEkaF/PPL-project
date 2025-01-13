<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileStaffAkademikRequest;
use App\Models\Staffakademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffakademikController extends Controller
{
    public function profile() {
        $profile=Staffakademik::where('id_staff_akademik', auth()->guard('web-staffakademik')->user()->id_staff_akademik)->first();
        return view('staff_akademik.profile.index',compact('profile'));
    }
    public function update(Request $request) {
        $request->validate([
            'username' => 'required|string|max:255',
            'nama_staff_akademik'=> 'required|string|max:255',
            'alamat_staff_akademik'=> 'required|string|max:255',
            'wa_staff_akademik'=> 'required|regex:/^\+62\d{8,15}$/', // regex untuk nomor WhatsApp dengan kode negara +62
            'email' => 'required|email|max:255|unique:guru,email|unique:siswa,email|unique:staffakademik,email|unique:staffperpus,email' 
        ], [
            'email.required' => 'Email harus terisi',
            'email.email' => 'Email harus berisi format yang benar',
            'wa_staff_akademik.required' => 'Nomer Wa perlu diisi',
            'wa_staff_akademik.numeric' => 'Nomer wa harus numeric',
            'wa_staff_akademik.digits_between' => 'Nomer wa harus 12-13 angka',
        ]);

        $profile=Staffakademik::where('id_staff_akademik', auth()->guard('web-staffakademik')->user()->id_staff_akademik)->first();
        $profile->update([
            'email' => $request->email,
            'wa_staff_akademik' => $request->wa_staff_akademik,
        ]);
        return view('staff_akademik.profile.index',compact('profile'));
    }
    public function update_profile(ProfileStaffAkademikRequest $request)
    {
        // Ambil data pengguna dari Auth guard
       $staff = Auth::guard('web-staffakademik')->user();

        // Pastikan pengguna login
        if (!$staff) {
            return redirect()->route('login')->withErrors(['username' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        // Periksa password lama jika diisi
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password,$staff->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }
        }

        // Update password jika password baru diisi
        if ($request->filled('new_password')) {
           $staff->password = Hash::make($request->new_password);
        }

        // Update data lainnya
       $staff->update([
            'username' => $request->username,  // Perbarui username
            'email' => $request->email, 
            'wa_staff_akademik'=>$request->wa_staff_akademik       // Perbarui email
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('staff_akademik.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
