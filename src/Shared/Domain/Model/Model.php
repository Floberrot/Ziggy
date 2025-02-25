<?php

namespace App\Shared\Domain\Model;

use BackedEnum;
use DateTimeInterface;
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

                    if ($property->getValue($this) instanceof Model) {
                        $data[$property->getName()] = $property->getValue($this)->toNormalized($context);
                        continue;
                    }

                    if ($property->getValue($this) instanceof DateTimeInterface) {
                        $data[$property->getName()] = $property->getValue($this)->format('Y-m-d H:i:s');
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
