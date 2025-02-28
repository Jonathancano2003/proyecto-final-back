<?php

namespace App\Controller;

use App\Entity\Favorito;
use App\Repository\FavoritoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/favorites')]
class FavoritoController extends AbstractController
{
    private $entityManager;
    private $favoritoRepository;

    public function __construct(EntityManagerInterface $entityManager, FavoritoRepository $favoritoRepository)
    {
        $this->entityManager = $entityManager;
        $this->favoritoRepository = $favoritoRepository;
    }

    #[Route('', methods: ['GET'])]
    public function listarFavoritos(): JsonResponse
    {
        $favoritos = $this->favoritoRepository->findAll();
        return $this->json($favoritos);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function obtenerFavorito(int $id): JsonResponse
    {
        $favorito = $this->favoritoRepository->find($id);
        if (!$favorito) {
            return $this->json(['error' => 'Favorito no encontrado'], 404);
        }
        return $this->json($favorito);
    }

    #[Route('', methods: ['POST'])]
    public function agregarFavorito(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['usuario_id'], $data['anuncio_id'])) {
            return $this->json(['error' => 'Datos incompletos'], 400);
        }

        $favorito = new Favorito();
        $favorito->setUsuarioId($data['usuario_id']);
        $favorito->setAnuncioId($data['anuncio_id']);

        $this->favoritoRepository->agregarFavorito($favorito);

        return $this->json($favorito, 201);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function eliminarFavorito(int $id): JsonResponse
    {
        $favorito = $this->favoritoRepository->find($id);
        if (!$favorito) {
            return $this->json(['error' => 'Favorito no encontrado'], 404);
        }

        $this->favoritoRepository->eliminarFavorito($favorito);

        return $this->json(['message' => 'Favorito eliminado']);
    }
}
