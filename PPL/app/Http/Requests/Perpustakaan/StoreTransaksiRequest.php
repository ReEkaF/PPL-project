<?php

namespace App\Http\Requests\Perpustakaan;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis_peminjam' => 'required|in:siswa,guru',
            'id_buku' => 'required|uuid|exists:buku,id_buku',
            'nisn_nip' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_peminjam.required' => 'Jenis peminjam harus dipilih (siswa atau guru).',
            'id_buku.required' => 'Buku yang dipinjam harus dipilih.',
            'nisn_nip.required' => 'Nomor identitas (NISN atau NIP) wajib diisi.',
        ];
    }
}
