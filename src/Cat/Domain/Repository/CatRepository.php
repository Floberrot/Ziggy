<?php

namespace App\Cat\Domain\Repository;

use App\Cat\Domain\Model\Cat;
use App\Shared\Domain\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;

#[WithMonologChannel('doctrine-saver')]
class CatRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Cat::class, $logger);
    }
}
