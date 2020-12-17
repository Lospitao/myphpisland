<?php

namespace App\Controller;

use App\Entity\Chapter;
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
     * @Route("/games/{gameUuid}", name="games")
     * @param $gameUuid
     */
    public function index($gameUuid)
    {
        //get game through $gameUuid
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->findOneBy(['uuid' => $gameUuid]);
        $gameTitle = $game->getTitle();

        //Create array where each kata title and uuid will be stored
        $gameChapters = [];

        //get game through uuid
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->findOneBy(['uuid' => $gameUuid]);

        //get kata collection related to lesson
        $gameChaptersInDB = $game->getChapter();

        //iteration inside game Chapters
        foreach($gameChaptersInDB as $gameChapterInDB) {
            //get chapter title
            $gameChapterTitle = $gameChapterInDB->getTitle();
            //get chapter uuid
            $gameChapterUuid = $gameChapterInDB->getUuid();
            //Push both into the array previously created
            $gameChapters[$gameChapterUuid]= [
                'title' => $gameChapterTitle,
                'uuid' => $gameChapterUuid,
            ];
        }
        /*Load available chapters as index is loaded*/
        //Create array to store available Chapters
        $availableChapters=[];
        //Find all available chapters
        $allChapters = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findAll();
        if ($gameUuid) {
            //Iterate all Chapters array
            foreach ($allChapters as $chapter) {
                //Get each Chapter title
                $chapterTitle = $chapter->getTitle();
                //Get each Chapter Uuid
                $chapterUuid = $chapter->getUuid();
                //exclude game Chapters
                if(!array_key_exists($chapterUuid, $gameChapters)) {
                    //Push title and uuid to available chapters array
                    $availableChapters[$chapterUuid] = [
                        'title' => $chapterTitle,
                        'uuid' => $chapterUuid,
                    ];
                }
            }
        }

        return $this->render('games/index.html.twig', [
            'controller_name' => 'GamesController',
            'gameUuid' => $gameUuid,
            'gameTitle' => $gameTitle,
            'availableChapters' => $availableChapters,
            'gameChapters' => $gameChapters,
            'chapterUuid' => $chapterUuid,
        ]);
    }
}

