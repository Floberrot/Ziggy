<?php

namespace App\Shared\Domain\Model;

use BackedEnum;
use ReflectionClass;
use Symfony\Component\Serializer\Attribute\Groups;

abstract class Model
{
    public function toNormalized(array $context): array
    {
        $reflectionClass = new ReflectionClass($this);
        $data = [];

        do {
            foreach ($reflectionClass->getProperties() as $property) {
                foreach ($property->getAttributes() as $attribute) {
                    $attributeInstance = $attribute->newInstance();

                    if (!$attributeInstance instanceof Groups) {
                        continue;
                    }

                    if (!is_array($context['groups'])) {
                        if (!in_array($context['groups'], $attributeInstance->getGroups())) {
                            continue;
                        }
                    }

                    if (is_array($context['groups'])) {
                        $intersect = array_intersect($context['groups'], $attributeInstance->getGroups());
                        if (empty($intersect)) {
                            continue;
                        }
                    }

                    if ($property->getValue($this) instanceof BackedEnum) {
                        $data[$property->getName()] = $property->getValue($this)->value;
                        continue;
                    }

                    $data[$property->getName()] = $property->getValue($this);
                }
            }

            $reflectionClass = $reflectionClass->getParentClass();
        } while ($reflectionClass);

        return $data;
    }
}
