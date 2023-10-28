<?php

namespace App\Controller;

use App\Service\MarvelAPIPersonnageService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        MarvelAPIPersonnageService $marvelAPIPersonnageService,
        Request $request

    ): Response
    {

        $results = $marvelAPIPersonnageService->getPersonnages();
        $characters = $results['data']['results'];

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'characters' => $characters,
        ]);
    }
}
