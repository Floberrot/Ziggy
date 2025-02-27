<?php

namespace App\Owner\Application\Command\AssignCatToOwner;

use App\Shared\Application\Command\Command;

class AssignCatToOwnerMessage implements Command
{
    public function __construct(
        public int $id,
        public int $catId,
    )
    {
    }
}
