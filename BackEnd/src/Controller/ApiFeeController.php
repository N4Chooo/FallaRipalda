<?php

namespace App\Controller;

use App\Entity\Fees;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/fees')]
final class ApiFeeController extends AbstractController
{
    #[Route('', methods: ['GET'], name: 'listFees')]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $fees = $em->getRepository(Fees::class)->findAll();

        $data = [];

        foreach ($fees as $fee) {
            $data[] = [
                'type' => $fee->getType(),
                'price' => $fee->getPrice(),
            ];
        }

        if (count($data) === 0) {
            return new JsonResponse(['status' => 'No hay cuotas registradas'], 404);
        } else {
            return new JsonResponse($data);
        }
    }
}
