<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BahanAjarStoreRequest extends FormRequest
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
            'nama_bahan_ajar' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'video_title' => 'nullable|string|max:255',
            'video_url' => 'nullable|url',
            'video_duration' => 'nullable|integer|min:0',
            'focus_skill' => 'nullable|string|max:255',
            'key_points' => 'nullable|string',
            'objective' => 'nullable|string',
            'sensei_note' => 'nullable|string',
            'bahan_ajar_description' => 'nullable|string',
            'nama_dokumen_ajar' => 'nullable|string|max:255',
            'path_file_dokumen_ajar' => 'nullable|string|max:255',
            'ukuran_file_dokumen_ajar' => 'nullable|integer|min:0'
        ];
    }
}
