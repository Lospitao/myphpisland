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
Class DeleteStagesAndLessonsFromChapterController extends AbstractController
{
    /**
     * @Route("api/v1/chapters/{chapterUuid}/elementsToBeRemoved", name="DeleteStagesAndLessonsFromChapterController")
     * @param $chapterUuid
     * @return JsonResponse
     */
    function DeleteStagesAndLessonsFromChapterController(Request $request, $chapterUuid)
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
            $lessonToBeRemovedUuid = $request->request->get('lessonToBeRemovedUuid');
            $stageToBeRemovedUuid = $request->request->get('stageToBeRemovedUuid');

            if ($stageToBeRemovedUuid) {
                //Get Stage
                $stage= $this->getDoctrine()
                    ->getRepository(Stage::class)
                    ->findOneBy(['uuid' => $stageToBeRemovedUuid]);
                //Get stage Id
                $stageId = $stage->getId();
                //Get stage in chapter-element table
                $stageinChapter = $this->getDoctrine()
                    ->getRepository(ChapterElement::class)
                    ->findOneBy(['stageOrLessonId' =>$stageId]);
                //persist stage to chapter_element table
                $entity_manager = $this->getDoctrine()->getManager();
                $entity_manager->remove($stageinChapter);
                $entity_manager->flush();


            }
            if ($lessonToBeRemovedUuid) {
                //Get Lesson
                $lesson = $this->getDoctrine()
                    ->getRepository(Lesson::class)
                    ->findOneBy(['uuid' => $lessonToBeRemovedUuid]);
                //Get lesson Id
                $lessonId = $lesson->getId();
                //Get lesson in chapter-element table
                $lessoninChapter = $this->getDoctrine()
                    ->getRepository(ChapterElement::class)
                    ->findOneBy(['stageOrLessonId' =>$lessonId]);
                //persist lesson to chapter_element table
                $entity_manager = $this->getDoctrine()->getManager();
                $entity_manager->remove($lessoninChapter);
                $entity_manager->flush();
            }

        }
        else  throw $this->createNotFoundException('Se ha producido un problema al añadir elementos al capítulo');


        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
}