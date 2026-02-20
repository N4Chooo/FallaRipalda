<?php

namespace App\Controller;

use App\Entity\Monument;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/monuments')]
final class ApiMonumentController extends AbstractController
{
    #[Route('', methods: ['GET'], name: 'listMonuments')]
    public function list(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $monuments = $em->getRepository(Monument::class)->findAll();
        $year = $request->query->get('year');
        $data = [];

        if ($year) {
            if ($year <= 1999 || !is_numeric($year)) {
                return new JsonResponse(['status' => 'Introduce un año correcto'], 400);
            } else {
                foreach ($monuments as $monument) {
                    if ($monument->getYear()->format('Y') == $year) {
                        $data[] = [
                            'title' => $monument->getTitle(),
                            'year' => $monument->getYear()->format('Y'),
                            'artist' => $monument->getArtist(),
                            'photo' => 'http://localhost:8000/' . $monument->getPhoto(),
                            'sketch' => 'http://localhost:8000/' . $monument->getSketch(),
                            'pardoned_doll' => 'http://localhost:8000/' . $monument->getPardonedDoll(),
                            'prices' => $monument->getPrices(),
                            'criticism' => $monument->getCriticism(),
                        ];
                    }
                }
                if (count($data) === 0) {
                    return new JsonResponse(['status' => 'No hay fallas registradas en ese año'], 404);
                } else {
                    return new JsonResponse($data);
                }
            }
        } else {
            foreach ($monuments as $monument) {
                $data[] = [
                    'title' => $monument->getTitle(),
                    'year' => $monument->getYear()->format('Y'),
                    'artist' => $monument->getArtist(),
                    'photo' => 'http://localhost:8000/' . $monument->getPhoto(),
                    'sketch' => 'http://localhost:8000/' . $monument->getSketch(),
                    'pardoned_doll' => 'http://localhost:8000/' . $monument->getPardonedDoll(),
                    'prices' => $monument->getPrices(),
                    'criticism' => $monument->getCriticism(),
                ];
            }

            if (count($data) === 0) {
                return new JsonResponse(['status' => 'No hay fallas registradas'], 404);
            } else {
                return new JsonResponse($data);
            }
        }
    }
}

