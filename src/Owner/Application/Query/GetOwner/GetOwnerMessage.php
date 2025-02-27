<?php

namespace App\Owner\Application\Query\GetOwner;

use App\Shared\Application\Query\Query;

class GetOwnerMessage implements Query
{
    public function __construct(
        public int $id,
    )
    {
    }
}
