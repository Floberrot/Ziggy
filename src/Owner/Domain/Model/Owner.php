<?php

namespace App\Owner\Domain\Model;

use App\User\Domain\Model\User;

class Owner extends User
{
    public const string ROLE = "ROLE_OWNER";

    private array $cats = [];

    public function getCats(): array
    {
        return $this->cats;
    }

    public function setCats(array $cats): void
    {
        $this->cats = $cats;
    }
}
