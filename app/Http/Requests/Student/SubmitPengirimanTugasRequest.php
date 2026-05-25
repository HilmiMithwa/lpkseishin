<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubmitPengirimanTugasRequest extends FormRequest
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
            'text_content' => 'nullable|string',
            'file_path' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (request()->hasFile('file_path')) {
                        $allowedExtensions = ['pdf', 'docx', 'xlsx', 'xls', 'pptx', 'txt'];
                        $file = request()->file('file_path');
                        $extension = strtolower($file->getClientOriginalExtension());

                        if (!in_array($extension, $allowedExtensions)) {
                            $fail('File harus berupa PDF, DOCX, XLSX, XLS, PPTX, atau TXT.');
                        }

                        if ($file->getSize() > 20480 * 1024) {
                            $fail('Ukuran file tidak boleh lebih dari 20MB.');
                        }
                    } else if (is_string($value)) {
                        if (!filter_var($value, FILTER_VALIDATE_URL)) {
                            $fail('File path harus berupa URL yang valid.');
                        }
                    }
                }
            ],
            
            'status' => 'required|in:submitted,graded',
            'nilai' => 'nullable|numeric|min:0|max:100',
            'id_tugas' => 'required|exists:tugas,id_tugas',
        ];
    }

    
}