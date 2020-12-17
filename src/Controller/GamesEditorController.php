<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Entity\Game;
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

        return $this->render('games_editor/index.html.twig', [
            'controller_name' => 'GamesEditorController',
            'gameUuid' => $gameUuid,
            'availableChapters' => $availableChapters,
            'chapterUuid' => $chapterUuid,
            'gameChapters' => $gameChapters,


        ]);
    }
}
