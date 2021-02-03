<?php

namespace App\Controller\api\v1\lessons\katas;

use App\Entity\Kata;
use App\Entity\Lesson;
use App\Entity\LessonKatas;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

Class UpdateKataPositionFromLessonController extends AbstractController
{

    /**
     * @Route("api/v1/lessons/{uuid}/katas/{kata_uuid}", methods={"PATCH"}, name="UpdateKataPositionFromLessonController")
     * @param Request $request
     * @param $uuid
     * @param $kata_uuid
     * @return JsonResponse
     */
    function UpdateKataPositionFromLessonController (Request $request, $uuid, $kata_uuid) {
        //get data
        $newKataPosition = $request->request->get('position');
        $kataUuid =$request->request->get('kataUuid');
        //get kata id
        $kata= $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $kataUuid]);
        $kataId=$kata->getId();
        //get lesson id
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);
        $lessonId = $lesson->getId();
        //get entry of LessonKatas Entity to be updated
        $entryToUpdate= $this->getDoctrine()
            ->getRepository(LessonKatas::class)
            ->findOneBy(['lesson' => $lessonId, 'kata' => $kataId ]);
        if (!$entryToUpdate) {
            $response = new JsonResponse();
            $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
            return $response;
        }
        //Update position
        $entryToUpdate->setPosition($newKataPosition);
        //persist kata to lesson (lesson-kata table in DB)
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($entryToUpdate);
        $entity_manager->flush();
        //set response
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
}