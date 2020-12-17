<?php

namespace App\Controller\api\v1\chapters;



use App\Entity\Chapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Class ChapterTitleUpdateController extends AbstractController
{
    /**
     * @Route("api/v1/chapters/{chapterUuid}/title", name="ChapterTitleUpdateController")
     * @param $chapterUuid
     * @return JsonResponse
     */
    function ChapterTitleUpdateController(Request $request, $chapterUuid)
    {
        //select chapter to be updated with uuid granted
        $chapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid' => $chapterUuid]);
        //get value of chapter textarea
        $chapterTitle = $request->request->get('chapter_title');
        //if there is a chapter created with an uuid
        if ($chapterUuid) {
            //if title is not null
            if ($chapterTitle) {
                //set title into Database
                $chapter->setTitle($chapterTitle);
            }
            else  throw $this->createNotFoundException('Debe introducir un título');
        }

        $entity_manager = $this->getDoctrine()->getManager();

        $entity_manager->persist($chapter);
        $entity_manager->flush();

        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;

    }
}