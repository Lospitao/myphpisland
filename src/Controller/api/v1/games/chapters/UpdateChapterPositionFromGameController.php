<?php

namespace App\Controller\api\v1\games\chapters;

use App\Entity\Game;
use App\Entity\Chapter;
use App\Entity\GameChapters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateChapterPositionFromGameController extends AbstractController{

    /**
     * @Route("api/v1/games/{gameUuid}/chapters/{chapter_uuid}", methods={"PATCH"}, name="UpdateChapterPositionFromGameController")
     * @param Request $request
     * @param $gameUuid
     * @param $chapter_uuid
     */
    function UpdateChapterPositionFromGameController (Request $request, $gameUuid, $chapter_uuid) {
        $newChapterPosition = $request->request->get('position');
        //get chapter id
        $chapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid'=> $chapter_uuid]);
        $chapterId = $chapter ->getId();
        // get game id
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->findOneBy(['uuid'=> $gameUuid]);
        $gameId = $game->getId();
        //get entry of GameChapters Entity to be updated
        $entryToUpdate= $this->getDoctrine()
            ->getRepository(GameChapters::class)
            ->findOneBy(['game' => $gameId, 'chapter' => $chapterId ]);
        if (!$entryToUpdate) {
            $response = new JsonResponse();
            $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
            return $response;
        }
        //Update position
        $entryToUpdate->setPosition($newChapterPosition);
        //persist chapter to game (chapter-game table in DB)
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($entryToUpdate);
        $entity_manager->flush();
        //set response
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
}
