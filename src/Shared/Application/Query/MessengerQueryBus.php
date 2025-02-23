<?php

namespace App\Shared\Application\Query;

use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[WithMonologChannel('query-bus')]
class MessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(
        private readonly MessageBusInterface $queryBus,
        private readonly LoggerInterface $logger,
    )
    {
        $this->messageBus = $queryBus;
    }

    public function ask(Query $message): mixed
    {
        $this->logger->info('Entering query bus' . get_class($message));

        return $this->handleQuery($message);
    }

    public function getQueryBus(): MessageBusInterface
    {
        return $this->queryBus;
    }
}
