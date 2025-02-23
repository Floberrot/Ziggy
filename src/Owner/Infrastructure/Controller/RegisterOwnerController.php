<?php

namespace App\Owner\Infrastructure\Controller;

use App\Owner\Application\Command\RegisterOwner\RegisterOwnerMessage;
use App\Shared\Application\Command\MessengerCommandBus;
use App\Shared\Infrastructure\Attribute\Security\IsOwner;
use App\Shared\Infrastructure\Http\ExceptionResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('', name: 'register_owner', methods: ['POST'])]
#[IsOwner]
class RegisterOwnerController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
    )
    {
    }

    public function __invoke(
        #[MapRequestPayload] RegisterOwnerMessage $message,
    ): JsonResponse
    {
        try {
            $this->commandBus->dispatch($message);

            return new JsonResponse(null, Response::HTTP_CREATED);
        } catch (Throwable $t) {
            return new ExceptionResponse($t);
        }
    }
}
