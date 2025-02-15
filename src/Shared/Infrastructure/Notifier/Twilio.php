<?php

namespace App\Shared\Infrastructure\Notifier;

use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;

class Twilio
{
    public function __construct(
        private readonly TexterInterface $texter,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     *
     * TODO : improve it with the possibility to exends the services (Twilio, FakeSMS, etc)
     */
    public function send(string $phoneNumber, string $message): void
    {
        $sms = new SmsMessage(
            $phoneNumber,
            $message,
            "+15005550006"
        );

        $this->texter->send($sms);
    }
}
