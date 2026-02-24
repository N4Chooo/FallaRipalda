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
        $eventId = intval($data['EvenId']);
        $participantId = intval($data['PartId']);
    if(isset($participantId) && isset($eventId)){

        $event = $eventRepo->find($eventId);
        $participant= $fallasRepository->find($participantId);

        $event->addFallasParticipant($participant);
        $em->flush();

        return new JsonResponse(['status' => 'Fallero apuntado'], 200);

    }else {

        return new JsonResponse(['status' => 'Datos faltantes'], 400);
    }

    }
}

