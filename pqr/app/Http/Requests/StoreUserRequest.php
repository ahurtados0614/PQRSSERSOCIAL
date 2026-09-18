<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para la creación de usuarios.
     */
    public function rules(): array
    {
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
                'unique:users,email',
            ],
            'id_rol' => [
                'required',
                'exists:roles,id',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ];
    }

    /**
     * Nombres personalizados para las propiedades en los errores.
     */
    public function attributes(): array
    {
        return [
            'name'     => 'nombre',
            'email'    => 'correo electrónico',
            'id_rol'   => 'rol',
            'password' => 'contraseña',
        ];
    }

    /**
     * Mensajes de validación personalizados.
     */
    public function messages(): array
    {
        return [
            'name.required'     => 'El nombre es obligatorio.',
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.unique'      => 'Este correo electrónico ya está registrado.',
            'id_rol.required'   => 'Debe seleccionar un rol válido.',
            'id_rol.exists'     => 'El rol seleccionado no existe.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }
}