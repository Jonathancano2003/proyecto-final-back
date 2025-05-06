<?php

namespace App\Controller;

use App\Entity\Transaccion;
use App\Repository\TransaccionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TransaccionController extends AbstractController
{
    #[Route('/create', name: 'app_transaccion_create', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $anuncio = $data['anuncio'] ?? null;
        $comprador = $data['comprador'] ?? null;
        $vendedor = $data['vendedor'] ?? null;
        $fechaVenta = $data['fecha_venta'] ?? null;

        if (is_null($anuncio) || is_null($comprador) || is_null($vendedor) || is_null($fechaVenta)) {
            return $this->json(['error' => 'Missing parameters'], Response::HTTP_BAD_REQUEST);
        }

        $transaccion = new Transaccion();
        $transaccion->setAnuncio($anuncio);
        $transaccion->setComprador($comprador);
        $transaccion->setVendedor((float)$vendedor);
        $transaccion->setFechaVenta(new \DateTime($fechaVenta));

        $entityManager->persist($transaccion);
        $entityManager->flush();

        return $this->json(['message' => 'Transaction created successfully'], Response::HTTP_CREATED);
    }
    #[Route('/transacciones', name: 'get_all_transacciones', methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $transaccionRepository = $entityManager->getRepository(Transaccion::class);
        $transacciones = $transaccionRepository->findAll();

        $transaccionesArray = array_map(function ($transaccion) {
            return [
                'id' => $transaccion->getId(),
                'anuncio' => $transaccion->getAnuncio(),
                'comprador' => $transaccion->getComprador(),
                'vendedor' => $transaccion->getVendedor(),
                'fecha_venta' => $transaccion->getFechaVenta()->format('Y-m-d H:i:s'),
            ];
        }, $transacciones);

        return $this->json($transaccionesArray, Response::HTTP_OK);
    }
    #[Route('/transaccion/{id}', name: 'app_transaccion_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
    $transaccion = $entityManager->getRepository(Transaccion::class)->find($id);

    if (!$transaccion) {
        return $this->json(['error' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
    }

    $entityManager->remove($transaccion);
    $entityManager->flush();

    return $this->json(['message' => 'Transaction removed successfully'], Response::HTTP_OK);
    }
    #[Route('/update', name: 'app_transaccion_update', methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager, TransaccionRepository $transaccionRepository): JsonResponse
    {
    $id = $request->query->get('id');
    $anuncio = $request->query->get('anuncio');
    $comprador = $request->query->get('comprador');
    $vendedor = $request->query->get('vendedor');
    $fechaVenta = $request->query->get('fecha_venta');

    if (is_null($id) || is_null($anuncio) || is_null($comprador) || is_null($vendedor) || is_null($fechaVenta)) {
        return $this->json(['message' => 'Missing parameters'], Response::HTTP_BAD_REQUEST);
    }

    $transaccion = $transaccionRepository->findOneBy(['id' => $id]);

    if ($transaccion) {
        $transaccion->setAnuncio($anuncio);
        $transaccion->setComprador($comprador);
        $transaccion->setVendedor($vendedor);
        $transaccion->setFechaVenta(new \DateTime($fechaVenta));

        $entityManager->flush();

        return $this->json(['message' => 'Transaction updated successfully'], Response::HTTP_OK);
    } else {
        return $this->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
    }
}
}
