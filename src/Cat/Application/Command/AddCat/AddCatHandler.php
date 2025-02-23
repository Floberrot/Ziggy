<?php

namespace App\Cat\Application\Command\AddCat;

use App\Cat\Domain\Enum\GenderEnum;
use App\Cat\Domain\Model\Cat;
use App\Cat\Domain\Repository\CatRepository;
use App\Shared\Application\Command\CommandHandler;
use DateMalformedStringException;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus', method: 'handle')]
readonly class AddCatHandler implements CommandHandler
{
    public function __construct(
        private CatRepository $catRepository,
    )
    {
    }

    /**
     * @throws DateMalformedStringException
     */
    public function handle(AddCatMessage $command): void
    {
        $cat = new Cat();
        $cat->setName($command->name)
            ->setBreed($command->breed)
            ->setWeight($command->weight)
            ->setColor($command->color)
            ->setBirthDate($command->birthDate ? new DateTimeImmutable($command->birthDate) : null)
            ->setGender(GenderEnum::from($command->gender));

        $this->catRepository->save($cat);

        // Domain event to set owner on cat (if error, rollback)
    }
}
