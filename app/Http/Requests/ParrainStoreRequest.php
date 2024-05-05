<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParrainStoreRequest extends FormRequest
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
            'nom_pren_par' => ['required', 'max:255', 'string'],
            'telephone_par' => ['required', 'max:255', 'string'],
            'recenser' => ['max:255', 'string'],
            'nom' => ['required', 'max:255', 'string'],
            'prenom' => ['required', 'max:255', 'string'],
            
            'list_elect' => ['required', 'max:255', 'string'],
            'cart_elect' => ['required', 'max:255', 'string'],
            'telephone' => ['required', 'max:255', 'string'],
            'date_naiss' => ['required', 'date'],
            'code_lv' => ['required', 'max:255', 'string'],
            'residence' => ['required', 'max:255', 'string'],
            'profession' => ['required', 'max:255', 'string'],
            'observation' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
        ];
    }
}
