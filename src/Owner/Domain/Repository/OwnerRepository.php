<?php

namespace App\Owner\Domain\Repository;

use App\Owner\Domain\Model\Owner;
use App\Shared\Domain\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;

#[WithMonologChannel('doctrine-saver')]
class OwnerRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Owner::class, $logger);
    }
}
