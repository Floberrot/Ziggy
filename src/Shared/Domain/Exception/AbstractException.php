<?php

namespace App\Shared\Domain\Exception;

use LogicException;

abstract class AbstractException extends LogicException
{
    public function __construct(
        string          $message,
        int             $code,
        protected array $parameters = [],
    )
    {
        parent::__construct($message, $code);
    }
}
