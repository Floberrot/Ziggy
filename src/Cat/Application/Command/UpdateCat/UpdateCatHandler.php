<?php

namespace App\Cat\Application\Command\UpdateCat;

use App\Cat\Domain\Exception\CatNotFoundException;
use App\Cat\Domain\Repository\CatRepository;
use App\Shared\Application\Command\CommandHandler;
use App\Shared\Domain\Interface\Utils\InitializationPropertiesExtractorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus', method: 'handle')]
readonly class UpdateCatHandler implements CommandHandler
{
    public function __construct(
        private CatRepository                              $catRepository,
        private InitializationPropertiesExtractorInterface $objectInitializeProperties,
    )
    {
    }

    public function handle(UpdateCatMessage $command): void
    {
        $cat = $this->catRepository->find($command->id);

        if ($cat === null) {
            throw new CatNotFoundException($command->id);
        }

        $setProperties = $this->objectInitializeProperties->cloneProperties($command);
        $cat->update($setProperties);
    }
}
