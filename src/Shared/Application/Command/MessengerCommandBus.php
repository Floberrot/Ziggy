<?php

namespace App\Shared\Application\Command;

use Doctrine\ORM\EntityManagerInterface;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[WithMonologChannel('command-bus')]
final readonly class MessengerCommandBus implements CommandBus
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function dispatch(Command $command): void
    {
        $commandName = get_class($command);
        $this->logger->info('begin transaction for command: ' . $commandName);
        $this->entityManager->beginTransaction();
        try {
            $this->commandBus->dispatch($command);
            $this->logger->info('command dispatched: ' . $commandName);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->logger->info('transaction committed for command: ' . $commandName);
        } catch (ExceptionInterface $e) {
            $this->logger->critical('an error occurred, transaction rolled back for command: ' . $commandName);
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
