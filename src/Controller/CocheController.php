<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CocheController extends AbstractController
{
    #[Route('/coche', name: 'app_coche')]
    public function index(): Response
    {
        return $this->render('coche/index.html.twig', [
            'controller_name' => 'CocheController',
        ]);
    }
}
