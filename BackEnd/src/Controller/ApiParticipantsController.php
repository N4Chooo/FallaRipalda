<?php

namespace App\Controller;

use App\Entity\FallasParticipants;
use App\Repository\FallasParticipantsRepository;
use App\Repository\FeesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/participants')]
final class ApiParticipantsController extends AbstractController
{
    #[Route('', methods: ['GET'], name: 'listParticipants')]
    public function list(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $dni = $request->query->get('dni');
        $status = $request->query->get('status');
        $rol = $request->query->get('rol');
        $category = $request->query->get('category');
        $data = [];

        $participants = $em->getRepository(FallasParticipants::class)->findAll();
        if ($dni || $status || $rol || $category) {
            foreach ($participants as $participant) {
                if ($dni) {
                    if ($participant->getDni() == $dni) {
                        $eventosNombres = [];
                        foreach ($participant->getEvent() as $event) {
                            $eventosNombres[] = $event->getTitle();
                            $id[] = $event->getId();
                        }
                        $data[] = [
                            'id' => $participant->getId(),
                            'name' => $participant->getName(),
                            'category' => $participant->getCategory(),
                            'rewards' => $participant->getRewards(),
                            'payment_status' => $participant->isPaymentStatus(),
                            'rol' => $participant->getRol(),
                            'dni' => $participant->getDni(),
                            'fee' => $participant->getFee()->getType(),
                            'event' => $eventosNombres,
                            'eventId' => $id,
                        ];
                    }
                }
                if ($status) {
                    if ($status == 'pendiente') {
                        $stat = false;
                    } elseif ($status == 'pagado') {
                        $stat = true;
                    }
                    if ($participant->isPaymentStatus() == $stat) {
                        $data[] = [
                            'id' => $participant->getId(),
                            'name' => $participant->getName(),
                            'category' => $participant->getCategory(),
                            'rewards' => $participant->getRewards(),
                            'payment_status' => $participant->isPaymentStatus(),
                            'rol' => $participant->getRol(),
                            'dni' => $participant->getDni(),
                            'fee' => $participant->getFee()->getType(),
                        ];
                    }
                }
                if ($rol) {
                    if ($participant->getRol() == $rol) {
                        $data[] = [
                            'id' => $participant->getId(),
                            'name' => $participant->getName(),
                            'category' => $participant->getCategory(),
                            'rewards' => $participant->getRewards(),
                            'payment_status' => $participant->isPaymentStatus(),
                            'rol' => $participant->getRol(),
                            'dni' => $participant->getDni(),
                            'fee' => $participant->getFee()->getType(),
                        ];
                    }
                }
                if ($category) {
                    if ($participant->getCategory() == $category) {
                        $data[] = [
                            'id' => $participant->getId(),
                            'name' => $participant->getName(),
                            'category' => $participant->getCategory(),
                            'rewards' => $participant->getRewards(),
                            'payment_status' => $participant->isPaymentStatus(),
                            'rol' => $participant->getRol(),
                            'dni' => $participant->getDni(),
                            'fee' => $participant->getFee()->getType(),
                        ];
                    }
                }
            }
            if (count($data) === 0) {
                return new JsonResponse(['status' => 'No se han encontado falleros con los criterios de busqueda'], 404);
            } else {
                return new JsonResponse($data);
            }
        } else {

            foreach ($participants as $participant) {
                $eventosNombres = [];
                foreach ($participant->getEvent() as $event) {
                    $eventosNombres[] = $event->getTitle();
                }

                $data[] = [
                    'id' => $participant->getId(),
                    'name' => $participant->getName(),
                    'category' => $participant->getCategory(),
                    'rewards' => $participant->getRewards(),
                    'payment_status' => $participant->isPaymentStatus(),
                    'rol' => $participant->getRol(),
                    'dni' => $participant->getDni(),
                    'fee' => $participant->getFee()->getType(),
                    'event' => $eventosNombres,
                ];
            }

            if (count($data) === 0) {
                return new JsonResponse(['status' => 'No hay falleros registrados'], 404);
            } else {
                return new JsonResponse($data);
            }
        }
    }

