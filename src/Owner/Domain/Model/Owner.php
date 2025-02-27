<?php

namespace App\Owner\Domain\Model;

use App\Cat\Domain\Model\Cat;
use App\User\Domain\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Owner extends User
{
    public const string ROLE = "ROLE_OWNER";

    private Collection $cats;

    public function __construct()
    {
        $this->cats = new ArrayCollection();
    }

    public function addCat(Cat $cat): void
    {
        $this->cats->add($cat);
    }

    public function getCats(): Collection
    {
        return $this->cats;
    }
}
