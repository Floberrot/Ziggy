<?php

namespace App\Care\Domain\Exception\Task;

use App\Shared\Domain\Exception\AbstractException;

class TaskNotFoundException extends AbstractException
{
    public function __construct(int $taskId)
    {
        parent::__construct("Task with id %identifier% not found", 404, ['%identifier%' => $taskId]);
    }
}
