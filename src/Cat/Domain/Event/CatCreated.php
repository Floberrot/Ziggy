<?php

namespace App\Cat\Domain\Event;

use App\Cat\Domain\Model\Cat;
use Symfony\Contracts\EventDispatcher\Event;

class CatCreated extends Event
{
    private Cat $cat;

    public function __construct(
        Cat $cat,
    )
    {
        $this->cat = $cat;
    }

    public function getCat(): Cat
    {
        return $this->cat;
    }
}
