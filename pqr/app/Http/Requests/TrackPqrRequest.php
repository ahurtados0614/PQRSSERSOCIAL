<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackPqrRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'radicado' => ['required', 'string', 'max:30'],
        ];
    }

    public function messages(): array
    {
        return [
            'radicado.required' => 'El número de radicado es obligatorio.',
            'radicado.string'   => 'El número de radicado debe ser una cadena válida.',
        ];
    }
}