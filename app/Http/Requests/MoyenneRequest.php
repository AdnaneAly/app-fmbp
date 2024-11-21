<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoyenneRequest extends FormRequest
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
            'created_by' => ['required', 'integer','exists:users,id'],
            'type' => ['required','string', 'max:50'],
            'niveau' => ['required','string', 'max:50'],
            'reference' => ['required','string', 'max:50'],
            'numeroFacture' => ['nullable','numeric'],
            'montant' => ['numeric', 'min:0', 'max:500000'],
            'date' => ['required', 'date'],
            'annee'=> ['required'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(){
        return [
            'type' => 'Le type de depence est obligatoire',
            'niveau' => 'Le niveau de depence est obligatoire',
            'reference' => 'Le reference de depence est obligatoire',
            'montant' => 'La montant est obligatoire',
            'montant.min' => 'La montant est doit etre >= 0',
            'montant.max' => 'La montant est doit etre < 500000',
            'date' => 'La date est obligatoire',
            'annee' => 'L\'annee est obligatoire'
        ];
    }
}
