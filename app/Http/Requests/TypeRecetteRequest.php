<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRecetteRequest extends FormRequest
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
        $id = $this->typerecette->id ?? "";
        return [
            'name'  => "required|string|unique:type_recettes,name,{$id}",
        ];
    }

    public function messages(){
        return [
            'name' => 'Le nom de la type de recette est obligatoire',
            'name.unique' => 'Le nom de la type de recette doit etre unique',
        ];
    }
}
