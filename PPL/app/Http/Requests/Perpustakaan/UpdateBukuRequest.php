<?php

namespace App\Http\Requests\Perpustakaan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('id');

        return [
            'foto_buku' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'judul_buku' => 'required|string|max:255|unique:buku,judul_buku,'.$bookId.',id_buku',
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
}
