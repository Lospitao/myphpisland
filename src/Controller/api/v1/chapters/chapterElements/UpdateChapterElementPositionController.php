<?php

namespace App\Controller\api\v1\chapters\chapterElements;

use App\Entity\ChapterElement;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Class UpdateChapterElementPositionController extends AbstractController
{
    /**
     * @Route("/api/v1/chapters/{chapterUuid}/chapterelements/{chapterElementId} ", methods={"PATCH"}, name="UpdateChapterElementPositionController")
     * @param Request $request
     * @param $chapterUuid
     * @param $chapterElementId
     * @return JsonResponse
     */
    function index (Request $request) {
        try {
            $this->UpdatePositionOfNewDraggedDroppedElement($request);
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
    private function createJsonResponseWithError($ex)
    {
        $errorResponse = new JsonResponse(['error' => $ex->error]);
        return $errorResponse;
    }
    private function UpdatePositionOfNewDraggedDroppedElement($request)
    {
        $entryToUpdate= $this->findEntryToUpdate($request);
        $this->checkIfAnElementHasBeenDraggedDropped($entryToUpdate);
        $draggedDroppedElementPosition = $this->findNewElementPosition($request);
        $this->UpdatePositionOfElement($entryToUpdate, $draggedDroppedElementPosition);
    }
    private function findEntryToUpdate($request)
    {
        $chapterElementId = $request->request->get('chapterElementId');
        $entryToUpdate= $this->getDoctrine()
            ->getRepository(ChapterElement::class)
            ->findOneBy(['id' => $chapterElementId]);
        return $entryToUpdate;
    }
    private function checkIfAnElementHasBeenDraggedDropped($entryToUpdate)
    {
        if (empty($entryToUpdate)) {
            throw new Exception("No se ha encontrado el elemento seleccionado.");
        }
    }
    private function findNewElementPosition($request)
    {
        $newElementPosition = $request->request->get('position');
        return $newElementPosition;
    }
    private function UpdatePositionOfElement($entryToUpdate, $newElementPosition)
    {
        $entryToUpdate->setPosition($newElementPosition);
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($entryToUpdate);
        $entity_manager->flush();
    }

}