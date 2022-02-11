<?php

namespace App\Controller;

use App\Entity\Lista;
use App\Repository\CheckboxRepository;
use App\Repository\ListaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ListasController extends AbstractController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    #[Route('/', name: 'homepage')]
    public function index(ListaRepository $listaRepository): Response
    {
        return new Response($this->twig->render('listas/index.html.twig', [
            'listas' => $listaRepository->findAll(),
        ]));
    }

    #[Route('/lista/{id}', name: 'lista')]
    public function show(Lista $lista, CheckboxRepository $checkboxRepository): Response
    {
        return new Response($this->twig->render('listas/show.html.twig', [
            'lista' => $lista,
            'checkboxes' => $checkboxRepository->findBy(['lista' => $lista]),
        ]));
    }
}
