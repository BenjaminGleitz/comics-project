<?php

namespace App\Controller;

use App\Service\MarvelAPIPersonnageService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/character', name: 'character_')]
class CharacterController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(MarvelAPIPersonnageService $marvelAPIPersonnageService, Request $request, PaginatorInterface $paginator): Response
    {
        $results = $marvelAPIPersonnageService->getPersonnages();
        $charactersWithPhotos = array_filter($results['data']['results'], function($character) {
            return isset($character['thumbnail']['path']) && isset($character['thumbnail']['extension']) &&
                !str_ends_with($character['thumbnail']['path'], 'image_not_available');
        });

        $characters = $paginator->paginate(
            $charactersWithPhotos, // tableau contenant les données des personnages //
            $request->query->getInt('page', 1), // numéro de la page : par défaut page 1 //
            8 // nombre d'éléments par page : par défaut 6 //
        );

        return $this->render('character/index.html.twig', [
            'controller_name' => 'HomeController',
            'characters' => $characters,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, MarvelAPIPersonnageService $marvelAPIPersonnageService): Response
    {

        $results = $marvelAPIPersonnageService->getPersonnage($id);
        $character = $results['data']['results'][0];

        $comicsResults = $marvelAPIPersonnageService->getPersonnageComics($id);
        $comics = $comicsResults['data']['results'];

        return $this->render('character/show.html.twig', [
            'character' => $character,
            'comics' => $comics
        ]);
    }

}
