<?php

namespace App\Controller;

use App\Entity\Coche;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/cars')]
final class CocheController extends AbstractController
{
    #[Route('/create', name: 'create_coche', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $coche = new Coche();
        $coche->setMarca($data['marca'] ?? '');
        $coche->setModelo($data['modelo'] ?? '');
        $coche->setAño($data['año'] ?? 0);
        $coche->setKilometraje($data['kilometraje'] ?? 0);
        $coche->setImagen($data['imagen'] ?? null);
        $coche->setDescripcion($data['descripcion'] ?? null);

        $entityManager->persist($coche);
        $entityManager->flush();

        return $this->json(['message' => 'Coche creado con éxito'], Response::HTTP_CREATED);
    }

    #[Route('/list', name: 'list_coches', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $coches = $entityManager->getRepository(Coche::class)->findAll();

        $result = array_map(fn($coche) => [
            'id' => $coche->getId(),
            'marca' => $coche->getMarca(),
            'modelo' => $coche->getModelo(),
            'año' => $coche->getAño(),
            'kilometraje' => $coche->getKilometraje(),
            'imagen' => $coche->getImagen(),
            'descripcion' => $coche->getDescripcion(),
        ], $coches);

        return $this->json($result, Response::HTTP_OK);
    }

    #[Route('/get/{id}', name: 'get_coche', methods: ['GET'])]
    public function getOne(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $coche = $entityManager->getRepository(Coche::class)->find($id);

        if (!$coche) {
            return $this->json(['error' => 'Coche no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $coche->getId(),
            'marca' => $coche->getMarca(),
            'modelo' => $coche->getModelo(),
            'año' => $coche->getAño(),
            'kilometraje' => $coche->getKilometraje(),
            'imagen' => $coche->getImagen(),
            'descripcion' => $coche->getDescripcion(),
        ], Response::HTTP_OK);
    }

    #[Route('/update/{id}', name: 'update_coche', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $coche = $entityManager->getRepository(Coche::class)->find($id);

        if (!$coche) {
            return $this->json(['error' => 'Coche no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['marca'])) $coche->setMarca($data['marca']);
        if (isset($data['modelo'])) $coche->setModelo($data['modelo']);
        if (isset($data['año'])) $coche->setAño($data['año']);
        if (isset($data['kilometraje'])) $coche->setKilometraje($data['kilometraje']);
        if (isset($data['imagen'])) $coche->setImagen($data['imagen']);
        if (isset($data['descripcion'])) $coche->setDescripcion($data['descripcion']);

        $entityManager->flush();

        return $this->json(['message' => 'Coche actualizado con éxito'], Response::HTTP_OK);
    }

    #[Route('/delete/{id}', name: 'delete_coche', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $coche = $entityManager->getRepository(Coche::class)->find($id);

        if (!$coche) {
            return $this->json(['error' => 'Coche no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($coche);
        $entityManager->flush();

        return $this->json(['message' => 'Coche eliminado con éxito'], Response::HTTP_OK);
    }
}
