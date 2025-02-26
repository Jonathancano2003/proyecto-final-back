<?php

namespace App\Controller;

use App\Entity\Transaccion;
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
}
