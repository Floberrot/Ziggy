<?php

namespace App\Shared\Application\Query;

interface QueryBus
{
    public function ask(Query $message): mixed;
}
