<?php

namespace App\Controller;

use App\Entity\Lista;
use App\Form\ListaFormType;
use App\Repository\ListaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ListasController extends AbstractController
{
    private $twig;
    private $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    #[Route('/listas', name: 'listas')]
    public function index(ListaRepository $listaRepository): Response
    {
        return new Response($this->twig->render('listas/index.html.twig', [
            'listas' => $listaRepository->findAll(),
        ]));
    }

    #[Route('/listas/create', name: 'listaCreate')]
    public function new(Request $request, ListaRepository $listaRepository): Response
    {
        $lista = new Lista();
        $form = $this->createForm(ListaFormType::class, $lista);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($lista);
            $this->entityManager->flush();

            return $this->redirectToRoute('listas');
        }

        return new Response($this->twig->render('listas/show.html.twig', [
            'listas' => $listaRepository->findAll(),
            'lista' => $lista,
            'list_form' => $form->createView(),
        ]));
    }

    #[Route('/listas/{id}', name: 'lista')]
    public function show(Request $request, Lista $lista, ListaRepository $listaRepository): Response
    {
    
        $form = $this->createForm(ListaFormType::class, $lista);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($lista);
            $this->entityManager->flush();

            return $this->redirectToRoute('listas');
        }

        return new Response($this->twig->render('listas/show.html.twig', [
            'listas' => $listaRepository->findAll(),
            'lista' => $lista,
            'list_form' => $form->createView(),
        ]));
    }

    #[Route('/listas/delete/{id}', name: 'listaDelete')]
    public function delete(Request $request, Lista $lista, ListaRepository $listaRepository): Response
    {
        $this->entityManager->remove($lista);
        $this->entityManager->flush();

        return $this->redirectToRoute('listas');
        
    }
}
