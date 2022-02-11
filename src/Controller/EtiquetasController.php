<?php

namespace App\Controller;

use App\Entity\Etiqueta;
use App\Form\EtiquetaFormType;
use App\Repository\EtiquetaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class EtiquetasController extends AbstractController
{

    private $twig;
    private $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    #[Route('/etiquetas', name: 'etiquetas')]
    public function index(EtiquetaRepository $etiquetaRepository): Response
    {
        return new Response($this->twig->render('etiquetas/index.html.twig', [
            'etiquetas' => $etiquetaRepository->findAll(),
        ]));
    }

    #[Route('/etiquetas/create', name: 'etiquetaCreate')]
    public function new(Request $request, EtiquetaRepository $etiquetaRepository): Response
    {
        $etiqueta = new Etiqueta();
        $form = $this->createForm(EtiquetaFormType::class, $etiqueta);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($etiqueta);
            $this->entityManager->flush();

            return $this->redirectToRoute('etiquetas');
        }

        return new Response($this->twig->render('etiquetas/show.html.twig', [
            'etiquetas' => $etiquetaRepository->findAll(),
            'etiqueta' => $etiqueta,
            'etiqueta_form' => $form->createView(),
        ]));
    }

    #[Route('/etiquetas/{id}', name: 'etiqueta')]
    public function show(Request $request, Etiqueta $etiqueta, EtiquetaRepository $etiquetaRepository): Response
    {
    
        $form = $this->createForm(EtiquetaFormType::class, $etiqueta);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($etiqueta);
            $this->entityManager->flush();

            return $this->redirectToRoute('etiquetas');
        }

        return new Response($this->twig->render('etiquetas/show.html.twig', [
            'etiquetas' => $etiquetaRepository->findAll(),
            'etiqueta' => $etiqueta,
            'etiqueta_form' => $form->createView(),
        ]));
    }

    #[Route('/etiquetas/delete/{id}', name: 'etiquetaDelete')]
    public function delete(Request $request, Etiqueta $etiqueta, EtiquetaRepository $etiquetaRepository): Response
    {
        $this->entityManager->remove($etiqueta);
        $this->entityManager->flush();

        return $this->redirectToRoute('etiquetas');
        
    }
}
