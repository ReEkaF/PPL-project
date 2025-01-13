<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelolaPembinaEkstraRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|min:8|max:50',
            'nama_guru' => 'required|string|max:125',
            'nip' => 'required|string|max:20',
            'alamat_guru' => 'required|string|max:255',
            'foto_guru' => 'required|image|max:5000',
            'nomor_wa_guru' => 'required|digits_between:12,13',
            'email' => 'required|email|max:255',
        ];

    }

    public function messages()
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.min' => 'Username minimal 8 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'nama_guru.required' => 'Nama wajib diisi.',
            'nama_guru.max' => 'Nama maksimal 125 karakter.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nip.max' => 'NIP maksimal 20 karakter.',
            'alamat_guru.required' => 'Alamat wajib diisi.',
            'alamat_guru.max' => 'Alamat maksimal 255 karakter.',
            'foto_guru.required' => 'Foto wajib diunggah.',
            'foto_guru.image' => 'Foto harus berupa gambar.',
            'foto_guru.max' => 'Ukuran foto maksimal 5 MB.',
            'nomor_wa_guru.required' => 'Nomor WhatsApp wajib diisi.',
            'nomor_wa_guru.digits_between' => 'Nomor WhatsApp harus antara 12 hingga 13 digit.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.max' => 'Email maksimal 255 karakter.',
        ];
    }
}
