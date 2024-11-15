<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObservationRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'boulanger_id'  => ['required', 'integer', 'exists:boulangers,id'],
            'employeur_id'  => ['required', 'integer', 'exists:employeurs,id'],
            'created_by'    => ['required', 'integer', 'exists:users,id'],
            'date'          => ['required', 'date'],
            'message'       => ['required', 'string'],
            'annee'       => ['required', 'string'],
        ];
    }
}
