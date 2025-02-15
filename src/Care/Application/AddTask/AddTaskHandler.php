<?php

namespace App\Care\Application\AddTask;

use App\Care\Domain\Enum\CareTypeEnum;
use App\Care\Domain\Model\Task;
use App\Care\Domain\Repository\TaskRepository;
use App\Shared\Application\Command\CommandHandler;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus', method: 'handle')]
class AddTaskHandler implements CommandHandler
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
    )
    {
    }

    /**
     * @throws ORMException
     */
    public function handle(AddTaskMessage $message): void
    {
        $task = new Task();
        $task->setCareType(CareTypeEnum::from($message->careType));

        $this->taskRepository->save($task);
    }
}
