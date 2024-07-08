<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElectorParrainUpdateRequest extends FormRequest
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
            'nom_prenoms' => ['required', 'max:255', 'string'],
            'phone' => ['required', 'max:255', 'string'],
            'carte_elect' => ['nullable', 'max:255', 'string'],
            'nom_lv' => ['required', 'max:255', 'string'],
            'agent_res_nompren' => ['nullable', 'max:255', 'string'],
            'agent_res_phone' => ['nullable', 'max:255', 'string'],
            'elect_date' => ['nullable', 'string'],
            'commune_id' => ['nullable', 'string'],
            'recenser' => ['nullable', 'string'],
        ];
    }
}
