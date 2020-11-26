<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChaptersEditorController extends AbstractController
{
    /**
     * @Route("/chapters/{chapterUuid}/editor", name="chapters_editor")
     * @param $chapterUuid
     */
    public function index($chapterUuid)
    {
        //Create array to store chapter stages
        $chapterStagesArray=[];
        //Create array to store chapter lessons
        $chapterLessonsArray=[];


        /*Load Available Stages*/
        //Create array to store available Stages
        $availableStages = [];
        //Load Available stages as index is loaded
        $stagesArray = $this->getDoctrine()
            ->getRepository(Stage::class)
            ->findAll();
        //Iteration inside stagesarray
        foreach($stagesArray as $stage) {
            //Get stage title
            $stageTitle = $stage->getTitle();
            //Get stage uuid
            $stageUuid = $stage->getUuid();
            //If stage is inside of lesson katas, remove it from availableKatas
            if (!array_key_exists($stageUuid, $chapterStagesArray)) {
                //Push title and uuid of stage into availableStages
                $availableStages[$stageUuid] = [
                    'stageTitle' => $stageTitle,
                    'stageUuid' => $stageUuid,
                ];
            }
        }
        /*Load available Lessons*/
        //Create array to store available Lessons
        $availableLessons = [];
        //Load Available lessons as index is loaded
        $lessonsArray = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findAll();

        //Iteration inside lessonsArray
        foreach($lessonsArray as $lesson) {
            //Get lesson  title
            $lessonTitle = $lesson->getTitle();
            //Get lesson uuid
            $lessonUuid = $lesson->getUuid();
            //If stage is inside of lesson katas, remove it from availableKatas
            if (!array_key_exists($lessonUuid, $chapterLessonsArray)) {
                //Push title and uuid of stage into availableStages
                $availableLessons[$lessonUuid] = [
                    'lessonTitle' => $lessonTitle,
                    'lessonUuid' => $lessonUuid,
                ];
            }
        }
        return $this->render('chapters_editor/index.html.twig', [
            'controller_name' => 'ChaptersEditorController',
            'chapterUuid' => $chapterUuid,
            'availableStages' => $availableStages,
            'availableLessons' => $availableLessons,
        ]);
    }
}
