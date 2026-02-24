<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;

class ApiSecurityController extends AbstractController
{
    #[Route(path: '/api/login', name: 'app_login')]
    public function login(#[CurrentUser] ?User $user): JsonResponse
    {

        if (null === $user) {
            return $this->json([
                'message' => 'Credenciales inválidas',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'dni' => $user->getDni(),
            'user' => $user->getUserIdentifier(),
            'name' => $user->getName(),
            'roles' => $user->getRoles(),
            'status' => 'success'
        ]);
    }

    #[Route(path: '/api/logout', name: 'app_logout')]
    public function logout(): void
    {
        # el logout se hace en el cliente Angular
    }
}
