<?php

namespace App\Enums;

enum Roles: string
{
    case ADMIN = 'shop-admin';
    case MANAGER = 'shop-manager';
    case USER = 'user';
    case GUEST = 'guest';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

//    public static function casesArray(): array
//    {
//        return self::cases();
//    }
}
