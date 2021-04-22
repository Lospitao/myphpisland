<?php

namespace App\Controller\Lessons\lessonCreate;

use App\Entity\Kata;
use App\Entity\Lesson;
use App\Entity\LessonKatas;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class LessonsController extends AbstractController
{
    var $createdLesson;
    var $newLessonUuid;
    /**
     * @Route("/lessons/create", name="lessons_create" )
     */
    public function lessonscreate()
    {
        try {
            $this->createNewLessonService();
            $this->persistToRepository();
            $this->createLessonCreationSuccessMessage();

            return $this->redirectToRoute('lessons_editor', [
                'uuid' => $this->newLessonUuid]);
        } catch (\Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }
    }

    private function createNewLessonService()
    {
        $this->createNewEntity();
        $this->setUuid();
    }

    private function createNewEntity()
    {
        $this->createdLesson = new Lesson();
    }

    private function setUuid()
    {
        $this->newLessonUuid = Uuid::v4();
        $this->createdLesson->setUuid($this->newLessonUuid);
    }

    private function persistToRepository()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->createdLesson);
        $entity_manager->flush();
    }

    private function createLessonCreationSuccessMessage()
    {
        $this->addFlash('success', 'Edite la nueva lección');
    }

    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
}
