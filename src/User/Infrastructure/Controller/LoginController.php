<?php

namespace App\User\Infrastructure\Controller;

use App\Shared\Infrastructure\Http\ExceptionResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('', name: 'app_login', methods: ['POST'])]
class LoginController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            return new JsonResponse(null, 201);
        } catch (Throwable $t) {
            return new ExceptionResponse($t);
        }
    }
}
