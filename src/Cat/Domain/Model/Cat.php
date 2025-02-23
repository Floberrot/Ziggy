<?php

namespace App\Cat\Domain\Model;

use App\Cat\Domain\Enum\GenderEnum;
use App\Shared\Domain\Model\Model;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Groups;

class Cat extends Model
{
    #[Groups(['cat:read'])]
    private int $id;
    #[Groups(['cat:read'])]
    private string $name;
    #[Groups(['cat:read'])]
    private ?string $breed;
    #[Groups(['cat:read'])]
    private ?string $color;
    #[Groups(['cat:read'])]
    private GenderEnum $gender;
    #[Groups(['cat:read'])]
    private ?DateTimeImmutable $birthDate;
    #[Groups(['cat:read'])]
    private ?string $weight;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeImmutable $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function setGender(GenderEnum $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(?string $breed): self
    {
        $this->breed = $breed;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
