<?php

namespace App\Shared\Domain\Event;

use DateTimeImmutable;
use Symfony\Contracts\EventDispatcher\Event;

abstract class DomainEvent extends Event
{
    protected DateTimeImmutable $occurredOn;

    public function __construct()
    {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
