<?php

namespace App\Http\Requests\Lms;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopikRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic' => ['required', 'string', 'max:100'],
            'kelas_mata_pelajaran_id' => ['nullable', 'string'],
            'mata_pelajaran_id' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'topic.required' => 'Nama topik harus diisi.',
            'topic.max' => 'Nama topik maksimal 100 karakter.',
        ];
    }
}
