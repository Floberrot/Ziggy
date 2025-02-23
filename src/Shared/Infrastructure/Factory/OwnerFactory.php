<?php

namespace App\Shared\Infrastructure\Factory;

use App\Owner\Domain\Model\Owner;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Owner>
 */
final class OwnerFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Owner::class;
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
            // ->afterInstantiate(function(Owner $owner): void {})
    }
}
