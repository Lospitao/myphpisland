<?php

namespace App\Controller\chapterView;

use App\Entity\Chapter;
use App\Entity\ChapterElement;
use App\Entity\Lesson;
use App\Entity\Stage;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ChaptersController extends AbstractController
{
    var $createdChapter;
    var $newChapterUuid;
    var $chapterTitle;
    var $availableStages;
    var $availableLessons;
    var $chapterLessonsAndStages;
    var $elementClass;
    var $chapterUuid;
    var $chapterToLoad;
    var $elementsInChapter;
    var $elementType;
    /**
     * @Route("/chapters/create", name="chapters_create" )
     */
    public function chaptersCreate()
    {
        try {
            $this->createNewChapterService();
            $this->persistToDataBase();
            $this->addFlash('success', 'Edite el nuevo capítulo');

            return $this->redirectToRoute('chapters_editor', [
                'chapterUuid' => $this->newChapterUuid]);
        } catch (\Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }

    }
    /**
     * @Route("/chapters/{chapterUuid}/", name="chapters")
     * @param $chapterUuid
     */
    public function index($chapterUuid)
    {
        try {
            $this->setChapterFromDataBase($chapterUuid);
            $this->checkIfChapterToLoadExists();
            $this->setChapterTitleFromDatabase();
            $this->defineChapterLessonsAndStages();
            $this->findAllLessonsAndStagesInChapter();
            $this->setChapterLessonsAndChapterStagesFromDatabase();

                $this->createChapterView($chapterUuid);
        } catch (\Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }
    }

    private function createNewChapterService()
    {
        $this->createNewEntity();
        $this->setUuid();
    }

    private function createNewEntity()
    {
        $this->createdChapter = new Chapter();
    }

    private function setUuid()
    {
        $this->newChapterUuid = Uuid::v4();
        $this->createdChapter->setUuid($this->newChapterUuid);
    }

    private function persistToDataBase()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->createdChapter);
        $entity_manager->flush();
    }

    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }

    private function createChapterView($chapterUuid)
    {
        return $this->render('chapters/index.html.twig', [
            'controller_name' => 'ChaptersController',
            'chapterUuid' => $chapterUuid,
            'chapterTitle' => $this->chapterTitle,
            'chapterElementsArray' => $this->chapterLessonsAndStages,
            'elementClass' => $this->elementClass,
        ]);
    }

    private function setChapterFromDataBase($chapterUuid)
    {
        $this->chapterToLoad = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid'=>$chapterUuid]);
    }
    private function checkIfChapterToLoadExists()
    {
        if (!$this->chapterToLoad) {
            throw new Exception("La kata especificada no existe. Cree una nueva kata");
        }
    }

    private function setChapterTitleFromDatabase()
    {
        $this->chapterTitle = $this->chapterToLoad->getTitle();
    }

    private function defineChapterLessonsAndStages()
    {
        $this->chapterLessonsAndStages = [];
    }

    private function findAllLessonsAndStagesInChapter()
    {
        $chapterId = $this->chapterToLoad->getId();
        $this->elementsInChapter = $this->getDoctrine()
            ->getRepository(ChapterElement::class)
            ->findBy(['chapterId' => $chapterId]);
    }

    private function setChapterLessonsAndChapterStagesFromDatabase()
    {

        foreach ($this->elementsInChapter as $element) {

            $this->setElementTypeFromDataBase($element);
            if ($this->elementType==1) {
                $this->elementClass = $this->defineLessonClass();
                $lessonId=$this->setChapterElementIdFromDataBase($element);
                $lesson = $this->setLessonFromDatabase($lessonId);
                $ChapterLessonTitle = $this->setChapterLessonTitleFromDatabase($lesson);
                $ChapterLessonUuid = $this->setChapterLessonUuidFromDatabase($lesson);
                $this->storeLessonInChapter($ChapterLessonTitle, $ChapterLessonUuid);
            }
            else {
                $this->elementClass = $this->defineStageClass();
                $stageId=$this->setChapterElementIdFromDataBase($element);
                $stage = $this->setStageFromDatabase($stageId);
                $ChapterStageTitle = $this->setChapterStageTitleFromDatabase($stage);
                $ChapterStageUuid = $this->setChapterStageUuidFromDatabase($stage);
                $this->storeStageInChapter($ChapterStageTitle, $ChapterStageUuid);
            }
        }
    }

    private function setElementTypeFromDataBase($element)
    {
        $this->elementType= $element->getChapterElementType();
    }

    private function setChapterElementIdFromDataBase($element)
    {
        return $elementId = $element->getStageOrLessonId();
    }

    private function defineLessonClass()
    {
        return "tiny material-icons chapterLesson";
    }

    private function setLessonFromDatabase($element)
    {
        return $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['id'=>$this->setElementTypeFromDataBase($element)]);
    }

    private function setChapterLessonTitleFromDatabase($lesson)
    {
        return $chapterLessonTitle = $lesson->getTitle();
    }

    private function setChapterLessonUuidFromDatabase($lesson)
    {
        return $chapterLessonUuid = $lesson->getUuid();
    }
    private function storeLessonInChapter($chapterLessonTitle, $chapterLessonUuid)
    {
        $chapterLessonsAndStages[$chapterLessonUuid] = [
            'title' => $chapterLessonTitle,
            'uuid' => $chapterLessonUuid,
            'elementType' => 1,
        ];
    }

    private function defineStageClass()
    {
        return "tiny material-icons chapterStage";
    }

    private function setStageFromDatabase($stageId)
    {
        return $stage = $this->getDoctrine()
            ->getRepository(Stage::class)
            ->findOneBy(['id'=>$stageId]);
    }

    private function setChapterStageTitleFromDatabase(?Stage $stage)
    {
        return $chapterStageTitle = $stage->getTitle();
    }

    private function setChapterStageUuidFromDatabase(?Stage $stage)
    {
        return $chapterStageUuid = $stage->getUuid();
    }

    private function storeStageInChapter($ChapterStageTitle,$ChapterStageUuid)
    {
        $chapterLessonsAndStages[$ChapterStageUuid] = [
            'title' => $ChapterStageTitle,
            'uuid' => $ChapterStageUuid,
            'elementType' => 2,
        ];
    }
}
