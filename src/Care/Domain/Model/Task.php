<?php

namespace App\Care\Domain\Model;

use App\Care\Domain\Enum\CareTypeEnum;
use App\Shared\Domain\Model\Model;
use Stringable;
use Symfony\Component\Serializer\Attribute\Groups;

class Task extends Model implements Stringable
{
    #[Groups(['task:read'])]
    private int $id;

    #[Groups(['task:read'])]
    private CareTypeEnum $careType;

    public function getCareType(): CareTypeEnum
    {
        return $this->careType;
    }

    public function setCareType(CareTypeEnum $careType): void
    {
        $this->careType = $careType;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return json_encode(array_map(fn($value) => $value, get_object_vars($this)));
    }
}
