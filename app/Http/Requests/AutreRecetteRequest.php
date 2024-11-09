<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutreRecetteRequest extends FormRequest
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
            'type_recette_id' => ['required', 'integer','exists:type_recettes,id'],
            'created_by' => ['required', 'integer','exists:users,id'],
            'montant' => ['required', 'numeric','min:0','max:1000000'],
            'quantite' => ['nullable', 'numeric','min:0','max:100000'],
            'rapport' => ['nullable', 'numeric','min:0','max:100'],
            'date' => ['required', 'date'],
            'description'=> ['nullable', 'string'],
            'annee'=> ['string'],
        ];
    }


    public function messages(){
        return [
            'type_recette_id' => 'Le type de recette est obligatoire',
            'montant' => 'La montant est obligatoire',
            'montant.min' => 'La montant est doit etre >= 0',
            'montant.max' => 'La montant est doit etre < 1000000',
            'quantite' => 'La quantite est obligatoire',
            'quantite.min' => 'La quantite est doit etre >= 0',
            'quantite.max' => 'La quantite est doit etre < 100000',
            'date' => 'La date est obligatoire',
            'annee' => 'L\'annee est obligatoire'
        ];
    }
}
