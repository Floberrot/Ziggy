<?php

namespace App\Cat\Domain\Exception;

use App\Shared\Domain\Exception\AbstractException;

class CatNotFoundException extends AbstractException
{
    public function __construct(int $id)
    {
        $message = sprintf('Cat with id %s not found', $id);
        $code = 404;
        $parameters = ['id' => $id];

        parent::__construct($message, $code, $parameters);
    }
}
