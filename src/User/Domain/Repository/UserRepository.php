<?php

namespace App\User\Domain\Repository;

use App\Shared\Domain\Repository\AbstractRepository;
use App\User\Domain\Model\User;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;

#[WithMonologChannel('doctrine-saver')]
class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, User::class, $logger);
    }
}
