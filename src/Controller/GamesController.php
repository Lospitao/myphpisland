<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class GamesController extends AbstractController
{
    /**
     * @Route("/games/create", name="games_create" )
     */
    public function gamescreate()
    {
        $game = new Game();
        $gameUuid = Uuid::v4();
        $game->setUuid($gameUuid);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($game);
        $entity_manager->flush();

        return $this->redirectToRoute('games_editor', [
            'gameUuid' => $gameUuid]);
    }
    /**
     * @Route("/games", name="games")
     * @param $gameUuid
     */
    public function index($gameUuid)
    {
        return $this->render('games/index.html.twig', [
            'controller_name' => 'GamesController',
        ]);
    }
}
