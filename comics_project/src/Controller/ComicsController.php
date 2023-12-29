<?php

namespace App\Controller;

use App\Service\MarvelAPIPersonnageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comics', name: 'comics_')]
class ComicsController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(MarvelAPIPersonnageService $marvelAPIPersonnageService, PaginatorInterface $paginator): Response
    {

        return $this->render('comics/index.html.twig');
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, MarvelAPIPersonnageService $marvelAPIPersonnageService): Response
    {

        $results = $marvelAPIPersonnageService->getComic($id);
        $comic = $results['data']['results'][0];

        return $this->render('comics/show.html.twig', [
            'page_active' => 'comic',
            'comic' => $comic
        ]);
    }

}