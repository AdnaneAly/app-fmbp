<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeurRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'grade_id' => ['required', 'integer','exists:grades,id'],
            'montantSalaire' => ['required', 'numeric', 'min:0', 'max:500000'],
            'nni' => ['nullable', 'string'],
            'tel' => ['required', 'string'],
            'date' => ['required', 'date'],
            'etat' => ['required'],
            'description'=> ['nullable', 'string'],
        ];
    }


    public function messages(){
        return [
            'name' => 'يجب كتابة اسم العامل',
            'grade_id' => 'يجب تحديد رتبة العامل',
            'montantSalaire' => 'يجب كتابة راتب العامل',
            'montantSalaire.min' => 'الراتب يجب ان يكون >= 0',
            'montantSalaire.max' => 'الراتب يجب ان يكون < 500000',
            'tel' => 'يجب تحديد الهاتف',
            'date' => 'يجب تحديد التاريخ',
            'etat' => 'يجب تحديد وضعية العامل'
        ];
    }
}
