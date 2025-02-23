<?php

namespace App\User\Application\Query\GetUser;

use App\Shared\Application\Query\Query;

class GetUserMessage implements Query
{
    public function __construct(
        public int $id,
    )
    {
    }
}
