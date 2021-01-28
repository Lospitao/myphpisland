<?php

namespace App\Controller\api\v1\chapters;

use App\Entity\ChapterElement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
Class DeleteChapterElementFromChapterController extends AbstractController
{

    /**
     * @Route("/api/v1/chapters/{chapterUuid}/chapterelements/{idElementChapter}", name="DeleteChapterElementFromChapterController")
     * @param $chapterUuid
     * @param $idElementChapter
     * @return JsonResponse
     */
    function DeleteChapterElementFromChapterController($chapterUuid, $idElementChapter)
    {
        try {
            $this->DeleteChapterElementFromChapterService($idElementChapter);
            $jSonResponseWithoutContent = $this->returnJsonResponseWithoutContent();
            return $jSonResponseWithoutContent;
        } catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            $jsonResponseWithError = $this->createJsonResponseWithError($ex);
            return $jsonResponseWithError;
        }
    }
    private function returnJsonResponseWithoutContent()
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
    private function checkIfAnElementIdHasBeenProvided($idElementChapter)
    {
        if (empty($idElementChapter)) {
            throw new Exception("Id del capítulo no encontrado");
        }
    }
    private function deleteElementFromChapter($chapterElementToBeRemoved)
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->remove($chapterElementToBeRemoved);
        $entity_manager->flush();
    }
    private function findChapterElementById($idChapterElement)
    {
        $chapterElementToBeRemoved = $this->getDoctrine()
            ->getRepository(ChapterElement::class)
            ->findOneBy(['id' => $idChapterElement]);
        return $chapterElementToBeRemoved;
    }
    private function createJsonResponseWithError($ex)
    {
        $errorResponse = new JsonResponse(['error' => $ex->error]);
        return $errorResponse;
    }

    private function DeleteChapterElementFromChapterService($idElementChapter)
    {
        $chapterElementToBeRemoved = $this->findChapterElementById($idElementChapter);
        $this->checkIfAnElementIdHasBeenProvided($idElementChapter);
        $this->deleteElementFromChapter($chapterElementToBeRemoved);
    }
}

