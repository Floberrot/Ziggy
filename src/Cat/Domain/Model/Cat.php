<?php

namespace App\Cat\Domain\Model;

use App\Cat\Domain\Enum\GenderEnum;
use App\Owner\Domain\Model\Owner;
use App\Shared\Domain\Model\Model;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?float $weight;

    private Collection $owners;

    public function __construct()
    {
        $this->owners = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
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

    public function getOwners(): Collection
    {
        return $this->owners;
    }

    public function update(object $properties): void
    {
        foreach ($properties as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (method_exists($this, $setter)) {
                if ($this->{$property} instanceof GenderEnum) {
                    $value = GenderEnum::from($value);
                }

                if ($property === 'birthDate') {
                    $value = new DateTimeImmutable($value);
                }

                $this->$setter($value);
            }
        }
    }

    public function addOwner(Owner $owner): void
    {
        if ($this->owners->contains($owner)) {
            return;
        }

        $this->owners->add($owner);
        $owner->addCat($this);
    }
}
