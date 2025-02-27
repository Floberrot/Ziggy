<?php

namespace App\Care\Domain\Model;

use App\Care\Domain\Enum\CareTypeEnum;
use App\Shared\Domain\Model\Model;
use App\User\Domain\Model\User;
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
    private ?User $user = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Task
    {
        $this->user = $user;

        return $this;
    }
}
