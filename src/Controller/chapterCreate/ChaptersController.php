<?php

namespace App\Controller\chapterCreate;

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


    /**
     * @Route("/chapters/create", name="chapters_create" )
     */
    public function chaptersCreate()
    {
        try {
            $this->createNewChapterService();
            $this->persistToDataBase();
            $this->createChapterCreationSuccessMessage();

            return $this->redirectToRoute('chapters_editor', [
                'chapterUuid' => $this->newChapterUuid]);
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
    private function createChapterCreationSuccessMessage()
    {
        $this->addFlash('success', 'Edite el nuevo capítulo');
    }
    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
}
