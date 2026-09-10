<?php

namespace App\Http\Requests\Perpustakaan;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'foto_buku' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'judul_buku' => 'required|string|max:255|unique:buku,judul_buku',
            'author_buku' => 'required|string|max:255',
            'rak_buku' => 'required|integer|min:0',
            'id_kategori_buku' => 'required|exists:kategori_buku,id_kategori_buku',
            'id_jenis_buku' => 'required|exists:jenis_buku,id_jenis_buku',
            'stok_buku' => 'required|integer|min:0',
            'tahun_terbit' => 'required|string|max:4',
            'bahasa_buku' => 'required|string|max:255',
            'publisher_buku' => 'required|string|max:255',
            'harga_buku' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'foto_buku.required' => 'Foto sampul buku wajib diunggah.',
            'foto_buku.image' => 'File harus berupa gambar.',
            'foto_buku.max' => 'Ukuran gambar maksimal 2MB.',
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'judul_buku.unique' => 'Judul buku sudah terdaftar di sistem.',
            'author_buku.required' => 'Nama penulis wajib diisi.',
            'id_kategori_buku.required' => 'Kategori buku wajib dipilih.',
            'id_jenis_buku.required' => 'Jenis buku wajib dipilih.',
        ];
    }
}
