<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfilSiswaRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan membuat permintaan ini.
     */
    public function authorize()
    {
        return true;
    }
    

    /**
     * Aturan validasi untuk permintaan ini.
     */
    public function rules()
    {
        $idSiswa = Auth::guard('web-siswa')->user()->id_siswa;
    
        return [
            'username' => 'required|string|min:8|max:255|unique:siswa,username,' . $idSiswa . ',id_siswa', 
            'email' => 'required|email:rfc,dns|max:255|unique:siswa,email,' . $idSiswa . ',id_siswa', 
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed', 
        ];
    }    

    /**
     * Pesan error kustom untuk validasi.
     */
    public function messages()
    {
        return [
            'username.required' => 'Username harus diisi.',
            'username.min' => 'Username harus memiliki minimal 8 karakter.',
            'username.unique' => 'Username ini sudah digunakan.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'current_password.string' => 'Password lama harus berupa string.',
            'new_password.min' => 'Password baru harus memiliki minimal 8 karakter.',
            'new_password.confirmed' => 'Password baru tidak cocok dengan konfirmasi password.',
        ];
    }
}
