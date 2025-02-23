<?php

namespace App\Shared\Infrastructure\Attribute\Security;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class IsOwner
{
    public function __construct()
    {
    }
}
