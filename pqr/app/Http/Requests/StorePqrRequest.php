<?php

namespace App\Http\Requests;

use App\Constants\PqrsPriority;
use App\Constants\PqrsType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePqrRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => [
                'required',
                Rule::in(PqrsType::all()),
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'subject' => [
                'required',
                'string',
                'max:200',
            ],

            'description' => [
                'required',
                'string',
            ],

            'priority' => [
                'required',
                Rule::in(PqrsPriority::all()),
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'lastname' => [
                'required',
                'string',
                'max:100',
            ],

            'identification' => [
                'required',
                'string',
                'max:30',
                Rule::unique('solicitantes', 'identificacion'),
            ],

            'email' => [
                'required',
                'email',
                'max:150',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'tipo',
            'category' => 'categoría',
            'subject' => 'título',
            'description' => 'descripción',
            'priority' => 'prioridad',
            'name' => 'nombre',
            'lastname' => 'apellido',
            'identification' => 'identificación',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
        ];
    }

    public function messages(): array
    {
        return [
            'identification.unique' =>
                'La identificación ingresada ya se encuentra registrada.',
        ];
    }
}