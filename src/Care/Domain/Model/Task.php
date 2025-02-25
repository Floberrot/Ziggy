<?php

namespace App\Care\Domain\Model;

use App\Care\Domain\Enum\CareTypeEnum;
use App\Owner\Domain\Model\Owner;
use App\Shared\Domain\Model\Model;
use Stringable;
use Symfony\Component\Serializer\Attribute\Groups;

class Task extends Model implements Stringable
{
    #[Groups(['task:read'])]
    private int $id;

    #[Groups(['task:read'])]
    private CareTypeEnum $careType;

    #[Groups(['task:read'])]
    private ?string $comment;

    #[Groups(['task:read'])]
    private bool $done = false;

    #[Groups(['task:read'])]
    private ?Owner $owner = null;

    public function getCareType(): CareTypeEnum
    {
        return $this->careType;
    }

    public function setCareType(CareTypeEnum $careType): self
    {
        $this->careType = $careType;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return json_encode(array_map(fn($value) => $value, get_object_vars($this)));
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function isDone(): bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;

        return $this;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
