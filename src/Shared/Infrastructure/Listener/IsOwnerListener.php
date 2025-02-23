<?php

namespace App\Shared\Infrastructure\Listener;

use App\Shared\Domain\Exception\UserIsNotOwner;
use App\Shared\Infrastructure\Attribute\Security\IsOwner;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[AsEventListener(event: ControllerArgumentsEvent::class, method: 'onKernelControllerArguments')]
readonly class IsOwnerListener
{
    public function __construct(
        private AuthorizationCheckerInterface $authChecker,
        private Security $security,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => ['onKernelControllerArguments', 20],
            KernelEvents::EXCEPTION => ['onKernelException', 20]];
    }

    public function onKernelControllerArguments(ControllerArgumentsEvent $event): void
    {
        $attributes = $event->getAttributes()[IsOwner::class] ?? null;
        if (!is_array($attributes)) {
            return;
        }

        if (!empty(array_filter($attributes, fn($attr) => $attr instanceof IsOwner))) {
            if (!$this->authChecker->isGranted('IS_OWNER', $this->security->getUser())) {
                throw new UserIsNotOwner($this->security->getUser()->getEmail());
            }
        }
    }
}
