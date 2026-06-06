<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul_tugas' => 'required|string|max:255',
            'waktu_pengumpulan' => 'required|date',
            'id_modul' => 'required|exists:modul,id_modul',
            'deskripsi_tugas' => 'nullable|string',
            'file_path_tugas' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // Maks 5MB sesuai form
        ];
    }

    public function messages(): array {
        return [
            'judul_tugas.required' => 'Judul Tugas harus diisi!',
            'waktu_pengumpulan.required' => 'Tenggat Waktu harus diisi!',
            'id_modul.required' => 'Modul harus dipilih!',
            'file_path_tugas.mimes' => 'File Tugas harus berupa PDF, DOC, DOCX, JPG, atau PNG!',
            'file_path_tugas.max' => 'File Tugas maksimal 5MB!'
        ];
    }
}
