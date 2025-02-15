<?php

namespace App\Shared\Infrastructure\Listener;

// #[AsEventListener(event: PhoneNumberAwareEvent::class,  priority: -10)]
use App\Care\Domain\Event\TaskCreated;
use App\Shared\Domain\Event\PhoneNumberAwareEvent;
use App\Shared\Infrastructure\Notifier\Twilio;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: TaskCreated::class, priority: -10)]
// #[WithMonologChannel('notify-user-listener')]
class NotifyUserLister
{
    public function __construct(
        private readonly Twilio $twilio,
        private readonly LoggerInterface $logger,
    )
    {
    }

    public function __invoke(PhoneNumberAwareEvent $event): void
    {
        try {
            throw new Exception('Error sending SMS');
            $this->twilio->send($event->getPhoneNumber(), 'Task created');
        } catch (Exception) {
            $this->logger->alert('Error sending SMS');
        }
    }
}
