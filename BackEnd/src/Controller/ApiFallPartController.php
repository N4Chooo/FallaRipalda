<?php

namespace App\Controller;

use App\Repository\FallasParticipantsRepository;
use App\Repository\EventsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/participate')]
final class ApiFallPartController extends AbstractController
{
    #[Route('', methods: ['POST'], name: 'listAddEvents')]
    public function list(Request $request, EntityManagerInterface $em, FallasParticipantsRepository $fallasRepository , EventsRepository $eventRepo ): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        if (!isset($data['EvenId']) || !isset($data['PartId'])) {
            return new JsonResponse(['status' => 'Faltan llaves EvenId o PartId'], 400);
        }

        $eventId = intval($data['EvenId']);
        $participantId = intval($data['PartId']);

        if ($eventId > 0 && $participantId > 0) {
            $event = $eventRepo->find($eventId);
            $participant = $fallasRepository->find($participantId);

            if ($event && $participant) {
                $event->addFallasParticipant($participant);
                $em->flush();
                return new JsonResponse(['status' => 'Fallero apuntado'], 200);
            }
            return new JsonResponse(['status' => 'No se encontró el evento o fallero en BD'], 404);
        }

        return new JsonResponse(['status' => 'IDs inválidos'], 400);

    }
}

