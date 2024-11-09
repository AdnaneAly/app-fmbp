<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvanceSalaireRequest extends FormRequest
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
            'employeur_id' => ['required', 'integer','exists:employeurs,id'],
            'created_by' => ['required', 'integer','exists:users,id'],
            'montantAvanceSalaire' => ['required', 'numeric','min:0','max:500000'],
            'date' => ['required', 'date'],
            'description'=> ['nullable'],
            'annee'=> ['string'],
            'etat'=> ['nullable'],
        ];
    }

    public function messages(){
        return [
            'employeur_id' => 'L\'employeur est obligatoire',
            'montantAvanceSalaire' => 'La montant Avance Salaire est obligatoire',
            'montantAvanceSalaire.min' => 'La montant Avance Salaire est doit etre >= 0',
            'montantAvanceSalaire.max' => 'La montant Avance Salaire est doit etre < 500000',
            'date' => 'La date est obligatoire',
            'etat' => 'L\'etat est obligatoire',
            'annee' => 'L\'annee est obligatoire'
        ];
    }
}
