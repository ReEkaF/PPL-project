<?php

namespace App\Http\Requests\Ekstrakurikuler;

use Illuminate\Foundation\Http\FormRequest;

class StorePerlengkapanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_ekstrakurikuler' => ['required', 'string'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
        ];
    }
}
