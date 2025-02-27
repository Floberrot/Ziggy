<?php

declare(strict_types=1);

namespace App\Care\Infrastructure\Controller;

use App\Care\Application\AddTask\AddTaskMessage;
use App\Care\Application\GetTaskById\GetTaskMessage;
use App\Shared\Infrastructure\Controller\ZiggyController;
use App\Shared\Infrastructure\Http\ExceptionResponse;
use App\Shared\Infrastructure\Http\ZiggyResponse;
use App\Shared\Infrastructure\Utils\ParameterBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('', name: 'add_task', methods: ['POST'])]
class AddTaskController extends ZiggyController
{
    public function __invoke(
        #[MapRequestPayload] AddTaskMessage $message,
    ): JsonResponse
    {
        try {
            $this->commandBus->dispatch($message);
            $task = ParameterBag::getInstance()->get("Task");

            $getTask = new GetTaskMessage(id: $task->getId());
            $response = $this->queryBus->ask($getTask);

            return new ZiggyResponse(
                message: 'Task added',
                data: $response,
                code: 201
            );
        } catch (Throwable $t) {
            return new ExceptionResponse($t);
        }
    }
}
