<?php

namespace App\Controller\api\v1\lessons\dragdrop;

use App\Entity\Kata;
use App\Entity\Lesson;
use App\Entity\LessonKatas;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class DeleteKataFromLessonByDragAndDropController extends AbstractController
{
    /**
     * @Route("api/v1/lessons/dragdrop/{uuid}/katas/{kataToBeRemovedUuid}", name="DeleteKataFromLessonController")
     * @param $uuid ,
     * @param $kataToBeRemovedUuid
     * @return JsonResponse
     */
    function DeleteKataFromLessonByDragAndDropController(Request $request, $uuid, $kataToBeRemovedUuid)
    {
        //get kata uuid
        $kataUuid = $request->request->get('kataToBeRemovedUuid');
        //get kata to be added
        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $kataUuid]);
        //get lesson to be updated
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);
        //Check if lesson exists
        if ($lesson) {
            //check if kata exists
            if ($kata) {
                //Get kata id
                $kataId = $kata->getId();
                //Get kata in chapter-element table
                $kataInLesson = $this->getDoctrine()
                    ->getRepository(LessonKatas::class)
                    ->findOneBy(['kata' => $kataId]);
                //persist lesson to chapter_element table
                $entity_manager = $this->getDoctrine()->getManager();
                $entity_manager->remove($kataInLesson);
                $entity_manager->flush();
                //set response
                $response = new JsonResponse();
                $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
                return $response;
            } else {
                $response = new JsonResponse();
                $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
                return $response;
            }
        }
    }
}