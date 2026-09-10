<?php

namespace App\Http\Requests\Ekstrakurikuler;

use Illuminate\Foundation\Http\FormRequest;

class RegisterEkstraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_hp' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string'],
            'riwayat_penyakit' => ['nullable', 'string'],
            'no_hp_orangtua' => ['nullable', 'string', 'max:15'],
            'alasan_ekskul' => ['nullable', 'string'],
            'pilih_ekskul' => ['required', 'array', 'min:1', 'max:3'],
            'surat_izin_orang_tua' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25000'],
            'surat_keterangan_dokter' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25000'],
        ];
    }

    public function messages(): array
    {
        return [
            'pilih_ekskul.required' => 'Pilih minimal satu ekstrakurikuler.',
            'pilih_ekskul.max' => 'Maksimal memilih 3 ekstrakurikuler.',
        ];
    }
}
