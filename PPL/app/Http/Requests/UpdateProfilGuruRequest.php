<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfilGuruRequest extends FormRequest
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
        $idGuru = Auth::guard('web-guru')->user()->id_guru;
    
        return [
            'username' => 'required|string|min:8|max:255|unique:guru,username,' . $idGuru . ',id_guru',
            'email' => 'required|email:rfc,dns|max:255|unique:guru,email,' . $idGuru . ',id_guru',
            'nomor_wa_guru' => 'required|digits_between:12,13|string|max:15',
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
            'nomor_wa_guru.required' => 'Nomor telepon harus diisi.',
            'nomor_wa_guru.digits_between' => 'Nomor telepon harus terdiri angka 12 hingga 13 digit.',
            'current_password.string' => 'Password lama harus berupa string.',
            'new_password.min' => 'Password baru harus memiliki minimal 8 karakter.',
            'new_password.confirmed' => 'Password baru tidak cocok dengan konfirmasi password.',
        ];
    }
}

