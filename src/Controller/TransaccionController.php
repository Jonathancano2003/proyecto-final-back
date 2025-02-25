<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TransaccionController extends AbstractController
{
    #[Route('/transaccion', name: 'app_transaccion')]
    public function index(): Response
    {
        return $this->render('transaccion/index.html.twig', [
            'controller_name' => 'TransaccionController',
        ]);
    }
}
