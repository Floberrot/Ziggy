<?php

namespace App\Owner\Application\Command\RegisterOwner;

use App\Owner\Domain\Model\Owner;
use App\Owner\Domain\Repository\OwnerRepository;
use App\Shared\Application\Command\CommandHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler(bus: 'command.bus', method: 'handle')]
readonly class RegisterOwnerHandler implements CommandHandler
{
    public function __construct(
        private OwnerRepository $ownerRepository,
        private UserPasswordHasherInterface $hasher,
    )
    {
    }

    public function handle(RegisterOwnerMessage $command): void
    {
        $owner = new Owner();
        $owner->setRoles([Owner::ROLE])
            ->setEmail($command->email)
            ->setPassword($this->hasher->hashPassword($owner, $command->password))
            ->setFirstName($command->firstName)
            ->setLastName($command->lastName)
            ->setPhone($command->phone);

        $this->ownerRepository->save($owner);
    }
}
