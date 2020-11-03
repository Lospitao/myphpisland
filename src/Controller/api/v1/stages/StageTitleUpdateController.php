<?php

namespace App\Controller\api\v1\stages;

use App\Entity\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Class StageTitleUpdateController extends AbstractController
{
    /**
     * @Route("api/v1/stages/{stageUuid}/title", name="StageTitleUpdateController")
     * @param $stageUuid
     * @return JsonResponse
     */
    function StageTitleUpdateController(Request $request, $stageUuid)
    {
        //select stage to be updated with uuid granted
        $stage = $this->getDoctrine()
            ->getRepository(Stage::class)
            ->findOneBy(['uuid' => $stageUuid]);
        //get value of title textarea
        $title = $request->request->get('title');
        //if there is a stage created with an uuid
        if ($stageUuid) {
            //if title is not null
            if ($title) {
                //set title into Database
                $stage->setTitle($title);
            }
            else  throw $this->createNotFoundException('Debe introducir un título');
        }

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($stage);
        $entity_manager->flush();

        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;

    }
}