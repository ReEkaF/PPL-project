<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    /**
     * 
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 
     *
     * @return array<string, 
     */
    public function rules()
    {
        return [
            'nisn' => 'required|string|max:20|unique:siswa,nisn',
            'nama_siswa' => 'required|string|max:125',
            'tgl_lahir_siswa' => 'required|date',
            'jenis_kelamin_siswa' => 'required|in:Laki-laki,Perempuan',
            'alamat_siswa' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'nomor_wa_siswa' => 'required|digits_between:12,13',
            'username' => 'required|string|min:8|max:50|unique:siswa,username',
            'email' => 'required|email|max:255|unique:siswa,email',
            'role_siswa' => 'required|in:siswa,pengurus',
            'foto_siswa' => 'required|image|max:25000', 
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
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'nama_siswa.required' => 'Nama siswa wajib diisi.',
            'nama_siswa.max' => 'Nama siswa maksimal 125 karakter.',
            'tgl_lahir_siswa.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin_siswa.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin_siswa.in' => 'Jenis kelamin tidak valid.',
            'alamat_siswa.required' => 'Alamat siswa wajib diisi.',
            'alamat_siswa.max' => 'Alamat siswa maksimal 255 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'nomor_wa_siswa.required' => 'Nomor WhatsApp wajib diisi.',
            'nomor_wa_siswa.digits_between' => 'Nomor WhatsApp harus antara 12 hingga 13 digit.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.min' => 'Username minimal 8 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.max' => 'Email maksimal 255 karakter.',
            'role_siswa.required' => 'Role siswa wajib dipilih.',
            'role_siswa.in' => 'Role siswa tidak valid.',
            'foto_siswa.required' => 'Foto siswa wajib diunggah.',
            'foto_siswa.image' => 'Foto siswa harus berupa gambar.',
            'foto_siswa.max' => 'Ukuran foto siswa maksimal 25 MB.',
        ];
    }
}
