<?php

namespace App\Controller\api\v1\lessons;



use App\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Class LessonTitleUpdateController extends AbstractController
{
    /**
     * @Route("api/v1/lessons/{uuid}", name="LessonTitleUpdateController")
     * @param $uuid
     * @return JsonResponse
     */
    function LessonUpdateController(Request $request, $uuid)
    {
        //select lesson to be updated with uuid granted
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);
        //get value of title textarea
        $title = $request->request->get('title');
        //if there is a lesson created with an uuid
        if ($uuid) {
            //if title is not null
            if ($title) {
                //set title into Database
                $lesson->setTitle($title);
            }
            else  throw $this->createNotFoundException('Debe introducir un título');
        }

        $entity_manager = $this->getDoctrine()->getManager();

        $entity_manager->persist($lesson);
        $entity_manager->flush();

        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;

    }
}