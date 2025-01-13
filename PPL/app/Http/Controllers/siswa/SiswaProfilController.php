<?php

namespace App\Http\Controllers\Siswa;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfilSiswaRequest;

class SiswaProfilController extends Controller
{
    /**
     * Menampilkan profil siswa.
     */
    public function show()
    {
        // Ambil data pengguna dari Auth guard
        $siswa = Auth::guard('web-siswa')->user();

        // Pastikan pengguna login
        if (!$siswa) {
            return redirect()->route('login')->withErrors(['username' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        // Menampilkan halaman profil siswa
        return view('siswa.profil.index', compact('siswa'));
    }

    /**
     * Memperbarui profil siswa.
     */
    public function update(UpdateProfilSiswaRequest $request)
    {
        // Ambil data pengguna dari Auth guard
        $siswa = Auth::guard('web-siswa')->user();

        // Pastikan pengguna login
        if (!$siswa) {
            return redirect()->route('login')->withErrors(['username' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        // Periksa password lama jika diisi
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $siswa->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }
        }

        // Update password jika password baru diisi
        if ($request->filled('new_password')) {
            $siswa->password = Hash::make($request->new_password);
        }

        // Update data lainnya
        $siswa->update([
            'username' => $request->username,  // Perbarui username
            'email' => $request->email,        // Perbarui email
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('siswaprofil.show')->with('success', 'Profil berhasil diperbarui!');
    }
}
