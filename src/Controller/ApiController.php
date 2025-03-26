<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/api/message', name: 'api_message', methods: ['GET'])]
    public function message(): JsonResponse
    {
        return $this->json(['message' => 'Hola desde Symfony']);
    }
}

