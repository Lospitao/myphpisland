<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Entity\ChapterElement;
use App\Entity\Lesson;
use App\Entity\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ChaptersController extends AbstractController
{
    /**
     * @Route("/chapters/create", name="chapters_create" )
     */
    public function chapterscreate()
    {
        $chapter = new Chapter();
        $chapterUuid = Uuid::v4();
        $chapter->setUuid($chapterUuid);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($chapter);
        $entity_manager->flush();

        return $this->redirectToRoute('chapters_editor', [
            'chapterUuid' => $chapterUuid]);
    }
    /**
     * @Route("/chapters/{chapterUuid}/", name="chapters")
     * @param $chapterUuid
     */
    public function index($chapterUuid)
    {
        //Get chapter through Uuid
        $chapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid'=>$chapterUuid]);
        //Get chapter title
        $chapterTitle = $chapter->getTitle();
        /*Load Chapter Stages and Lessons*/
        //Define class variable
        $elementClass="";
        //Get Chapter
        $chapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid' => $chapterUuid]);
        //Get chapter Id
        $chapterId = $chapter->getId();
        //Create array to save chapterElements
        $chapterElementsArray = [];
        //Get all entries with chapterId
        $elementsInChapter = $this->getDoctrine()
            ->getRepository(ChapterElement::class)
            ->findBy(['chapterId' => $chapterId]);
        //Iterate Through array ElementsInChapter to get the title and uuid of each element
        foreach ($elementsInChapter as $element) {
            //Get element type
            $elementType= $element->getChapterElementType();
            //Get element id
            $elementId = $element->getStageOrLessonId();
            //If element is a lesson
            if ($elementType==1) {
                $elementClass="tiny material-icons chapterLesson";
                //get Lesson through ElementId
                $lesson = $this->getDoctrine()
                    ->getRepository(Lesson::class)
                    ->findOneBy(['id'=>$elementId]);
                //Get lesson Title
                $ChapterLessonTitle = $lesson->getTitle();
                //Get lesson Uuid
                $ChapterLessonUuid = $lesson->getUuid();
                //Push element into array
                $chapterElementsArray[$ChapterLessonUuid] = [
                    'title' => $ChapterLessonTitle,
                    'uuid' => $ChapterLessonUuid,
                    'elementType' => 1,
                ];
            }
            //If element is a Stage
            else if ($elementType==2) {
                $elementClass="tiny material-icons chapterStage";
                //Get Stage through elementId
                $stage = $this->getDoctrine()
                    ->getRepository(Stage::class)
                    ->findOneBy(['id'=>$elementId]);
                //Get Stage Title
                $ChapterStageTitle = $stage->getTitle();
                //Get Stage Uuid
                $ChapterStageUuid = $stage->getUuid();
                //Push element into array
                $chapterElementsArray[$ChapterStageUuid] = [
                    'title' => $ChapterStageTitle,
                    'uuid' => $ChapterStageUuid,
                    'elementType' => 2,
                ];

            }
        }
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
            if (!array_key_exists($stageUuid, $chapterElementsArray)) {
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
            if (!array_key_exists($lessonUuid, $chapterElementsArray)) {
                //Push title and uuid of stage into availableStages
                $availableLessons[$lessonUuid] = [
                    'lessonTitle' => $lessonTitle,
                    'lessonUuid' => $lessonUuid,
                ];
            }
        }

        return $this->render('chapters/index.html.twig', [
            'controller_name' => 'ChaptersController',
            'chapterUuid' => $chapterUuid,
            'chapterTitle' => $chapterTitle,
            'availableStages' => $availableStages,
            'availableLessons' => $availableLessons,
            'chapterElementsArray' => $chapterElementsArray,
            'elementClass' => $elementClass,
        ]);
    }
}
