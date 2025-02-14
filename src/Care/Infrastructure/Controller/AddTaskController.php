<?php

declare(strict_types=1);

namespace App\Care\Infrastructure\Controller;

use App\Care\Application\AddTask\AddTaskMessage;
use App\Shared\Domain\Bus\Command\MessengerCommandBus;
use App\Shared\Infrastructure\Utils\ParameterBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

#[Route('', name: 'add_task', methods: ['POST'])]
class AddTaskController extends AbstractController
{

    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    public function __invoke(
        #[MapRequestPayload] AddTaskMessage $message
    ): JsonResponse
    {
        try {
            $this->commandBus->dispatch($message);
            $task = ParameterBag::getInstance()->get("Task");

            // todo: query bus ? auto normalize in querybus ?
            return new JsonResponse([
                'message' => 'Task added',
                'data' => $this->normalizer->normalize(data: $task, context: ['groups' => 'task:read'])
            ], 201);
        } catch (Throwable $t) {
            return new JsonResponse(['error' => $t->getMessage()], 500);
        }
    }
}
