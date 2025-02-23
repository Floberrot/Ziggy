<?php

namespace App\Shared\Domain\Repository;

use App\Shared\Infrastructure\Utils\ParameterBag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected string $entityName;

    public function __construct(
        ManagerRegistry $registry,
        string $entityClass,
        private readonly LoggerInterface $logger,
    )
    {
        parent::__construct($registry, $entityClass);

        $parts = explode('\\', $entityClass);
        $this->entityName = end($parts);
    }

    public function save(object $entity): void
    {
        $this->logger->info('Saving entity', ['entity' => $this->entityName]);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        $this->logger->info('Entity saved' , ['entity' => $this->entityName]);

        ParameterBag::getInstance()->set("{$this->entityName}", $entity);
    }
}
