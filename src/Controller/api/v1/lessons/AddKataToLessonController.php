<?php

namespace App\Controller\api\v1\lessons;

use App\Entity\Kata;
use App\Entity\Lesson;
use App\Entity\LessonKatas;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Class AddKataToLessonController extends AbstractController
{
    /**
     * @Route("api/v1/lessons/{uuid}/katas", name="AddKataToLessonController" )
     * @param $uuid,
     * @return JsonResponse
     */
    function AddKataToLessonController (Request $request, $uuid)
    {
        //get kata uuid
        $kataUuid =$request->request->get('kataToBeAddedUuid');
        // get position
        $newKataPosition = $request->request->get('positionOfNewLessonKata');
        //get kata to be added
        $kata= $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $kataUuid]);

        //get lesson to be updated
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);

        //check the lesson exists
        if ($uuid) {
            //check if kata exists
            if ($kata) {
                //Add kata to lesson in relational table lessonKatas
                $newLessonKata =  new LessonKatas();
                $newLessonKata->setKata($kata);
                $newLessonKata->setLesson($lesson);
                $newLessonKata->setPosition($newKataPosition);
                //persist kata to lesson (lesson-kata table in DB)
                $entity_manager = $this->getDoctrine()->getManager();
                $entity_manager->persist($newLessonKata);
                $entity_manager->flush();
                //set response
                $response = new JsonResponse();
                $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
                return $response;
            }
            else {
                $response = new JsonResponse();
                $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
                return $response;
            }
        }
    }
}