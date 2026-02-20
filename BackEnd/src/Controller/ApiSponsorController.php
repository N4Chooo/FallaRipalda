<?php

namespace App\Controller;

use App\Entity\Sponsors;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/sponsors')]
final class ApiSponsorController extends AbstractController
{
    #[Route('', methods: ['GET'], name: 'listSponsors')]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $sponsors = $em->getRepository(Sponsors::class)->findAll();

        $data = [];

        foreach ($sponsors as $sponsor) {
            $data[] = [
                'name' => $sponsor->getName(),
                'photo' => $sponsor->getPhoto(),
            ];
        }

        if (count($data) === 0) {
            return new JsonResponse(['status' => 'No hay sponsors registrados'], 404);
        } else {
            return new JsonResponse($data);
        }
    }
}
