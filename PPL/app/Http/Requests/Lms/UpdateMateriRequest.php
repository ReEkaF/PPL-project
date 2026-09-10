<?php

namespace App\Http\Requests\Lms;

use App\Models\file_materi;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMateriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'judul_materi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'topik_id' => ['nullable', 'string'],
            'id_kelas_mata_pelajaran' => ['required', 'string'],
            'file_materi.*' => ['file', 'mimes:pdf,doc,docx,ppt,pptx,xlsx', 'max:10240'],
        ];

        $existingCount = file_materi::where('materi_id', $this->route('id'))->count();
        $removedCount = $this->has('removed_files') ? count($this->removed_files) : 0;
        if ($removedCount >= $existingCount) {
            $rules['file_materi'] = ['required', 'array'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'judul_materi.required' => 'Judul Materi harus diisi.',
            'judul_materi.max' => 'Judul Materi maksimal 255 karakter.',
            'file_materi.required' => 'File Materi harus diisi jika semua file lama dihapus.',
            'file_materi.*.file' => 'File harus berupa file dengan ekstensi: pdf, doc, docx, ppt, pptx, xlsx.',
            'file_materi.*.mimes' => 'File harus berupa file dengan ekstensi: pdf, doc, docx, ppt, pptx, xlsx.',
            'file_materi.*.max' => 'Ukuran file maksimal 10MB.',
        ];
    }
}
