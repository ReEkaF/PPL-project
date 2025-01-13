<?php
namespace App\Http\Controllers\Guru;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfilGuruRequest;

class ProfilController extends Controller
{
    /**
     * Menampilkan profil guru.
     */
    public function show()
    {
        // Ambil data pengguna dari Auth guard
        $guru = Auth::guard('web-guru')->user();

        // Pastikan pengguna login
        if (!$guru) {
            return redirect()->route('login')->withErrors(['username' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        return view('guru.profil.index', compact('guru'));
    }

    /**
     * Memperbarui profil guru.
     */
    public function update(UpdateProfilGuruRequest $request)
    {
        // Ambil data pengguna dari Auth guard
        $guru = Auth::guard('web-guru')->user();

        // Pastikan pengguna login
        if (!$guru) {
            return redirect()->route('login')->withErrors(['username' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        // Periksa password lama jika diisi
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $guru->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
            }
        }

        // Update password jika password baru diisi
        if ($request->filled('new_password')) {
            $guru->password = Hash::make($request->new_password);
        }

        // Update data lainnya
        $guru->update([
            'username' => $request->username,
            'email' => $request->email,
            'nomor_wa_guru' => $request->nomor_wa_guru,
        ]);

        return redirect()->route('profil.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
