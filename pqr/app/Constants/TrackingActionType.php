<?php

namespace App\Constants;

class TrackingActionType
{
    public const COMENTARIO = 'comentario';
    public const RESPUESTA = 'respuesta';
    public const CAMBIO_ESTADO = 'cambio_estado';
    public const CAMBIO_PRIORIDAD = 'cambio_prioridad';

    public static function all(): array
    {
        return [
            self::COMENTARIO,
            self::RESPUESTA,
            self::CAMBIO_ESTADO,
            self::CAMBIO_PRIORIDAD,
        ];
    }

    public static function labels(): array
    {
        return [
            self::COMENTARIO => 'Comentario',
            self::RESPUESTA => 'Respuesta',
            self::CAMBIO_ESTADO => 'Cambio de estado',
            self::CAMBIO_PRIORIDAD => 'Cambio de prioridad',
        ];
    }
}