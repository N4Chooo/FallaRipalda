<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/participate')]
final class ApiFallPartController extends AbstractController
{
    #[Route('', methods: ['GET'], name: 'listAddEvents')]
    public function list(Request $request, EntityManagerInterface $em, FallasParticipantsRepository $fallasRepository , EventsRepository $events ): JsonResponse
    {
        $participantId = $request->query->get('PartId');
        $eventId = $request->query->get('EvenId');
    if($participantId && $eventId){

        $event== $events->find($eventId);
        $participant== $fallasRepository->find($participantId);
       
        $events->addFallasParticipant($participant);

        return new JsonResponse(['status' => 'Fallero apuntado'], 200);

    }
        
    return new JsonResponse(['status' => 'Datos faltantes'], 404);
            
    }
}

