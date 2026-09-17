<?php

namespace App\Http\Requests;

use App\Constants\PqrsPriority;
use App\Constants\PqrsStatus;
use App\Constants\TrackingActionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSeguimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'tipo_accion' => [
                'required',
                Rule::in(TrackingActionType::all()),
            ],

            'prioridad' => [
                'required',
                Rule::in(PqrsPriority::all()),
            ],

            'estado' => [
                'required',
                Rule::in(PqrsStatus::all()),
            ],

            'statusOldValue' => [
                'required',
                Rule::in(PqrsStatus::all()),
            ],

            'descripcion' => [
                'required',
                'string',
                'max:5000',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $estado = $this->input('estado');
            $descripcion = trim($this->input('descripcion', ''));

            if (
                in_array($estado, [
                    PqrsStatus::RESUELTA,
                    PqrsStatus::CERRADA,
                ])
                && $descripcion === ''
            ) {
                $validator->errors()->add(
                    'descripcion',
                    'Debe ingresar un comentario para marcar la PQR como resuelta o cerrada.'
                );
            }
        });
    }
}
