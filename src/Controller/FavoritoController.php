<?php

namespace App\Controller;

use App\Entity\Favorito;
use App\Repository\FavoritoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/favoritos')]
class FavoritoController extends AbstractController
{
    private FavoritoRepository $favoritoRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(FavoritoRepository $favoritoRepository, EntityManagerInterface $entityManager)
    {
        $this->favoritoRepository = $favoritoRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', methods: ['POST'])]
    public function agregarFavorito(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['usuario'], $data['coche'])) {
            return $this->json(['error' => 'Datos incompletos'], Response::HTTP_BAD_REQUEST);
        }

        $favorito = new Favorito();
        $favorito->setUsuario($data['usuario']);
        $favorito->setCoche($data['coche']);
        $favorito->setFechaGuardado(new \DateTime());

        $this->entityManager->persist($favorito);
        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Favorito agregado'], Response::HTTP_CREATED);
    }

    #[Route('/', methods: ['GET'])]
    public function listarFavoritos(): JsonResponse
    {
        $favoritos = $this->favoritoRepository->findAll();
        return $this->json($favoritos, Response::HTTP_OK);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function obtenerFavorito(int $id): JsonResponse
    {
        $favorito = $this->favoritoRepository->find($id);

        if (!$favorito) {
            return $this->json(['error' => 'Favorito no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($favorito, Response::HTTP_OK);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function eliminarFavorito(int $id): JsonResponse
    {
        $favorito = $this->favoritoRepository->find($id);

        if (!$favorito) {
            return $this->json(['error' => 'Favorito no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($favorito);
        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Favorito eliminado'], Response::HTTP_OK);
    }
}
