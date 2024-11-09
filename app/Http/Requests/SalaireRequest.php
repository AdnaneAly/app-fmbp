<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaireRequest extends FormRequest
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
            'employeur_id' => ['required','integer','exists:employeurs,id'],
            'created_by' => ['required', 'integer','exists:users,id'],
            'nombreJoursTravail' => ['required', 'numeric','min:0', 'max:31'],
            'montantJoursTravail' => ['required', 'numeric','min:0', 'max:500000'],
            'montantNet' => ['required', 'numeric','min:0', 'max:500000'],
            'montantAS' => ['required', 'numeric','min:0', 'max:500000'],
            'date' => ['required', 'date'],
            'description'=> ['nullable', 'string'],
            'annee'=> ['required','string'],
        ];
    }


    public function messages(){
        return [
            'employeur_id' => 'L\'employeur est obligatoire',
            'nombreJoursTravail' => 'Les nombres Jours Travail est obligatoire',
            'nombreJoursTravail.min' => 'Les nombres Jours Travail est doit etre >= 0',
            'nombreJoursTravail.max' => 'Les nombres Jours Travail est doit etre < 31',
            'montantJoursTravail' => 'La montant Jours Travail est obligatoire',
            'montantJoursTravail.min' => 'La montant Jours Travail est doit etre >= 0',
            'montantJoursTravail.max' => 'La montant Jours Travail est doit etre < 500000',
            'montantNet' => 'La montant Net est obligatoire',
            'montantNet.min' => 'La montant Net est doit etre >= 0',
            'montantNet.max' => 'La montant Net est doit etre < 500000',
            'date' => 'La date est obligatoire',
            'annee' => 'L\'annee est obligatoire'
        ];
    }
}
