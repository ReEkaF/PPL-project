<?php

namespace App\Http\Requests\Ekstrakurikuler;

use Illuminate\Foundation\Http\FormRequest;

class StorePostinganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'gambar' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'deskripsi' => ['required', 'string'],
        ];
    }
}
