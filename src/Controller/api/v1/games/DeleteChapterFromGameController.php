<?php

namespace App\Controller\api\v1\games;

use App\Entity\Chapter;
use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

Class DeleteChapterFromGameController extends AbstractController
{
    /**
     * @Route("api/v1/games/{gameUuid}/chapters/{chapterToBeRemovedUuid}", name="DeleteChapterFromGameController")
     * @param $gameUuid,
     * @param $chapterToBeRemovedUuid
     * @return JsonResponse
     */
    function DeleteChapterFromGameController (Request $request, $gameUuid, $chapterToBeRemovedUuid)
    {
        //get chapter uuid
        $chapterToBeRemovedUuid = $request->request->get('chapterToBeRemovedUuid');
        //ger chapter to be added
        $chapterToBeRemoved= $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid' => $chapterToBeRemovedUuid]);
        //get game to be updated
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->findOneBy(['uuid' =>$gameUuid]);
        //check if game exists
        if($game) {
            //check if chapter exists
            if($chapterToBeRemoved) {
                $game->removeChapter($chapterToBeRemoved);
                //remove kata from lesson in DB
                $entity_manager = $this->getDoctrine()->getManager();
                $entity_manager->persist($game);
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