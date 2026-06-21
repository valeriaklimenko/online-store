<?php

namespace App\Enums\Sizes;

enum ClothesSizes: string
{
    case XSS = 'XSS';
    case XS = 'XS';
    case S = 'S';
    case M = 'M';
    case L = 'L';
    case XL = 'XL';
    case XXL = 'XXL';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
