<?php

namespace App\Http\Requests\Akademik;

use Illuminate\Foundation\Http\FormRequest;

class StoreJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelas_id' => ['required', 'string', 'exists:kelas,id_kelas'],
            'tahun_ajaran_id' => ['required', 'string', 'exists:tahun_ajaran,id_tahun_ajaran'],
            'jadwal' => ['required', 'array', 'min:1'],
            'jadwal.*.guru_id' => ['required', 'string'],
            'jadwal.*.hari_id' => ['required', 'string', 'exists:hari,id_hari'],
            'jadwal.*.jam_pelajaran' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'kelas_id.required' => 'Kelas harus dipilih.',
            'tahun_ajaran_id.required' => 'Tahun ajaran harus dipilih.',
            'jadwal.required' => 'Daftar jadwal tidak boleh kosong.',
        ];
    }
}
