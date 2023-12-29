<?php

namespace App\Controller;

use App\Service\MarvelAPIPersonnageService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        MarvelAPIPersonnageService $marvelAPIPersonnageService, Request $request, PaginatorInterface $paginator): Response
    {

        $results = $marvelAPIPersonnageService->getPersonnages();
        $charactersWithPhotos = array_filter($results['data']['results'], function($character) {
            return isset($character['thumbnail']['path']) && isset($character['thumbnail']['extension']) &&
                !str_ends_with($character['thumbnail']['path'], 'image_not_available');
        });

        return $this->render('home/index.html.twig', [
            'page_active' => 'home',
            'controller_name' => 'HomeController',
            'characters' => $charactersWithPhotos,
        ]);
    }
}
