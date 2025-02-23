<?php

namespace App\Cat\Application\Query\GetCat;

use App\Cat\Domain\Exception\CatNotFoundException;
use App\Cat\Domain\Repository\CatRepository;
use App\Shared\Application\Query\QueryHandler;
use App\Shared\Application\Query\QueryResponse;
use ReflectionException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler(bus: 'query.bus', method: 'handle')]
readonly class GetCatHandler implements QueryHandler
{
    public function __construct(
        private CatRepository $catRepository,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     * @throws ReflectionException
     */
    public function handle(GetCatMessage $query): QueryResponse
    {
        if (null === $cat = $this->catRepository->find($query->id)) {
            throw new CatNotFoundException($query->id);
        }

        return new QueryResponse($cat, ['groups' => 'cat:read']);
    }
}
