<?php

namespace App\Http\Requests\Akademik;

use Illuminate\Foundation\Http\FormRequest;

class StoreMataPelajaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_matpel' => ['required', 'string', 'max:255'],
            'deskripsi_matpel' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_matpel.required' => 'Nama mata pelajaran wajib diisi.',
            'nama_matpel.max' => 'Nama mata pelajaran maksimal 255 karakter.',
        ];
    }
}
