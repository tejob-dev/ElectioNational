<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LieuVoteUpdateRequest extends FormRequest
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
            'code' => [
                'required',
                // Rule::unique('lieu_votes', 'code')->ignore($this->lieuVote),
                'max:255',
                'string',
            ],
            'libel' => ['required', 'max:255', 'string'],
            'nbrinscrit' => ['required', 'numeric'],
            'objectif' => ['required', 'numeric'],
            'seuil' => ['required', 'numeric'],
            'quartier_id' => ['exists:quartiers,id'],
        ];
    }
}
