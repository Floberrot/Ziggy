<?php

namespace App\Cat\Domain\Enum;

use App\Shared\Domain\Traits\GetValuesTrait;

enum GenderEnum: string
{
    use GetValuesTrait;

    case MALE = 'male';
    case FEMALE = 'female';
}
