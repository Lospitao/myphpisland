<?php

namespace App\Controller\main;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainIndexController extends AbstractController
{

    var $gameUuid;
    /**
     * @Route("/main/{gameTitle}", name="main_index")
     * @param $gameTitle
     */
    public function index($gameTitle)
    {
        try {
            $this->findGameUuid($gameTitle);

            return $this->render('main_index/index.html.twig', [
                'controller_name' => 'MainIndexController',
                'gameTitle' => $gameTitle,
                'gameUuid' => $this->gameUuid
            ]);
        } catch (\Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }
    }
    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }

    private function findGameUuid($gameTitle)
    {
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->findOneBy(['title' => $gameTitle]);
        $this->gameUuid = $game->getUuid();
    }
}
