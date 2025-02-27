<?php

namespace App\Owner\Application\Command\AssignCatToOwner;

use App\Cat\Domain\Exception\CatNotFoundException;
use App\Cat\Domain\Repository\CatRepository;
use App\Owner\Domain\Exception\CatAlreadyAssignedToOwner;
use App\Owner\Domain\Model\Owner;
use App\Owner\Domain\Repository\OwnerRepository;
use App\Shared\Application\Command\CommandHandler;
use App\User\Domain\Exception\UserNotFound;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus', method: 'handle')]
readonly class AssignCatToOwnerHandler implements CommandHandler
{
    public function __construct(
        private OwnerRepository $ownerRepository,
        private CatRepository   $catRepository,
    )
    {
    }

    public function handle(AssignCatToOwnerMessage $command): void
    {
        $owner = $this->ownerRepository->find($command->id);

        if ($owner === null) {
            throw new UserNotFound($command->id, 'Owner');
        }

        $cat = $this->catRepository->find($command->catId);

        if ($cat === null) {
            throw new CatNotFoundException($command->catId);
        }

        if ($owner->getCats()->contains($cat)) {
            throw new CatAlreadyAssignedToOwner($command->id, $command->catId);
        }

        assert($owner instanceof Owner);
        $owner->addCat($cat);
    }
}
