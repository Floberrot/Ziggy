<?php

namespace App\Care\Domain\Enum;

enum CareTypeEnum: string
{
    case FEEDING = 'feeding';
    case CLEANING_LITTER = 'cleaning_litter';
    case VETERINARY_VISIT = 'veterinary_visit';
    case GROOMING = 'grooming';
    case CHANGING_WATER = 'changing_water';
    case CHANGING_LITTER = 'changing_litter';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
