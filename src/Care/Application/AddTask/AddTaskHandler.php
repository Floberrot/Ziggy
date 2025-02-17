<?php

namespace App\Care\Application\AddTask;

use App\Care\Domain\Enum\CareTypeEnum;
use App\Care\Domain\Event\TaskCreated;
use App\Care\Domain\Model\Task;
use App\Care\Domain\Repository\TaskRepository;
use App\Shared\Application\Command\CommandHandler;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus', method: 'handle')]
readonly class AddTaskHandler implements CommandHandler
{
    public function __construct(
        private TaskRepository           $taskRepository,
        private EventDispatcherInterface $dispatcher,
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
        $task->setComment($message->comment);
        $task->setDone($message->done);

        $this->taskRepository->save($task);

        // todo: temp num, waiting user part
        $this->dispatcher->dispatch(new TaskCreated($task, "+33612867389"));
    }
}
