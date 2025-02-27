<?php

namespace App\Cat\Infrastructure\Listener;

use App\Cat\Domain\Event\CatCreated;
use App\Owner\Domain\Model\Owner;
use LogicException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: CatCreated::class, method: 'onCatCreated')]
readonly class CatIsCreatedListener
{
    public function __construct(
        private Security $security,
    )
    {
    }

    public function onCatCreated(CatCreated $event): void
    {
        $cat = $event->getCat();
        $user = $this->security->getUser();

        if (!$user instanceof Owner) {
            throw new LogicException('User is not an owner');
        }

        $cat->addOwner($user);
    }
}
