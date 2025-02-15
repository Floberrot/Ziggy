<?php

namespace App\Shared\Domain\Event;

class PhoneNumberAwareEvent extends DomainEvent
{
    protected string $phoneNumber;

    public function __construct(
        string $phoneNumber,
    )
    {
        parent::__construct();

        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}
