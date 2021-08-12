<?php

namespace App\Controller\EndOfGame;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EndOfGameController extends AbstractController
{
    /**
     * @Route("/end/of/game", name="end_of_game")
     */
    public function index(): Response
    {
        return $this->render('end_of_game/index.html.twig', [
            'controller_name' => 'EndOfGameController',
            'apiHost' => $this->getParameter('api_host'),
        ]);
    }
}
