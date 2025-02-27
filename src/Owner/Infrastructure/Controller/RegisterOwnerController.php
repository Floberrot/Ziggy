<?php

namespace App\Owner\Infrastructure\Controller;

use App\Owner\Application\Command\RegisterOwner\RegisterOwnerMessage;
use App\Owner\Domain\Model\Owner;
use App\Shared\Infrastructure\Attribute\Security\IsOwner;
use App\Shared\Infrastructure\Controller\ZiggyController;
use App\Shared\Infrastructure\Http\ExceptionResponse;
use App\Shared\Infrastructure\Http\ZiggyResponse;
use App\Shared\Infrastructure\Utils\ParameterBag;
use App\User\Application\Query\GetUser\GetUserMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('', name: 'register_owner', methods: ['POST'])]
#[IsOwner]
class RegisterOwnerController extends ZiggyController
{
    public function __invoke(
        #[MapRequestPayload] RegisterOwnerMessage $message,
    ): JsonResponse
    {
        try {
            $this->commandBus->dispatch($message);

            /** @var Owner $newOwner */
            $newOwner = ParameterBag::getInstance()->get('Owner');

            $getUser = new GetUserMessage($newOwner->getId());
            $user = $this->queryBus->ask($getUser);

            return new ZiggyResponse("New user is register.", $user, Response::HTTP_CREATED);
        } catch (Throwable $t) {
            return new ExceptionResponse($t);
        }
    }
}
