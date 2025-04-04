<?php

namespace App\Controller;

use App\Entity\Coche;
use App\Repository\CocheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/coches')]
class CocheController extends AbstractController
{
    private CocheRepository $cocheRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(CocheRepository $cocheRepository, EntityManagerInterface $entityManager)
    {
        $this->cocheRepository = $cocheRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('', methods: ['GET'])]
    public function listarCoches(): JsonResponse
    {
        return $this->json($this->cocheRepository->findAll());
    }

    #[Route('/{id}', methods: ['GET'])]
    public function obtenerCoche(int $id): JsonResponse
    {
        $coche = $this->cocheRepository->find($id);
        return $coche ? $this->json($coche) : $this->json(['error' => 'Coche no encontrado'], 404);
    }
}
