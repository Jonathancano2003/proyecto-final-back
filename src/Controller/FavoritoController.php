<?php

namespace App\Controller;

use App\Entity\Favorito;
use App\Repository\FavoritoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/favoritos')]
class FavoritoController extends AbstractController
{
    private FavoritoRepository $favoritoRepository;

    public function __construct(FavoritoRepository $favoritoRepository)
    {
        $this->favoritoRepository = $favoritoRepository;
    }

    #[Route('', methods: ['POST'])]
    public function agregarFavorito(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['usuario'], $data['coche'])) {
            return $this->json(['error' => 'Datos incompletos'], 400);
        }

        $favorito = new Favorito();
        $favorito->setUsuario($data['usuario']);
        $favorito->setCoche($data['coche']);
        $favorito->setFechaGuardado(new \DateTime());

        $this->favoritoRepository->agregarFavorito($favorito);

        return $this->json(['mensaje' => 'Favorito agregado'], 201);
    }

    #[Route('', methods: ['GET'])]
    public function listarFavoritos(): JsonResponse
    {
        $favoritos = $this->favoritoRepository->listarFavoritos();
        return $this->json($favoritos);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function obtenerFavorito(int $id): JsonResponse
    {
        $favorito = $this->favoritoRepository->obtenerFavorito($id);

        if (!$favorito) {
            return $this->json(['error' => 'Favorito no encontrado'], 404);
        }

        return $this->json($favorito);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function eliminarFavorito(int $id): JsonResponse
    {
        $favorito = $this->favoritoRepository->obtenerFavorito($id);

        if (!$favorito) {
            return $this->json(['error' => 'Favorito no encontrado'], 404);
        }

        $this->favoritoRepository->eliminarFavorito($favorito);

        return $this->json(['mensaje' => 'Favorito eliminado']);
    }
}
