<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegionUpdateRequest extends FormRequest
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
            'nbrinscrit' => ['required', 'numeric'],
            'objectif' => ['required', 'numeric'],
            'seuil' => ['required', 'numeric'],
            'district_id' => ['required', 'exists:districts,id'],
        ];
    }
}
