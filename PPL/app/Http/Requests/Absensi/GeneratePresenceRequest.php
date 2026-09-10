<?php

namespace App\Http\Requests\Absensi;

use Illuminate\Foundation\Http\FormRequest;

class GeneratePresenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_week_date' => 'required|date|after_or_equal:'.date('Y-01-01').'|before_or_equal:'.date('Y-12-31'),
            'total_meetings' => 'required|integer|min:1|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'first_week_date.required' => 'Tanggal pertemuan harus diisi.',
            'first_week_date.after_or_equal' => 'Tanggal pertemuan harus di tahun sekarang.',
            'first_week_date.before_or_equal' => 'Tanggal pertemuan harus di tahun sekarang.',
            'total_meetings.required' => 'Total pertemuan harus diisi.',
            'total_meetings.min' => 'Total pertemuan tidak boleh kurang dari 1.',
            'total_meetings.max' => 'Total pertemuan tidak boleh lebih dari 20.',
        ];
    }
}
