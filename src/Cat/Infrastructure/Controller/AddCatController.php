<?php

namespace App\Cat\Infrastructure\Controller;

use App\Cat\Application\Command\AddCat\AddCatMessage;
use App\Cat\Application\Query\GetCat\GetCatMessage;
use App\Shared\Application\Command\MessengerCommandBus;
use App\Shared\Application\Query\MessengerQueryBus;
use App\Shared\Infrastructure\Attribute\Security\IsOwner;
use App\Shared\Infrastructure\Http\ExceptionResponse;
use App\Shared\Infrastructure\Http\ZiggyResponse;
use App\Shared\Infrastructure\Utils\ParameterBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('', name: 'add_new_cat', methods: ['POST'])]
#[IsOwner]
class AddCatController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    )
    {
    }

    public function __invoke(
        #[MapRequestPayload] AddCatMessage $message,
    ): JsonResponse
    {
        try {
            $this->commandBus->dispatch($message);

            $addedCat = ParameterBag::getInstance()->get('Cat');
            $getCatsMessage = new GetCatMessage($addedCat->getId());
            $cat = $this->queryBus->ask($getCatsMessage);

            return new ZiggyResponse('Cat added successfully', $cat, Response::HTTP_CREATED);
        } catch (Throwable $t) {
            return new ExceptionResponse($t);
        }
    }
}