    #[Route('/create', name: 'create_participants', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FeesRepository $feesRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $participant = new FallasParticipants();
        $participant->setName($data['name']);
        $participant->setCategory($data['category']);
        $participant->setRewards($data['reward']);
        if ($data['payment'] == '0') {
            $status = false;
        } else {
            $status = true;
        }
        if ($data['fee'] == '0') {
            $fees = 1;
        } elseif ($data['fee'] == '1') {
            $fees = 2;
        } elseif ($data['fee'] == '2') {
            $fees = 3;
        } elseif ($data['fee'] == '3') {
            $fees = 4;
        } elseif ($data['fee'] == '4') {
            $fees = 5;
        } elseif ($data['fee'] == '5') {
            $fees = 6;
        } elseif ($data['fee'] == '6') {
            $fees = 7;
        } elseif ($data['fee'] == '7') {
            $fees = 8;
        } elseif ($data['fee'] == '8') {
            $fees = 9;
        } elseif ($data['fee'] == '9') {
            $fees = 10;
        }

        $participant->setPaymentStatus($status);
        $participant->setRol($data['rol']);
        $fee = $feesRepository->find($fees);
        $participant->setFee($fee);
        $participant->setDni($data['dni']);
        $entityManager->persist($participant);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Fallero creado correctamente'], 201);

    }


    #[Route('/edit', name: 'edit_participants', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, FeesRepository $feesRepository, FallasParticipantsRepository $fallasRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if ($data['id']) {
            $falleroId = intval($data['id']);
        }

        $participant = $fallasRepository->find($falleroId);
        if (isset($data['name'])) {
            $participant->setName($data['name']);
        }
        if (isset($data['category'])) {
            $participant->setCategory($data['category']);
        }
        if (isset($data['reward'])) {
            $participant->setRewards($data['reward']);
        }
        if (isset($data['payment'])) {
            if ($data['payment'] == '0') {
                $status = false;
            } elseif ($data['payment'] == '1') {
                $status = true;
            }
        }
        if (isset($data['fee'])) {
            if ($data['fee'] == '0') {
                $fees = 1;
            } elseif ($data['fee'] == '1') {
                $fees = 2;
            } elseif ($data['fee'] == '2') {
                $fees = 3;
            } elseif ($data['fee'] == '3') {
                $fees = 4;
            } elseif ($data['fee'] == '4') {
                $fees = 5;
            } elseif ($data['fee'] == '5') {
                $fees = 6;
            } elseif ($data['fee'] == '6') {
                $fees = 7;
            } elseif ($data['fee'] == '7') {
                $fees = 8;
            } elseif ($data['fee'] == '8') {
                $fees = 9;
            } elseif ($data['fee'] == '9') {
                $fees = 10;
            }
        }
        if (isset($status)) {
            $participant->setPaymentStatus($status);
        }
        if (isset($data['rol'])) {
            $participant->setRol($data['rol']);
        }
        if (isset($data['fee'])) {
            $fee = $feesRepository->find($fees);
            $participant->setFee($fee);
        }
        if (isset($data['dni'])) {
            $participant->setDni($data['dni']);
        }
        $entityManager->persist($participant);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Fallero actualizado correctamente'], 201);

    }

    #[Route('/delete', name: 'delete_participants', methods: ['POST'])]
    public function delete(Request $request, FallasParticipantsRepository $fallasRepo, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $falleroId = intval($data['id']);
        $fallero = $fallasRepo->find($falleroId);
        $user = $userRepository->findOneBy(['dni' => $fallero->getDni()]);

        $entityManager->remove($fallero);
        if ($user) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        $entityManager->flush();

        return new JsonResponse(['status' => 'Fallero borrado correctamente'], 202);
    }
}
