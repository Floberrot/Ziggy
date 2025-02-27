<?php

namespace App\Owner\Domain\Model;

use App\Cat\Domain\Model\Cat;
use App\User\Domain\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Attribute\Groups;

class Owner extends User
{
    public const string ROLE = "ROLE_OWNER";

    #[Groups(['owner:read'])]
    private Collection $cats;

    public function __construct()
    {
        $this->cats = new ArrayCollection();
    }

    public function addCat(Cat $cat): void
    {
        if ($this->cats->contains($cat)) {
            return;
        }

        $this->cats->add($cat);
        $cat->addOwner($this);
    }

    public function removeCat(Cat $cat): void
    {
        $this->cats->removeElement($cat);
    }

    public function getCats(): Collection
    {
        return $this->cats;
    }
}
