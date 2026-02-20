<?php

namespace App\Controller;

use App\Entity\Events;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/events')]
final class ApiEventController extends AbstractController
{
    #[Route('', methods: ['GET'], name: 'listEvents')]
    public function list(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $events = $em->getRepository(Events::class)->findAll();

        $data = [];
        $month = $request->query->get('month');
        if ($month) {
            if ($month <= 0 || $month >= 13 || !is_numeric($month)) {
                return new JsonResponse(['status' => 'Introduce un mes correcto (01-12)'], 400);
            } else {
                foreach ($events as $event) {
                    if ($event->getDate()->format('m') == $month) {
                        $data[] = [
                            'title' => $event->getTitle(),
                            'date' => $event->getDate()->format('Y-m-d'),
                            'description' => $event->getDescription(),
                            'price' => $event->getPrice(),
                            'assistans' => $event->getAssistans(),
                        ];
                    }
                }
                if (count($data) === 0) {
                    return new JsonResponse(['status' => 'No hay eventos registrados ese mes'], 404);
                } else {
                    return new JsonResponse($data);
                }
            }
        } else {

            foreach ($events as $event) {
                $data[] = [
                    'title' => $event->getTitle(),
                    'date' => $event->getDate()->format('Y-m-d'),
                    'description' => $event->getDescription(),
                    'price' => $event->getPrice(),
                    'assistans' => $event->getAssistans(),
                ];
            }

            if (count($data) === 0) {
                return new JsonResponse(['status' => 'No hay eventos registrados'], 404);
            } else {
                return new JsonResponse($data);
            }
        }
    }
}
