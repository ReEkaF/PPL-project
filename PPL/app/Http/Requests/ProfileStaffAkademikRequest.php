<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileStaffAkademikRequest extends FormRequest
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
        $idStaffAkademik = Auth::guard('web-staffakademik')->user()->id_staff_akademik;

        return [
            'username' => 'required|string|min:8|max:255|unique:staffakademik,username,' . $idStaffAkademik . ',id_staff_akademik',
            'email' => 'required|email:rfc,dns|max:255|unique:staffakademik,email,' . $idStaffAkademik . ',id_staff_akademik',
            'wa_staff_akademik'=> 'required|regex:/^\+62\d{8,15}$/',
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
            'wa_staff_akademik.required' => 'Nomor telepon harus diisi.',
            'wa_staff_akademik.regex' => 'Nomor WhatsApp harus dimulai dengan +62 diikuti oleh 8 hingga 15 digit angka.',
            'current_password.string' => 'Password lama harus berupa string.',
            'new_password.min' => 'Password baru harus memiliki minimal 8 karakter.',
            'new_password.confirmed' => 'Password baru tidak cocok dengan konfirmasi password.',
        ];
    }
}
