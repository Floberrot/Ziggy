<?php

namespace App\Shared\Domain\Exception;

class UserIsNotOwner extends AbstractException
{
    public function __construct(string $email)
    {
        parent::__construct("Access denied for %email%, this user is not owner", 403, ['%email%' => $email]);
    }
}
