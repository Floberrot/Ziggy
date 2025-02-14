<?php

namespace App\Care\Domain\Model;

use App\Care\Domain\Enum\CareTypeEnum;

class Task
{
    private int $id;
    private CareTypeEnum $careType;
}
