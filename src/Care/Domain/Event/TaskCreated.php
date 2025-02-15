<?php

namespace App\Care\Domain\Event;

use App\Care\Domain\Model\Task;
use App\Shared\Domain\Event\PhoneNumberAwareEvent;

final class TaskCreated extends PhoneNumberAwareEvent
{
    public function __construct(
        public Task $task,
        string $phoneNumber,
    )
    {
        parent::__construct($phoneNumber);
    }
}
