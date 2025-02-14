<?php

namespace App\Care\Domain\Repository;

use App\Care\Domain\Model\Task;
use App\Shared\Domain\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class TaskRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Task::class, $logger);
    }
}
