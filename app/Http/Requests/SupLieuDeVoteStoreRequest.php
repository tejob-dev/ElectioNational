<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupLieuDeVoteStoreRequest extends FormRequest
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
            'nom' => ['required', 'max:255', 'string'],
            'prenom' => ['required', 'max:255', 'string'],
            'telephone' => ['required', 'max:255', 'string'],
            'lieu_vote_id' => ['required', 'exists:lieu_votes,id'],
        ];
    }
}
