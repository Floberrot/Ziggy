<?php

namespace App\Shared\Domain\Interface\Utils;

interface InitializationPropertiesExtractorInterface
{
    public function cloneProperties(object $object): object;
}
