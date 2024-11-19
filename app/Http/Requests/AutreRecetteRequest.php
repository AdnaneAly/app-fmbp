<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutreRecetteRequest extends FormRequest
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
        $id = $this->autrerecette->id ?? "";
        return [
            'type_recette_id' => ['required', 'integer','exists:type_recettes,id'],
            'created_by' => ['required', 'integer','exists:users,id'],
            'montant' => ['required', 'numeric','min:0','max:1000000'],
            'numeroFacture'     => ['nullable', 'numeric', "unique:autre_recettes,numeroFacture,{$id}","unique:recettes,numeroFacture,{$id}"],
            'date' => ['required', 'date'],
            'description'=> ['nullable', 'string'],
            'annee'=> ['required'],
        ];
    }


    public function messages(){
        return [
            'type_recette_id' => 'يجب تحديد نوع الدخل',
            'montant' => 'يجب تحديد المبلغ',
            'montant.min' => 'المبلغ يجب ان يكون اكبر من 0',
            'montant.max' => 'المبلغ يجب ان يكون اقل من 10000000',
            'numeroFacture.unique' => 'رقم الوصل موجود ',
            'date' => 'يجب تحديد التاريخ',
            'annee' => 'L\'annee est obligatoire'
        ];
    }
}
