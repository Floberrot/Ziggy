<?php

namespace App\Shared\Domain\Bus\Query;

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
        private readonly LoggerInterface $logger
    )
    {
        $this->messageBus = $queryBus;
    }

    public function handle(Query $message): mixed
    {
        $this->logger->info('Entering query bus' . get_class($message));
        return $this->handleQuery($message);
    }
}
