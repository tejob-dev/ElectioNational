<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AgentTerrainUpdateRequest extends FormRequest
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
            'nom' => ['required', 'max:255', 'string'],
            'prenom' => ['required', 'max:255', 'string'],
            'code' => ['nullable', 'max:255', 'string'],
            'telephone' => [
                'required',
                // Rule::unique('agent_terrains', 'telephone')->ignore(
                //     $this->agentTerrain
                // ),
                'max:255',
                'string',
            ],
            'profil' => ['required', 'max:255', 'string'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'departement_id' => ['nullable', 'exists:departements,id'],
            'commune_id' => ['required', 'exists:communes,id'],
        ];
    }
}
