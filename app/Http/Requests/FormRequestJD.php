<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRequestJD extends FormRequest
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
            'form' => 'required|unique:preoperationals,name',
            'categories.*.name' => "required",
            'categories.*.elements.*.name' => "required"
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio',
            'unique' => "Este campo debe ser unico"
        ];
    }
}
