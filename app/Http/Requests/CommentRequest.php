<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'observation_id'    => ['required', 'integer', 'exists:observations,id'],
            'employeur_id'      => ['required', 'integer', 'exists:employeurs,id'],
            'date'              => ['required', 'date'],
            'message'           => ['required', 'string'],
            'image'             => ['nullable', 'image', 'max:3000'],
            'annee'             => ['required'],
        ];
    }


    public function messages(){
        return [
            'employeur_id' => 'يجب تحديد المراقب',
            'date' => 'يجب تحديد التاريخ',
            'message' => 'يجب كتابة الملاحظة',
            'image.max' => 'حجم الصورة كبير جدا',
        ];
    }
}
