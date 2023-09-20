<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class FormValidator
{


    public static function rules(): array
    {
        return [
            'form' => 'required|unique:preoperationals,name',
            'categories.*.name' => "required",
            'categories.*.elements.*' => "required"
        ];
    }
    public static function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio',
            'unique' => "Este campo debe ser unico"
        ];
    }
}
