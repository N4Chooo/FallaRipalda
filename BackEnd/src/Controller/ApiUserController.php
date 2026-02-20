<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/user', name: 'app_api_user')]
final class ApiUserController extends AbstractController
{
    #[Route('', methods: ['GET'], name: 'listUsers')]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $users = $em->getRepository(User::class)->findAll();

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'name' => $user->getName(),
                'dni' => $user->getDni(),
                'email' => $user->getEmail(),
            ];
        }

        if (count($data) === 0) {
            return new JsonResponse(['status' => 'No hay users registrados'], 404);
        } else {
            return new JsonResponse($data);
        }
    }
}
