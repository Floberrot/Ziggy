<?php

namespace App\Shared\Infrastructure\Factory;

use App\Care\Domain\Enum\CareTypeEnum;
use App\Care\Domain\Model\Task;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Task>
 */
final class TaskFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Task::class;
    }

    protected function defaults(): array
    {
        return [
            'careType' => self::faker()->randomElement(CareTypeEnum::cases()),
            'done' => self::faker()->boolean(),
        ];
    }

    protected function initialize(): static
    {
        return $this;
            // ->afterInstantiate(function(Task $task): void {})
    }
}
