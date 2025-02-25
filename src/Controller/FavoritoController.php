<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FavoritoController extends AbstractController
{
    #[Route('/favorito', name: 'app_favorito')]
    public function index(): Response
    {
        return $this->render('favorito/index.html.twig', [
            'controller_name' => 'FavoritoController',
        ]);
    }
}
