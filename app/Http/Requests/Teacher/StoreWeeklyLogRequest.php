<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWeeklyLogRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_user' => 'required|exists:users,id',
            'id_mapel' => 'required|exists:mapel,id_mapel',
            'minggu_ke' => 'required|integer',
            'score_word' => 'required|integer|min:0|max:100',
            'score_kotoba' => 'required|integer|min:0|max:100',
            'score_bunpou' => 'required|integer|min:0|max:100',
            'score_kanji' => 'required|integer|min:0|max:100',
            'score_choukai' => 'required|integer|min:0|max:100',
            'score_kaiwa' => 'required|integer|min:0|max:100',
        ];
    }
}
