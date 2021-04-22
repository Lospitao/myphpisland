<?php

namespace App\Controller\api\v1\chapters;

use App\Entity\Chapter;
use App\Entity\Lesson;
use App\Entity\Stage;
use App\Entity\ChapterElement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Class AddChapterElementToChapterController extends AbstractController
{
    /**
     * @var int|null
     */
    private $idChapterElement;

    /**
     * @Route("/api/v1/chapters/{chapterUuid}/chapterelements", name="AddChapterElementToChapterController")
     * @param Request $request
     * @param $chapterUuid
     * @return JsonResponse
     */
    function index(Request $request, $chapterUuid)
    {
        //Get Chapter
        $chapter= $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid' => $chapterUuid]);

        //if there is a chapter created with an uuid
        if ($chapterUuid) {
            //Get Stage or Lessons Uuid and position
            $stageToBeAddedUuid = $request->request->get('stageToBeAddedUuid');
            $lessonToBeAddedUuid = $request->request->get('lessonToBeAddedUuid');
            $positionOfNewLessonAdded = $request->request->get('positionOfNewChapterLesson');
            $positionOfNewStageAdded = $request->request->get('positionOfNewChapterStage');
            if ($lessonToBeAddedUuid) {
                //Get Lessons
                $lesson = $this->getDoctrine()
                    ->getRepository(Lesson::class)
                    ->findOneBy(['uuid' => $lessonToBeAddedUuid]);
                //Get Lessons Id
                $lessonId = $lesson->getId();
                //Check if entry already exists en DB
                $lessonInChapterElementEntity=$this->getDoctrine()
                    ->getRepository(ChapterElement::class)
                    ->findOneBy(['stageOrLessonId'=>$lessonId, 'chapterElementType' => ChapterElement::ID_chapter_element_type_lesson, 'chapterId' => $chapter->getId()]);

                if($lessonInChapterElementEntity === null) {

                    $newChapterLesson = new ChapterElement();
                    $newChapterLesson->setChapterId($chapter->getId());
                    $newChapterLesson->setChapterElementType(1);
                    $newChapterLesson->setStageOrLessonId((int)$lessonId);
                    $newChapterLesson->setPosition($positionOfNewLessonAdded);

                    //persist lesson to chapter_element table
                    $entity_manager = $this->getDoctrine()->getManager();
                    $entity_manager->persist($newChapterLesson);
                    $entity_manager->flush();
                    $this->idChapterElement= $newChapterLesson->getId();
                }
            }
            else if ($stageToBeAddedUuid) {
                //Get Stage
                $stage= $this->getDoctrine()
                    ->getRepository(Stage::class)
                    ->findOneBy(['uuid' => $stageToBeAddedUuid]);
                //Get Stage Id
                $stageId = $stage->getId();
                //Check if entry already exists in DB
                $stageInChapterElementEntity=$this->getDoctrine()
                    ->getRepository(ChapterElement::class)
                    ->findOneBy(['stageOrLessonId' => $stageId, 'chapterElementType' => ChapterElement::ID_chapter_element_type_stage, 'chapterId' => $chapter->getId()]);

                if($stageInChapterElementEntity === null) {

                    $newChapterStage = new ChapterElement();
                    $newChapterStage->setChapterId($chapter->getId());
                    $newChapterStage->setChapterElementType(2);
                    $newChapterStage->setStageOrLessonId((int)$stageId);
                    $newChapterStage->setPosition($positionOfNewStageAdded);
                    //persist stage to chapter_element table
                    $entity_manager = $this->getDoctrine()->getManager();
                    $entity_manager->persist($newChapterStage);
                    $entity_manager->flush();
                    $this->idChapterElement = $newChapterStage->getId();
                }
            }
            $response = new JsonResponse([
                'idChapterElement' => $this->idChapterElement,
            ]);
            return $response;
        }

    }
}
