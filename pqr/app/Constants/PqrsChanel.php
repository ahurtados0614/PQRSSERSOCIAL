<?php

namespace App\Constants;

class PqrsChanel
{
    public const WEB = 'web';
    public const EMAIL = 'email';
    public const PRESENCIAL = 'presencial';

    public static function all(): array
    {
        return [
            self::WEB,
            self::EMAIL,
            self::PRESENCIAL,
        ];
    }
    public static function labels(): array
    {
        return [
            self::WEB => 'Web',
            self::EMAIL => 'Email',
            self::PRESENCIAL => 'Presencial',
        ];
    }
}