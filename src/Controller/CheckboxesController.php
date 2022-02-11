<?php

namespace App\Controller;

use App\Entity\Checkbox;
use App\Form\CheckboxFormType;
use App\Repository\CheckboxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CheckboxesController extends AbstractController
{

    private $twig;
    private $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    #[Route('/checkboxes', name: 'checkboxes')]
    public function index(CheckboxRepository $checkboxRepository): Response
    {
        return new Response($this->twig->render('checkboxes/index.html.twig', [
            'checkboxes' => $checkboxRepository->findAll(),
        ]));
    }

    #[Route('/checkboxes/create', name: 'checkboxCreate')]
    public function new(Request $request, CheckboxRepository $checkboxRepository): Response
    {
        $checkbox = new Checkbox();
        $form = $this->createForm(CheckboxFormType::class, $checkbox);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($checkbox);
            $this->entityManager->flush();

            return $this->redirectToRoute('checkboxes');
        }

        return new Response($this->twig->render('checkboxes/show.html.twig', [
            'checkboxes' => $checkboxRepository->findAll(),
            'checkbox' => $checkbox,
            'checkbox_form' => $form->createView(),
        ]));
    }

    #[Route('/checkboxes/{id}', name: 'checkbox')]
    public function show(Request $request, Checkbox $checkbox, CheckboxRepository $checkboxRepository): Response
    {
    
        $form = $this->createForm(CheckboxFormType::class, $checkbox);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($checkbox);
            $this->entityManager->flush();

            return $this->redirectToRoute('checkboxes');
        }

        return new Response($this->twig->render('checkboxes/show.html.twig', [
            'checkboxes' => $checkboxRepository->findAll(),
            'checkbox' => $checkbox,
            'checkbox_form' => $form->createView(),
        ]));
    }

    #[Route('/checkboxes/delete/{id}', name: 'checkboxDelete')]
    public function delete(Request $request, Checkbox $checkbox, CheckboxRepository $checkboxRepository): Response
    {
        $this->entityManager->remove($checkbox);
        $this->entityManager->flush();

        return $this->redirectToRoute('checkboxes');
        
    }
}
