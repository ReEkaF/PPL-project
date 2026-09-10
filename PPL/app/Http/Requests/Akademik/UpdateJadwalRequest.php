<?php

namespace App\Http\Requests\Akademik;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelas_id' => ['required', 'string', 'exists:kelas,id_kelas'],
            'hari_id' => ['required', 'string', 'exists:hari,id_hari'],
            'jam_pelajaran' => ['required', 'string'],
            'guruid_matpelid' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'kelas_id.required' => 'Kelas harus dipilih.',
            'hari_id.required' => 'Hari harus dipilih.',
            'jam_pelajaran.required' => 'Jam pelajaran harus dipilih.',
            'guruid_matpelid.required' => 'Guru dan mata pelajaran harus dipilih.',
        ];
    }
}
