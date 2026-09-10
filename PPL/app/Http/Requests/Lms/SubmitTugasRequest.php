<?php

namespace App\Http\Requests\Lms;

use Illuminate\Foundation\Http\FormRequest;

class SubmitTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'files' => ['required', 'array', 'min:1'],
            'files.*' => ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx,zip,rar', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'files.required' => 'Pilih minimal satu berkas tugas untuk dikumpulkan.',
            'files.*.required' => 'Berkas pengumpulan tidak boleh kosong.',
            'files.*.file' => 'Berkas harus berupa file yang valid.',
            'files.*.mimes' => 'Format file yang didukung: pdf, doc, docx, ppt, pptx, zip, rar.',
            'files.*.max' => 'Ukuran maksimal berkas adalah 10MB.',
        ];
    }
}
