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
        $characters = $paginator->paginate(
            $results['data']['results'], // tableau contenant les données des personnages //
            $request->query->getInt('page', 1), // numéro de la page : par défaut page 1 //
            6 // nombre d'éléments par page : par défaut 6 //
        );


        return $this->render('character/index.html.twig', [
            'controller_name' => 'HomeController',
            'characters' => $characters,
        ]);
    }
}