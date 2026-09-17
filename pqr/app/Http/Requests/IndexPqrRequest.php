<?php

namespace App\Http\Requests;

use App\Constants\PqrsPriority;
use App\Constants\PqrsStatus;
use App\Constants\PqrsType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexPqrRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => [
                'nullable',
                Rule::in(PqrsType::all()),
            ],

            'status' => [
                'nullable',
                Rule::in(PqrsStatus::all()),
            ],

            'priority' => [
                'nullable',
                Rule::in(PqrsPriority::all()),
            ],

            'category' => [
                'nullable',
                'string',
                'max:100',
            ],

            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'tipo',
            'status' => 'estado',
            'priority' => 'prioridad',
            'category' => 'categoría',
        ];
    }
}