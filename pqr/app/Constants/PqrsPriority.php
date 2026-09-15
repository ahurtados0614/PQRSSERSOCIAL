<?php

namespace App\Constants;

class PqrsPriority
{
    public const BAJA = 'baja';
    public const MEDIA = 'media';
    public const ALTA = 'alta';
    public const URGENTE = 'urgente';

    public static function all(): array
    {
        return [
            self::BAJA,
            self::MEDIA,
            self::ALTA,
            self::URGENTE,
        ];
    }
}