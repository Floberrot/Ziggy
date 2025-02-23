<?php

namespace App\Cat\Application\Command\AddCat;

use App\Cat\Domain\Enum\GenderEnum;
use App\Shared\Application\Command\Command;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AddCatMessage implements Command
{
    #[Length(min: 1, max: 255)]
    #[NotNull]
    #[NotBlank]
    public string $name;
    #[Choice(
        callback: [GenderEnum::class, 'getValues'],
    )]
    #[NotNull]
    public string $gender;
    public ?string $breed = null;
    public ?string $weight = null;
    #[DateTime(format: 'Y-m-d')]
    public ?string $birthDate = null;
    public ?string $color = null;
}
