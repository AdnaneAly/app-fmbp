<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
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
        $id = $this->grade->id ?? "";
        return [
            'name'  => "required|string|unique:grades,name,{$id}",
        ];
    }


    public function messages(){
        return [
            'name' => 'Le Nom du grade est obligatoire',
            'quantite.unique' => 'Le nom doit etre unique',
        ];
    }
}
