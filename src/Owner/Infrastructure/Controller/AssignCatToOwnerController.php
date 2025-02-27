<?php

namespace App\Owner\Infrastructure\Controller;

use App\Owner\Application\Command\AssignCatToOwner\AssignCatToOwnerMessage;
use App\Owner\Application\Query\GetOwner\GetOwnerMessage;
use App\Shared\Infrastructure\Attribute\Security\IsOwner;
use App\Shared\Infrastructure\Controller\ZiggyController;
use App\Shared\Infrastructure\Http\ExceptionResponse;
use App\Shared\Infrastructure\Http\ZiggyResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('/{id}/cats/{catId}', name: 'add_owner_to_cat', methods: ['PUT'])]
#[IsOwner]
class AssignCatToOwnerController extends ZiggyController
{
    public function __invoke(
        int $id,
        int $catId,
    ): JsonResponse
    {
        try {
            $assignCatToOwner = new AssignCatToOwnerMessage(id: $id, catId: $catId);
            $this->commandBus->dispatch($assignCatToOwner);

            $getOwner = new GetOwnerMessage(id: $id);
            $owner = $this->queryBus->ask($getOwner);

            return new ZiggyResponse(
                message: 'Owner added to cat', data: $owner, code: 200
            );
        } catch (Throwable $t) {
            return new ExceptionResponse($t);
        }
    }
}
