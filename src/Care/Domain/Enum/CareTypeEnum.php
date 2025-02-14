<?php

namespace App\Care\Domain\Enum;

enum CareTypeEnum: string
{
    case FEEDING = 'feeding';
    case CLEANING_LITTER = 'cleaning_litter';
    case VETERINARY_VISIT = 'veterinary_visit';
    case GROOMING = 'grooming';
}
