<?php

namespace App\Controller\api\v1\lessons;




use App\Entity\Kata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Class DeleteKataFromLessonController extends AbstractController
{
    /**
     * @Route("api/v1/lessons/{uuid}/katas", name="DeleteKataFromLessonController")
     * @param $uuid,
     * @return JsonResponse
     */
    function DeleteKataFromLessonController (Request $request, $uuid)
    {
        $kata_uuid =$request->request->get('kataUuid');
        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $kata_uuid]);

        $title = $kata->getKataTitle();

        array_push($lessonKatas, [
            'title' => $title,
            'katasUuid' => $kata_uuid,
        ]);

        $response = new JsonResponse([
            'lesson_uuid' => $uuid,
            'kata_uuid' => $kata_uuid,
            'title' => $title,
            'lessonKatas' => $lessonKatas,
        ]);

        return $response;
    }
}