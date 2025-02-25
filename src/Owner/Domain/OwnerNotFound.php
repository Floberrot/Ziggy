<?php

namespace App\Owner\Domain;

use App\Shared\Domain\Exception\AbstractException;

class OwnerNotFound extends AbstractException
{
    public function __construct(int $id)
    {
        parent::__construct("Owner not found with id: $id", 404);
    }
}
