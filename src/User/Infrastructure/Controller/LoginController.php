<?php

namespace App\User\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

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
       return new JsonResponse(null, 201);
    }
}
