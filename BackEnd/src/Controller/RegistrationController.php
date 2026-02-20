<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/register')]
class RegistrationController extends AbstractController
{
    #[Route('', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): JsonResponse
    {


        $data = json_decode($request->getContent(), true);

        try {
            $user = new User();
            /** @var string $plainPassword */
            $plainPassword = ($data['plainPassword']);
            $dni = ($data['dni']);
            $name = ($data['name']);
            $email = ($data['email']);

            // encode the plain password
            $user->setEmail($email);
            $user->setDni($dni);
            $user->setName($name);
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();


            return new JsonResponse(['status' => 'User creado con email -> ' . $email], 201);

        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'Usuario ya existente'], 400);
        }
    }
}
