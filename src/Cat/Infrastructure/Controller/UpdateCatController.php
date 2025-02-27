<?php

namespace App\Cat\Infrastructure\Controller;

use App\Cat\Application\Command\UpdateCat\UpdateCatMessage;
use App\Cat\Application\Query\GetCat\GetCatMessage;
use App\Shared\Infrastructure\Attribute\Security\IsOwner;
use App\Shared\Infrastructure\Controller\ZiggyController;
use App\Shared\Infrastructure\Http\ExceptionResponse;
use App\Shared\Infrastructure\Http\ZiggyResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('/{id}', name: 'update_cat', methods: ['PATCH'])]
#[IsOwner]
class UpdateCatController extends ZiggyController
{
    public function __invoke(
        #[MapRequestPayload] UpdateCatMessage $message,
        int                                   $id,
    ): JsonResponse
    {
        try {
            $message->id = $id;
            $this->commandBus->dispatch($message);

            $getCatsMessage = new GetCatMessage($id);
            $cat = $this->queryBus->ask($getCatsMessage);

            return new ZiggyResponse('Cat added successfully', $cat, Response::HTTP_CREATED);
        } catch (Throwable $t) {
            return new ExceptionResponse($t);
        }
    }
}
