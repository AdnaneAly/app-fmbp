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
            'annee'=> ['required'],
        ];
    }


    public function messages(){
        return [
            'employeur_id' => 'يجب تحديد العامل',
            'nombreJoursTravail' => 'يجب تحديد عدد ايام العمل',
            'nombreJoursTravail.min' => 'عدد ايام العمل يجب ان يكون >= 0',
            'nombreJoursTravail.max' => 'عدد ايام العمل يجب ان يكون <= 31',
            'montantNet' => 'La montant Net est obligatoire',
            'montantNet.min' => 'La montant Net est doit etre >= 0',
            'montantNet.max' => 'La montant Net est doit etre < 500000',
            'date' => 'يجب تحديد التاريخ',
            'annee' => 'L\'annee est obligatoire'
        ];
    }
}
