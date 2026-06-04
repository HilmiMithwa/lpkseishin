<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            'name'=>'required|string|max:50',
            'email'=>'required|email|unique:users,email,'.auth()->id(),
            'nomor_telepon'=>'nullable|numeric|digits_between:10,15',
            'tanggal_lahir'=>'nullable|date',
        ];
    }

    public function messages(): array
    {
        return 
        [
            'nomor_telepon.numeric' => 'Nomor telepon tidak valid!',
            'nomor_telepon.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit!'
        ];
    }
} 
