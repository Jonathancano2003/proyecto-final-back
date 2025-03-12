<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/ads')]
final class AnuncioController extends AbstractController
{
    #[Route('/create', name: 'create_anuncio', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuarioId = $data['usuario_id'] ?? null;
        $cocheId = $data['coche_id'] ?? null;
        $estado = $data['estado'] ?? null;
        $descripcion = $data['descripcion'] ?? null;

        if (is_null($usuarioId) || is_null($cocheId) || is_null($estado) || is_null($descripcion)) {
            return $this->json(['error' => 'Missing parameters'], Response::HTTP_BAD_REQUEST);
        }

        $anuncio = new Anuncio();
        $anuncio->setUsuarioId($usuarioId);
        $anuncio->setCocheId($cocheId);
        $anuncio->setEstado($estado);
        $anuncio->setDescripcion($descripcion);
        $anuncio->setFechaPublicacion(new \DateTime());

        $entityManager->persist($anuncio);
        $entityManager->flush();

        return $this->json(['message' => 'Anuncio creado con éxito'], Response::HTTP_CREATED);
    }

    #[Route('/list', name: 'list_anuncios', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $anuncioRepository = $entityManager->getRepository(Anuncio::class);
        $anuncios = $anuncioRepository->findAll();

        $result = array_map(fn($anuncio) => [
            'id' => $anuncio->getId(),
            'usuario_id' => $anuncio->getUsuarioId(),
            'coche_id' => $anuncio->getCocheId(),
            'estado' => $anuncio->getEstado(),
            'descripcion' => $anuncio->getDescripcion(),
            'fecha_publicacion' => $anuncio->getFechaPublicacion()->format('Y-m-d H:i:s'),
        ], $anuncios);

        return $this->json($result, Response::HTTP_OK);
    }

    #[Route('/get/{id}', name: 'get_anuncio', methods: ['GET'])]
    public function getOne(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $anuncio = $entityManager->getRepository(Anuncio::class)->find($id);

        if (!$anuncio) {
            return $this->json(['error' => 'Anuncio no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $anuncio->getId(),
            'usuario_id' => $anuncio->getUsuarioId(),
            'coche_id' => $anuncio->getCocheId(),
            'estado' => $anuncio->getEstado(),
            'descripcion' => $anuncio->getDescripcion(),
            'fecha_publicacion' => $anuncio->getFechaPublicacion()->format('Y-m-d H:i:s'),
        ], Response::HTTP_OK);
    }

    #[Route('/update/{id}', name: 'update_anuncio', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $anuncio = $entityManager->getRepository(Anuncio::class)->find($id);

        if (!$anuncio) {
            return $this->json(['error' => 'Anuncio no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['estado'])) $anuncio->setEstado($data['estado']);
        if (isset($data['descripcion'])) $anuncio->setDescripcion($data['descripcion']);

        $entityManager->flush();

        return $this->json(['message' => 'Anuncio actualizado con éxito'], Response::HTTP_OK);
    }

    #[Route('/delete/{id}', name: 'delete_anuncio', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $anuncio = $entityManager->getRepository(Anuncio::class)->find($id);

        if (!$anuncio) {
            return $this->json(['error' => 'Anuncio no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($anuncio);
        $entityManager->flush();

        return $this->json(['message' => 'Anuncio eliminado con éxito'], Response::HTTP_OK);
    }
}