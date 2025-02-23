<?php

namespace App\Care\Domain\Enum;

use App\Shared\Domain\Traits\GetValuesTrait;

enum CareTypeEnum: string
{
    use GetValuesTrait;

    case FEEDING = 'feeding';
    case CLEANING_LITTER = 'cleaning_litter';
    case VETERINARY_VISIT = 'veterinary_visit';
    case GROOMING = 'grooming';
    case CHANGING_WATER = 'changing_water';
    case CHANGING_LITTER = 'changing_litter';
}
