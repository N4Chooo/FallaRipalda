<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/books')]
final class ApiBookController extends AbstractController
{
    #[Route('', methods: ['GET'], name: 'listBooks')]
    public function list(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $books = $em->getRepository(Book::class)->findAll();

        $data = [];
        $year = $request->query->get('year');

        if ($year) {
            if ($year <= 1999 || !is_numeric($year)) {
                return new JsonResponse(['status' => 'Introduce un año correcto'], 400);
            } else {
                foreach ($books as $book) {
                    if ($book->getYear()->format('Y') == $year) {
                        $data[] = [
                            'title' => $book->getTitle(),
                            'year' => $book->getYear()->format('Y'),
                            'photo' => $book->getPhoto(),
                            'url' => $book->getUrl(),
                        ];
                    }
                }
                if (count($data) === 0) {
                    return new JsonResponse(['status' => 'No hay llibrets registrados en ese año'], 404);
                } else {
                    return new JsonResponse($data);
                }
            }
        } else {

            foreach ($books as $book) {
                $data[] = [
                    'title' => $book->getTitle(),
                    'year' => $book->getYear()->format('Y'),
                    'photo' => $book->getPhoto(),
                    'url' => $book->getUrl(),
                ];
            }

            if (count($data) === 0) {
                return new JsonResponse(['status' => 'No hay llibrets registrados'], 404);
            } else {
                return new JsonResponse($data);
            }
        }
    }
}

