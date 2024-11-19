<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepenceRequest extends FormRequest
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
            'type_depence_id' => ['required', 'exists:type_depences,id'],
            'employeur_id' => ['nullable', 'exists:employeurs,id'],
            'created_by' => ['required', 'integer','exists:users,id'],
            'montant' => ['numeric', 'min:0', 'max:500000'],
            'date' => ['required', 'date'],
            'annee'=> ['required'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(){
        return [
            'type_depence_id' => 'Le type de depence est obligatoire',
            'montant' => 'La montant est obligatoire',
            'montant.min' => 'La montant est doit etre >= 0',
            'montant.max' => 'La montant est doit etre < 500000',
            'date' => 'La date est obligatoire',
            'annee' => 'L\'annee est obligatoire'
        ];
    }
}
