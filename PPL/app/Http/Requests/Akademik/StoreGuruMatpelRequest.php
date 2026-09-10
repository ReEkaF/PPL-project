<?php

namespace App\Http\Requests\Akademik;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruMatpelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guru_id' => ['required', 'string', 'exists:guru,id_guru'],
            'matpel_id' => ['required', 'string', 'exists:mata_pelajaran,id_matpel'],
        ];
    }

    public function messages(): array
    {
        return [
            'guru_id.required' => 'Guru wajib dipilih.',
            'guru_id.exists' => 'Guru yang dipilih tidak valid.',
            'matpel_id.required' => 'Mata pelajaran wajib dipilih.',
            'matpel_id.exists' => 'Mata pelajaran yang dipilih tidak valid.',
        ];
    }
}
