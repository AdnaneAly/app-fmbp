<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecetteRequest extends FormRequest
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
        $id = $this->recette->id ?? "";
        return [
            'boulanger_id'      => ['required', 'integer', 'exists:boulangers,id'],
            'type_recette'      => ['required'],
            'created_by'        => ['required', 'integer', 'exists:users,id'],
            'montant'           => ['required', 'numeric', 'min:0', 'max:55000'],
            'numeroFacture'     => ['nullable'],
            'date'              => ['required', 'date'],
            'month'             => ['required'],
            'description'       => ['nullable', 'string'],
            'annee'             => ['string'],
        ];
    }


    public function messages(){
        return [
            'boulanger_id' => 'La boulangerie est obligatoire',
            'date' => 'La date est obligatoire',
            'annee' => 'L\'annee est obligatoire'
        ];
    }
}
