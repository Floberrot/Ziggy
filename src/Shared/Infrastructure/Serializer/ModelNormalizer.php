<?php

namespace App\Shared\Infrastructure\Serializer;

use App\Shared\Domain\Model\Model;
use ArrayObject;
use DateTimeImmutable;
use ReflectionException;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AutoconfigureTag('serializer.normalizer')]
readonly class ModelNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     * @throws ReflectionException
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|ArrayObject|null
    {
        if (!$data instanceof Model) {
            return $this->normalizer->normalize($data, $format, $context);
        }

        $result = $data->toNormalized($context);

        foreach ($result as $key => $value) {
            if (is_object($value)) {
                $result[$key] = $this->normalize($value, $format, $context);
            }

            if ($value instanceof DateTimeImmutable){
                $result[$key] = $value->format('Y-m-d');
            }
        }

        return $result;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Model;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Model::class => true,
        ];
    }
}
