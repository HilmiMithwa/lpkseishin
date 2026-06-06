<?php

namespace App\Http\Requests\Teacher;

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
            'nama_modul' => 'required|string|max:255',
            'kode_modul' => 'nullable|string|unique:modul,kode_modul',
            'teori' => 'nullable|integer|min:0',
            'praktik' => 'nullable|integer|min:0',
            'jp' => 'nullable|integer|min:0', // Alokasi Durasi (JP)
            'module_description' => 'nullable|string',
            'id_mapel' => 'required|exists:mapel,id_mapel',
            'id_rps' => 'nullable|exists:rps,id_rps'
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
