<?php

namespace App\Controller;

use App\Entity\Anuncio;
use App\Repository\AnuncioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/anuncios')]
class AnuncioController extends AbstractController
{
    private AnuncioRepository $anuncioRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(AnuncioRepository $anuncioRepository, EntityManagerInterface $entityManager)
    {
        $this->anuncioRepository = $anuncioRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('', methods: ['GET'])]
    public function listarAnuncios(): JsonResponse
    {
        return $this->json($this->anuncioRepository->findAll());
    }

    #[Route('/{id}', methods: ['GET'])]
    public function obtenerAnuncio(int $id): JsonResponse
    {
        $anuncio = $this->anuncioRepository->find($id);
        return $anuncio ? $this->json($anuncio) : $this->json(['error' => 'Anuncio no encontrado'], 404);
    }
}
