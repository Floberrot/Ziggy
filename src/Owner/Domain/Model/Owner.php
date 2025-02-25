<?php

namespace App\Owner\Domain\Model;

use App\User\Domain\Model\User;
use Doctrine\Common\Collections\Collection;

class Owner extends User
{
    public const string ROLE = "ROLE_OWNER";

    private Collection $cats;
    private Collection $tasks;

    // todo: improve get/set cats
    public function getCats(): Collection
    {
        return $this->cats;
    }

    public function setCats(Collection $cats): self
    {
        $this->cats = $cats;

        return $this;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function setTasks(Collection $tasks): Owner
    {
        $this->tasks = $tasks;

        return $this;
    }
}
