<?php

namespace App\Shared\Domain\Traits;

trait GetValuesTrait
{
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
