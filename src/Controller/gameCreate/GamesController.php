<?php

namespace App\Controller\gameCreate;

use App\Entity\Chapter;
use App\Entity\Game;
use App\Entity\GameChapters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class GamesController extends AbstractController
{
    var $newGameUuid;
    var $createdGame;
    /**
     * @Route("/games/create", name="games_create" )
     */
    public function gamescreate()
    {
        try {
            $this->createNewGameService();
            $this->persistToRepository();
            $this->createGameCreationSuccessMessage();

            return $this->redirectToRoute('games_editor', [
                'gameUuid' => $this->newGameUuid]);
        } catch (\Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }
    }

    private function createNewGameService()
    {
        $this->createNewEntity();
        $this->setUuid();
    }
    private function createNewEntity()
    {
        $this->createdGame = new Game();
    }
    private function setUuid()
    {
        $this->newGameUuid = Uuid::v4();
        $this->createdGame->setUuid($this->newGameUuid);
    }
    private function persistToRepository()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->createdGame);
        $entity_manager->flush();
    }

    private function createGameCreationSuccessMessage()
    {
        $this->addFlash('success', 'Edite el nuevo juego');
    }

    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }

}

