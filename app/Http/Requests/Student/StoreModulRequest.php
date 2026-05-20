<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreModulRequest extends FormRequest
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
            'nama_modul' => 'required|string|max:50',
            'kode_modul' => 'required|string|unique:modul,kode_modul',
            'teori' => 'required|integer',
            'praktik' => 'required|integer',
            'module_description' => 'nullable|max:100',
            'id_mapel' => 'required|exists:mapel,id_mapel',
            'id_rps' => 'required|exists:rps,id_rps'
        ];
    }

    public function messages(): array 
    {
        return [
            'nama_modul.required' => 'Nama Modul harus diisi',
            'kode_modul.unique' => 'Kode modul harus unik!',
            'teori.required' => 'Jumlah teori harus diisi!',
            'praktik.required' => 'Jumlah praktik harus diisi!'
        ];
    }
}
