<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProprietaireRequest extends FormRequest
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
        $id = $this->proprietaire->id ?? "";
        return [
            'name'  => "required|string|unique:proprietaires,name,{$id}",
            'tel' => ['required', 'string'],
            'address' => ['required', 'string'],
            'description'=> ['nullable', 'string'],
        ];
    }


    public function messages(){
        return [
            'name' => 'Le nom du proprietaire est obligatoire',
            'name.unique' => 'Le nom de la proprietaire doit etre unique',
            'address' => 'L\'adresse est obligatoire',
        ];
    }
}
