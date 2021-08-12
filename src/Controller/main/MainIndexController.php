<?php

namespace App\Controller\main;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainIndexController extends AbstractController
{

    var $game;
    /**
     * @Route("/", name="main_index")
     */
    public function index()
    {
        try {
            $this->game = $this->findGame();

            return $this->render('main_index/index.html.twig', [
                'controller_name' => 'MainIndexController',
                'gameTitle' => $this->game->getTitle(),
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

    private function findGame()
    {
        return  $this->getDoctrine()
            ->getRepository(Game::class)
            ->findOneBy(['id' => Game::ID_MYPHPISLAND]);
    }
}
