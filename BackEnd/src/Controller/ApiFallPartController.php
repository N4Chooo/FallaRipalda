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
    #[Route('', methods: ['GET'], name: 'listAddEvents')]
    public function list(Request $request, EntityManagerInterface $em, FallasParticipantsRepository $fallasRepository , EventsRepository $events ): JsonResponse
    {
        $participantId = $request->query->get('PartId');
        $eventId = $request->query->get('EvenId');
        $event = '';
        $participant = '';
    if($participantId && $eventId){

        $event== $events->find($eventId);
        $participant== $fallasRepository->find($participantId);

        $events->addFallasParticipant($participant);
        $em->flush();

        return new JsonResponse(['status' => 'Fallero apuntado'], 200);

    }

    return new JsonResponse(['status' => 'Datos faltantes'], 404);

    }
}

