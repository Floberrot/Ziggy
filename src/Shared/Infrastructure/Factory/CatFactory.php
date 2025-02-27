<?php

namespace App\Shared\Infrastructure\Factory;

use App\Cat\Domain\Enum\GenderEnum;
use App\Cat\Domain\Model\Cat;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Cat>
 */
final class CatFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Cat::class;
    }

    protected function defaults(): array
    {
        return [
            'gender' => self::faker()->randomElement(GenderEnum::cases()),
            'name' => self::faker()->text(),
        ];
    }

    protected function initialize(): static
    {
        return $this;
            // ->afterInstantiate(function(Cat $cat): void {})
    }
}
