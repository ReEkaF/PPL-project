<?php

namespace App\Http\Requests\Lms;

use Illuminate\Foundation\Http\FormRequest;

class GradeTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'komentar' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nilai.required' => 'Nilai tugas harus diisi.',
            'nilai.numeric' => 'Nilai harus berupa angka numerik.',
            'nilai.min' => 'Nilai minimal adalah 0.',
            'nilai.max' => 'Nilai maksimal adalah 100.',
        ];
    }
}
