<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class FormValidator
{


    public static function rules(): array
    {
        $array = [
            [
                "name" => "",
                "cantidad" => "",
                "elementos" => [
                    [
                        'name' =>  "",
                        'type' => 1
                    ], [
                        'name' =>  "",
                        'type' => 1
                    ]
                ],

            ],
            [
                "name" => "",
                "cantidad" => "",
                "elementos" => [
                    [
                        'name' =>  "",
                        'type' => 1
                    ],
                    [
                        'name' =>  "",
                        'type' => 1
                    ]
                ],

            ]
        ];
        return [
            'form' => 'required|unique:preoperationals,name',
            'categories.*.name' => "required",
            'categories.*.elements.*.name' => "required"
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
