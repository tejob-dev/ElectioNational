<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LieuVoteUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'libel' => ['required', 'max:255', 'string'],
            'code' => [
                'required',
                // Rule::unique('lieu_votes', 'code')->ignore($this->lieuVote),
                'max:255',
                'string',
            ],
            'nbrinscrit' => ['required', 'numeric'],
            'objectif' => ['required', 'numeric'],
            'seuil' => ['required', 'numeric'],
            'a_vote' => ['required', 'numeric'],
            'imported' => ['required', 'numeric'],
            'commune_id' => ['required', 'exists:communes,id'],
        ];
    }
}
