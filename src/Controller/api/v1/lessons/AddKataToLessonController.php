<?php

namespace App\Controller\api\v1\lessons;




use App\Entity\Kata;
use App\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Class AddKataToLessonController extends AbstractController
{
    /**
     * @Route("api/v1/lessons/{uuid}/katas", name="AddKataToLessonController")
     * @param $uuid,
     * @return JsonResponse
     */
    function AddKataToLessonController (Request $request, $uuid)
    {
        //get kata uuid
        $kata_uuid =$request->request->get('kataUuid');
        //get kata to be added
        $kata= $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $kata_uuid]);
        //get lesson to be updated
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);
        //check the lesson exists
        if ($uuid) {

            //check if kata exists
            if ($kata) {

                $lesson->addKatum($kata);

                //add kata to lesson (lesson-kata table in DB)
                $entity_manager = $this->getDoctrine()->getManager();
                $entity_manager->persist($lesson);
                $entity_manager->flush();


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