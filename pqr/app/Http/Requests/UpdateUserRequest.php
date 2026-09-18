<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtenemos la instancia del modelo User a través del Route Model Binding
        $user = $this->route('user');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],

            'id_rol' => [
                'required',
                'exists:roles,id',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => 'nombre',
            'email'    => 'correo electrónico',
            'id_rol'   => 'rol',
            'password' => 'contraseña',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'El nombre es obligatorio.',
            'email.required'  => 'El correo electrónico es obligatorio.',
            'email.unique'    => 'Este correo electrónico ya está registrado.',
            'id_rol.required' => 'Debe seleccionar un rol válido.',
            'id_rol.exists'   => 'El rol seleccionado no existe.',
            'password.min'    => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }
}