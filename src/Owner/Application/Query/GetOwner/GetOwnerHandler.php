<?php

namespace App\Owner\Application\Query\GetOwner;

use App\Owner\Domain\Repository\OwnerRepository;
use App\Shared\Application\Query\QueryHandler;
use App\Shared\Application\Query\QueryResponse;
use App\User\Domain\Exception\UserNotFound;
use ReflectionException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler(bus: 'query.bus', method: 'handle')]
class GetOwnerHandler implements QueryHandler
{
    public function __construct(
        private OwnerRepository $ownerRepository,
    )
    {
    }

    /**
     * @throws ReflectionException
     * @throws ExceptionInterface
     */
    public function handle(GetOwnerMessage $message): QueryResponse
    {
        if (null === $owner = $this->ownerRepository->find($message->id)) {
            throw new UserNotFound(id: $message->id, userType: 'Owner');
        }

        return new QueryResponse(data: $owner, context: ['groups' => ['owner:read', 'user:read']]);
    }
}
