<?php
namespace App\Controller\api\v1\games;

use App\Entity\Chapter;
use App\Entity\Game;
use App\Entity\GameChapters;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddChapterToGameController extends abstractController
{
    /**
     * @Route("api/v1/games/{gameUuid}/chapters", methods={"POST"}, name="AddChapterToGameController")
     * @param Request $request
     * @param $gameUuid
     * @return JsonResponse
     */
    function AddChapterToGameController (Request $request, $gameUuid) {
        //get Chapter Uuid
        $chapterUuid = $request->request->get('chapterToBeAddedUuid');
        //get position of new chapter to be added
        $newChapterPosition = $request->request->get('positionOfNewGameChapter');
        //get chapter to be added
        $chapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid' => $chapterUuid]);
        //get Game to be updated
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->findOneBy(['uuid'=> $gameUuid]);
        //check if game exists
        if ($gameUuid) {
            //check if chapter exists
            if ($chapterUuid) {
                //Add Chapter to Game in relational table
                $newGameChapter = new GameChapters();
                $newGameChapter->setGame($game);
                $newGameChapter->setChapter($chapter);
                $newGameChapter->setPosition($newChapterPosition);
                //persist chapter to game (game-chapter table in DB)
                $entity_manager = $this->getDoctrine()->getManager();
                $entity_manager->persist($newGameChapter);
                $entity_manager->flush();

                //set response
                $response = new JsonResponse();
                $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
                return $response;
            }
            else {
                $response = new JsonResponse();
                $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
                return $response;

            }
        }
    }
}