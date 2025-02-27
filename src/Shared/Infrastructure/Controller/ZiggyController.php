<?php

namespace App\Shared\Infrastructure\Controller;

use App\Shared\Application\Command\MessengerCommandBus;
use App\Shared\Application\Query\MessengerQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;

abstract class ZiggyController extends AbstractController
{
    public function __construct(
        protected readonly MessengerCommandBus $commandBus,
        protected readonly MessengerQueryBus $queryBus,
        protected readonly Security $security,
    )
    {
    }
}
