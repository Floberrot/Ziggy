<?php

namespace App\Shared\Infrastructure\Utils;

use App\Shared\Domain\Interface\Utils\InitializationPropertiesExtractorInterface;
use ReflectionObject;
use stdClass;

final class InitializePropertiesExtractorInterface implements InitializationPropertiesExtractorInterface
{
    public function cloneProperties(object $object): object
    {
        $reflection = new ReflectionObject($object);
        $properties = $reflection->getProperties();
        $clone = new stdClass();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            if (isset($object->{$propertyName})) {
                $clone->{$propertyName} = $object->{$propertyName};
            }
        }

        return $clone;
    }
}
