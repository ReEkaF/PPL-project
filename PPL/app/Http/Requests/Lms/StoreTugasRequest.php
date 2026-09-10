<?php

namespace App\Http\Requests\Lms;

use Illuminate\Foundation\Http\FormRequest;

class StoreTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul_tugas' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'topik_id' => ['nullable', 'string'],
            'tenggat' => ['required', 'date'],
            'kelas_mata_pelajaran_id' => ['required', 'string', 'exists:kelas_mata_pelajaran,id_kelas_mata_pelajaran'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,xlsx', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul_tugas.required' => 'Judul Tugas harus diisi.',
            'judul_tugas.max' => 'Judul Tugas maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi Tugas harus diisi.',
            'tenggat.required' => 'Tenggat waktu pengumpulan harus ditentukan.',
            'kelas_mata_pelajaran_id.required' => 'Mata pelajaran kelas harus dipilih.',
            'files.*.file' => 'File harus berupa dokumen.',
            'files.*.mimes' => 'File harus berupa PDF, DOC, DOCX, PPT, PPTX, atau XLSX.',
            'files.*.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
        ];
    }
}
