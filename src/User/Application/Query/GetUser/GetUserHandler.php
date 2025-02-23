<?php

namespace App\User\Application\Query\GetUser;

use App\Shared\Application\Query\QueryHandler;
use App\Shared\Application\Query\QueryResponse;
use App\User\Domain\Exception\UserNotFound;
use App\User\Domain\Repository\UserRepository;
use ReflectionException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler(bus: 'query.bus', method: 'handle')]
class GetUserHandler implements QueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     * @throws ReflectionException
     */
    public function handle(GetUserMessage $message): QueryResponse
    {
        if (null === $user = $this->userRepository->find($message->id)) {
            throw new UserNotFound(id: $message->id);
        }

        return new QueryResponse(data: $user, context: ['groups' => 'user:read']);
    }
}
