<?php

namespace App\Shared\Infrastructure\Listener;

use App\Care\Domain\Event\TaskCreated;
use App\Shared\Domain\Event\PhoneNumberAwareEvent;
use Exception;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: TaskCreated::class, priority: -10)]
#[WithMonologChannel('notify-user-listener')]
readonly class NotifyUserLister
{
    public function __construct(
        private LoggerInterface $logger,
    )
    {
    }

    public function __invoke(PhoneNumberAwareEvent $event): void
    {
        try {
            // todo: send sms
            throw new Exception('sms service not implemented');
        } catch (Exception) {
            $this->logger->warning('Error sending SMS', ['event' => $event]);
        }
    }
}
