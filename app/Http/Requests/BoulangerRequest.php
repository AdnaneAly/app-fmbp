<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoulangerRequest extends FormRequest
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
        $id = $this->boulanger->id ?? "";
        return [
            'name'  => "required|string|unique:boulangers,name,{$id}",
            'address' => ['required','string', 'min:4'],
            'proprietaire_id' => ['required', 'integer', 'exists:proprietaires,id'],
            'created_by' => ['required', 'integer', 'exists:users,id'],
            'etat' => ['required'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(){
        return [
            'name' => 'اسم المخبزة إلزامي',
            'name.unique' => 'إسم المخبزة موجود مسبقا',
            'address' => 'يجب تحديد مكان المخبزة',
            'proprietaire_id' => 'يجب تحديد المالك',
            'etat' => 'يجب تحديد وضعية المخبزة'
        ];
    }
}
