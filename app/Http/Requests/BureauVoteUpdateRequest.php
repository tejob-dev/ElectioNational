<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BureauVoteUpdateRequest extends FormRequest
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
            'libel' => [ 'max:255', 'string'],
            'objectif' => ['numeric'],
            'seuil' => ['numeric'],
            'lieu_vote_id' => ['exists:lieu_votes,id'],
        ];
    }
}
