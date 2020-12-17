<?php

namespace App\Controller\api\v1\games;



use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Class GameTitleUpdateController extends AbstractController
{
    /**
     * @Route("api/v1/games/{gameUuid}", name="GameTitleUpdateController")
     * @param $gameUuid
     * @return JsonResponse
     */
    function GameUpdateController(Request $request, $gameUuid)
    {
        //select game to be updated with uuid granted
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->findOneBy(['uuid' => $gameUuid]);
        //get value of title textarea
        $title = $request->request->get('title');
        //if there is a lesson created with an uuid
        if ($gameUuid) {
            //if title is not null
            if ($title) {
                //set title into Database
                $game->setTitle($title);
            }
            else  throw $this->createNotFoundException('Debe introducir un título');
        }

        $entity_manager = $this->getDoctrine()->getManager();

        $entity_manager->persist($game);
        $entity_manager->flush();

        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;

    }
}