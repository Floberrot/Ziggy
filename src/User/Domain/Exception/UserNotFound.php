<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\AbstractException;

class UserNotFound extends AbstractException
{
    public function __construct(int $id)
    {
        parent::__construct("User $id not found", 404);
    }
}
