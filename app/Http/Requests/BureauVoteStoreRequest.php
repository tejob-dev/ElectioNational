<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BureauVoteStoreRequest extends FormRequest
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
            'libel' => ['required', 'max:255', 'string'],
            'objectif' => ['required', 'numeric'],
            'seuil' => ['required', 'numeric'],
            'lieu_vote_id' => ['required', 'exists:lieu_votes,id'],
        ];
    }
}
