<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AnuncioController extends AbstractController
{
    #[Route('/anuncio', name: 'app_anuncio')]
    public function index(): Response
    {
        return $this->render('anuncio/index.html.twig', [
            'controller_name' => 'AnuncioController',
        ]);
    }
}
