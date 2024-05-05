<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcesVerbalStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'libel' => ['nullable', 'max:255', 'string'],
            'photo' => ['required', 'file'],
            'bureau_vote_id' => ['required', 'exists:bureau_votes,id'],
        ];
    }
}
