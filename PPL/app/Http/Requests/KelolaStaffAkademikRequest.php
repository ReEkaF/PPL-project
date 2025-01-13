<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelolaStaffAkademikRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        if (request('id_staff_akademik')) {
            return [
                'username' => 'required|string|max:255',
                'nama_staff_akademik'=> 'required|string|max:255',
                'alamat_staff_akademik'=> 'required|string|max:255',
                'wa_staff_akademik'=> 'required|regex:/^\+62\d{8,15}$/', // regex untuk nomor WhatsApp dengan kode negara +62
                'email' => 'required|email|max:255|unique:guru,email|unique:siswa,email|unique:staffakademik,email|unique:staffperpus,email' 
            ];
        }
        else {
            return [
                'username' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'nama_staff_akademik'=> 'required|string|max:255',
                'alamat_staff_akademik'=> 'required|string|max:255',
                'wa_staff_akademik'=> 'required|regex:/^\+62\d{8,15}$/', // regex untuk nomor WhatsApp dengan kode negara +62
                'email' => 'required|email|max:255|unique:guru,email|unique:siswa,email|unique:staffakademik,email|unique:staffperpus,email' 
            ];
        }
    }

    /**
     * Pesan kesalahan kustom untuk setiap aturan validasi.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.max' => 'Username maksimal 255 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'nama_staff_akademik.required' => 'Nama wajib diisi.',
            'nama_staff_akademik.max' => 'Nama maksimal 255 karakter.',
            'alamat_staff_akademik.required' => 'Alamat wajib diisi.',
            'alamat_staff_akademik.max' => 'Alamat maksimal 255 karakter.',
            'wa_staff_akademik.required' => 'Nomor WhatsApp wajib diisi.',
            'wa_staff_akademik.regex' => 'Nomor WhatsApp harus dimulai dengan +62 diikuti oleh 8 hingga 15 digit angka.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
        ];
    }
}
