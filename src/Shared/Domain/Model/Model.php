<?php

namespace App\Shared\Domain\Model;

use ReflectionClass;

abstract class Model
{
    public function toArray(): array
    {
        $reflectionClass = new ReflectionClass($this);
        $properties = $reflectionClass->getProperties();
        $data = [];

        foreach ($properties as $property) {
            $data[$property->getName()] = $property->getValue($this);
        }

        return $data;
    }
}
