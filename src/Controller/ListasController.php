<?php

namespace App\Controller;

use App\Entity\Checkbox;
use App\Entity\Lista;
use App\Form\CheckboxFormType;
use App\Repository\CheckboxRepository;
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

    #[Route('/', name: 'homepage')]
    public function index(ListaRepository $listaRepository): Response
    {
        return new Response($this->twig->render('listas/index.html.twig', [
            'listas' => $listaRepository->findAll(),
        ]));
    }

    #[Route('/lista/{id}', name: 'lista')]
    public function show(Request $request, Lista $lista, ListaRepository $listaRepository, CheckboxRepository $checkboxRepository): Response
    {
        $checkbox = new Checkbox();
        $form = $this->createForm(CheckboxFormType::class, $checkbox);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $checkbox->setLista($lista);

            $this->entityManager->persist($checkbox);
            $this->entityManager->flush();

            return $this->redirectToRoute('lista', ['id' => $lista->getId()]);
        }

        return new Response($this->twig->render('listas/show.html.twig', [
            'listas' => $listaRepository->findAll(),
            'lista' => $lista,
            'checkboxes' => $checkboxRepository->findBy(['lista' => $lista]),
            'checkbox_form' => $form->createView(),
        ]));
    }
}
