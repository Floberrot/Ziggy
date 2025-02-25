<?php

namespace App\Shared\Infrastructure\Listener;

use App\Shared\Infrastructure\Http\ExceptionResponse;
use Exception;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsEventListener(event: 'kernel.exception')]
readonly class ConstraintViolationListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $validationFailedException = $exception->getPrevious();

        if (!$validationFailedException instanceof ValidationFailedException) {
            return;
        }

        $violations = $validationFailedException->getViolations();

        $messages = "";
        foreach ($violations as $violation) {
            $messages .= $violation->getMessage() . " on property : " . $violation->getPropertyPath() . ". \n";
        }
        $exceptionResponse = new ExceptionResponse(new Exception($messages, 422));
        $event->setResponse($exceptionResponse);
        $event->stopPropagation();
    }
}
