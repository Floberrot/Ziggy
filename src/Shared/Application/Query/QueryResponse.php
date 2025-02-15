<?php

namespace App\Shared\Application\Query;

use App\Shared\Infrastructure\Serializer\ModelNormalizer;
use ReflectionException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class QueryResponse
{
    /**
     * @throws ExceptionInterface
     * @throws ReflectionException
     */
    public function __construct(
        private object|array $data,
        private readonly array $context = [],

    ) {
        $normalizer = new ModelNormalizer(new Serializer([new ObjectNormalizer()]));
        $this->data = $normalizer->normalize($data, context: $this->context);
    }

    public function getNormalizedData(): array
    {
        return $this->data;
    }
}
