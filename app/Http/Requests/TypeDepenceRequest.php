<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeDepenceRequest extends FormRequest
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
        $id = $this->typedepence->id ?? "";
        return [
            'name'  => "required|string|unique:type_depences,name,{$id}",
        ];
    }

    public function messages(){
        return [
            'name' => 'Le nom de la type de depence est obligatoire',
            'name.unique' => 'Le nom de la type de depence doit etre unique',
        ];
    }
}
