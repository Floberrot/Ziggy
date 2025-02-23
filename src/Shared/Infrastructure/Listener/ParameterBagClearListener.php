<?php

namespace App\Shared\Infrastructure\Listener;

use App\Shared\Infrastructure\Utils\ParameterBag;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::TERMINATE, method: 'onKernelTerminate')]
readonly class ParameterBagClearListener
{
    public function onKernelTerminate(TerminateEvent $event): void
    {
        ParameterBag::getInstance()->clear();
    }
}
