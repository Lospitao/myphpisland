<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Entity\Game;
use App\Entity\GameChapters;
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
        //Create array where each kata title and uuid will be stored
        $gameChapters = [];

        //get game through uuid
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->findOneBy(['uuid' => $gameUuid]);
        $gameId = $game->getId();
        //get chapter collection related to game
        $gameChaptersInDB = $this->getDoctrine()
            ->getRepository(GameChapters::class)
            ->findBy(['game' => $gameId], ['position' => 'ASC']);

        //iteration inside game Chapters
        foreach($gameChaptersInDB as $gameChapterInDB) {
            //Get kata id
            $chapterId= $gameChapterInDB->getChapter();
            $chapterPosition = $gameChapterInDB->getPosition();
            //Get kata in
            $relevantChapter = $this->getDoctrine()
                ->getRepository(Chapter::class)
                ->findOneBy(['id' => $chapterId]);

            //get chapter title
            $gameChapterTitle = $relevantChapter->getTitle();
            //get chapter uuid
            $gameChapterUuid = $relevantChapter->getUuid();
            //Push both into the array previously created
            $gameChapters[$gameChapterUuid]= [
                'title' => $gameChapterTitle,
                'uuid' => $gameChapterUuid,
                'position' => $chapterPosition
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

        return $this->render('games_editor/index.html.twig', [
            'controller_name' => 'GamesEditorController',
            'gameUuid' => $gameUuid,
            'availableChapters' => $availableChapters,
            'chapterUuid' => $chapterUuid,
            'gameChapters' => $gameChapters,


        ]);
    }
}
