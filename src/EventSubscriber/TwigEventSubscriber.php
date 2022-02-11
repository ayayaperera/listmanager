<?php

namespace App\EventSubscriber;

use App\Repository\ListaRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $listaRepository;

    public function __construct(Environment $twig, ListaRepository $listaRepository)
    {
        $this->twig = $twig;
        $this->listaRepository = $listaRepository;
    }

    public function onControllerEvent(ControllerEvent $event)
    {
        $this->twig->addGlobal('listas', $this->listaRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        //'\Component\HttpKernel\Event\ControllerEvent' => 'on\Component\HttpKernel\Event\ControllerEvent',
        return [
            'ControllerEvent' => 'onControllerEvent',
        ];
    }
}
