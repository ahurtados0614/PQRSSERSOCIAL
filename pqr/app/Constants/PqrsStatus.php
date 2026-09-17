<?php

namespace App\Constants;

class PqrsStatus
{
    public const RECIBIDA = 'recibida';
    public const EN_GESTION = 'en_gestion';
    public const RESUELTA = 'resuelta';
    public const CERRADA = 'cerrada';

    public static function all(): array
    {
        return [
            self::RECIBIDA,
            self::EN_GESTION,
            self::RESUELTA,
            self::CERRADA,
        ];
    }
    public static function labels(): array
    {
        return [
            self::RECIBIDA => 'Recibida',
            self::EN_GESTION => 'En gestión',
            self::RESUELTA => 'Resuelta',
            self::CERRADA => 'Cerrada',
        ];
    }
}
