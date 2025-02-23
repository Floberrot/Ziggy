<?php

namespace App\Care\Application\GetTaskById;

use App\Care\Domain\Exception\Task\TaskNotFoundException;
use App\Care\Domain\Repository\TaskRepository;
use App\Shared\Application\Query\QueryHandler;
use App\Shared\Application\Query\QueryResponse;
use ReflectionException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler(bus: 'query.bus', method: 'handle')]
readonly class GetTaskHandler implements QueryHandler
{
    public function __construct(
        private TaskRepository $taskRepository,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     * @throws ReflectionException
     */
    public function handle(GetTaskMessage $message): QueryResponse
    {
        if (null === $task = $this->taskRepository->find($message->id)) {
            throw new TaskNotFoundException(taskId: $message->id);
        }

        return new QueryResponse(data: $task, context: ['groups' => 'task:read']);
    }
}
