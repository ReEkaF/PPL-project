<?php

namespace App\Http\Requests\Ujian;

use Illuminate\Foundation\Http\FormRequest;

class StoreUjianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'jenis_ujian' => ['required', 'string'],
            'topik_id' => ['required', 'string'],
            'kelas_mata_pelajaran_id' => ['required', 'string'],
            'tanggal_dibuat' => ['required', 'date'],
        ];
    }
}
