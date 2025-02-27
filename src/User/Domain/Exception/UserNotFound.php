<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\AbstractException;

class UserNotFound extends AbstractException
{
    public function __construct(int $id, string $userType = "User")
    {
        parent::__construct("$userType $id not found", 404);
    }
}
