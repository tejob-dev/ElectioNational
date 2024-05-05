<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AgentTerrainUpdateRequest extends FormRequest
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
            'telephone' => [
                'required',
                /* Rule::unique('agent_terrains', 'telephone')->ignore(
                     $this->agentTerrain
                 ), */
                'max:255',
                'string',
            ],
            'section_id' => ['exists:sections,id'],
            'sous_section_id' => ['exists:sous_sections,id'],
        ];
    }
}
