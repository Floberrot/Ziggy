<?php

namespace App\User\Infrastructure\Controller;

use App\Shared\Application\Query\MessengerQueryBus;
use App\Shared\Infrastructure\Http\ExceptionResponse;
use App\Shared\Infrastructure\Http\ZiggyResponse;
use App\User\Application\Query\GetUser\GetUserMessage;
use App\User\Domain\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('', name: 'app_login', methods: ['POST'])]
class LoginController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
        private readonly MessengerQueryBus $queryBus,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        try {
            /** @var User $securityUser */
            $securityUser = $this->security->getUser();
            $user = $this->queryBus->ask(new GetUserMessage($securityUser->getId()));

            return new ZiggyResponse(
                message: 'User logged in',
                data: $user
            );
        } catch (Throwable $t) {
            return new ExceptionResponse($t);
        }
    }
}
