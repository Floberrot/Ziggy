<?php

namespace App\Cat\Application\Command\UpdateCat;

use App\Cat\Domain\Enum\GenderEnum;
use App\Shared\Application\Command\Command;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;

class UpdateCatMessage implements Command
{
    public ?int $id = null;
    #[Length(min: 1, max: 255)]
    public ?string $name = null;
    #[Choice(
        callback: [GenderEnum::class, 'getValues'],
    )]
    public ?string $gender = null;
    public ?string $breed = null;
    #[Positive]
    public ?float $weight = null;
    #[DateTime(format: 'Y-m-d')]
    public ?string $birthDate = null;
    public ?string $color = null;
}
