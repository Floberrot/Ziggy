<?php

namespace App\Care\Application\GetTaskById;

use App\Shared\Application\Query\Query;

class GetTaskMessage implements Query
{
    public function __construct(
        public int $id,
    )
    {
    }
}
