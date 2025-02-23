<?php

namespace App\Cat\Application\Query\GetCat;

use App\Shared\Application\Query\Query;

class GetCatMessage implements Query
{
    public function __construct(
        public int $id,
    )
    {
    }
}
