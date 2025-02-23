<?php

namespace App\Shared\Infrastructure\Factory;

use App\Sitter\Domain\Model\Sitter;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Sitter>
 */
final class SitterFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Sitter::class;
    }

    protected function defaults(): array
    {
        return [
            'email' => self::faker()->text(),
            'firstName' => self::faker()->text(),
            'lastName' => self::faker()->text(),
            'password' => self::faker()->text(),
            'phone' => self::faker()->text(),
            'roles' => [],
        ];
    }

    protected function initialize(): static
    {
        return $this;
        // ->afterInstantiate(function(Sitter $sitter): void {})
    }
}
