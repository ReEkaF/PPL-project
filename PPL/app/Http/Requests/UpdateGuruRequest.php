<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuruRequest extends FormRequest
{
    /**
     * 
     *
     * @return array<string, 
     */
    public function rules()
    {
        $id_guru = $this->route('id_guru'); 

        return [
            'username' => 'required|string|min:8|max:50|unique:guru,username,' . $id_guru . ',id_guru',
            'password' => 'nullable|string|min:8', 
            'nama_guru' => 'required|string|max:125',
            'nip' => 'required|string|max:20|unique:guru,nip,' . $id_guru . ',id_guru',
            'alamat_guru' => 'required|string|max:255',
            'role_guru' => 'required|in:guru,pembina,wali_kelas',
            'foto_guru' => 'nullable|image|max:25000', 
            'nomor_wa_guru' => 'required|digits_between:12,13',
            'email' => 'required|email|max:255|unique:guru,email,' . $id_guru . ',id_guru',
        ];
    }

    /**
     * 
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.min' => 'Username minimal 8 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'password.min' => 'Password minimal 8 karakter.',
            'nama_guru.required' => 'Nama wajib diisi.',
            'nama_guru.max' => 'Nama maksimal 125 karakter.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nip.max' => 'NIP maksimal 20 karakter.',
            'alamat_guru.required' => 'Alamat wajib diisi.',
            'alamat_guru.max' => 'Alamat maksimal 255 karakter.',
            'role_guru.required' => 'Role Guru wajib dipilih.',
            'role_guru.in' => 'Role Guru tidak valid.',
            'foto_guru.image' => 'Foto harus berupa gambar.',
            'foto_guru.max' => 'Ukuran foto maksimal 25 MB.',
            'nomor_wa_guru.required' => 'Nomor WhatsApp wajib diisi.',
            'nomor_wa_guru.digits_between' => 'Nomor WhatsApp harus antara 12 hingga 13 digit.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.max' => 'Email maksimal 255 karakter.',
        ];
    }
}
