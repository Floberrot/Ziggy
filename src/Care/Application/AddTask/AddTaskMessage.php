<?php

namespace App\Care\Application\AddTask;

use App\Care\Domain\Enum\CareTypeEnum;
use App\Shared\Application\Command\Command;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotNull;

class AddTaskMessage implements Command
{
    #[Choice(
        callback: [CareTypeEnum::class, 'getValues'],
    )]
    #[NotNull]
    public string $careType;
}
