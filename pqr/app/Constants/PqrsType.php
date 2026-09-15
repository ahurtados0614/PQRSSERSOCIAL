<?php

namespace App\Constants;

class PqrsType
{
    public const PETICION = 'peticion';
    public const QUEJA = 'queja';
    public const RECLAMO = 'reclamo';

    public static function all(): array
    {
        return [
            self::PETICION,
            self::QUEJA,
            self::RECLAMO,
        ];
    }

    public static function labels(): array
    {
        return [
            self::PETICION => 'Petición',
            self::QUEJA => 'Queja',
            self::RECLAMO => 'Reclamo',
        ];
    }
}