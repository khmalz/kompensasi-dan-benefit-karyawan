<?php

namespace App\Enums;

enum BenefitStatus: string
{
    case MENUNGGU = 'pending';
    case PROSES = 'progress';
    case SELESAI = 'done';
    case TOLAK = 'reject';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
