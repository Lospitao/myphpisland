<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GamesEditorController extends AbstractController
{
    /**
     * @Route("/games/{gameUuid}/editor", name="games_editor")
     * @param $gameUuid
     */
    public function index($gameUuid)
    {
        return $this->render('games_editor/index.html.twig', [
            'controller_name' => 'GamesEditorController',
            'gameUuid' => $gameUuid,
        ]);
    }
}
