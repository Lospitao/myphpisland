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
Class AddStagesAndLessonsToChapterController extends AbstractController
{
    /**
     * @Route("/api/v1/chapters/{chapterUuid}/element", name="AddStagesAndLessonsToChapterController")
     * @param $chapterUuid
     * @return JsonResponse
     */
    function AddStagesAndLessonsToChapterController(Request $request, $chapterUuid)
    {
        //Get Chapter
        $chapter= $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid' => $chapterUuid]);
        //Get Chapter Id
        $chapterId = $chapter->getId();
        //if there is a chapter created with an uuid
        if ($chapterId) {
            //Get Stage or Lesson Id
            $stageToBeAddedUuid = $request->request->get('stageToBeAddedUuid');
            $lessonToBeAddedUuid = $request->request->get('lessonToBeAddedUuid');

            if ($stageToBeAddedUuid) {
                //Get Stage
                $stage= $this->getDoctrine()
                    ->getRepository(Stage::class)
                    ->findOneBy(['uuid' => $stageToBeAddedUuid]);
                //Get Stage Id
                $stageId = $stage->getId();
                //Check if entry already exists in DB
                $stageInChapterElementEntity=$this->getDoctrine()
                    ->getRepository(ChapterElement::class)
                    ->findOneBy(['stageOrLessonId' => $stageId]);
                if(!$stageInChapterElementEntity) {

                    $newChapterStage = new ChapterElement();
                    $newChapterStage->setChapterId((int)$chapterId);
                    $newChapterStage->setChapterElementType(2);
                    $newChapterStage->setStageOrLessonId((int)$stageId);

                    //persist stage to chapter_element table
                    $entity_manager = $this->getDoctrine()->getManager();
                    $entity_manager->persist($newChapterStage);
                    $entity_manager->flush();
                }
            }
            if ($lessonToBeAddedUuid) {
                //Get Lesson
                $lesson = $this->getDoctrine()
                    ->getRepository(Lesson::class)
                    ->findOneBy(['uuid' => $lessonToBeAddedUuid]);
                //Get Lesson Id
                $lessonId = $lesson->getId();
                //Check if entry already exists en DB
                $lessonInChapterElementEntity=$this->getDoctrine()
                    ->getRepository(ChapterElement::class)
                    ->findOneBy(['stageOrLessonId'=>$lessonId]);
                if(!$lessonInChapterElementEntity) {

                    $newChapterLesson = new ChapterElement();
                    $newChapterLesson->setChapterId((int)$chapterId);
                    $newChapterLesson->setChapterElementType(1);
                    $newChapterLesson->setStageOrLessonId((int)$lessonId);

                    //persist lesson to chapter_element table
                    $entity_manager = $this->getDoctrine()->getManager();
                    $entity_manager->persist($newChapterLesson);
                    $entity_manager->flush();
                }
            }


        }
            else  throw $this->createNotFoundException('Se ha producido un problema al añadir elementos al capítulo');


        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
}