<?php

namespace App\Controller\api\v1\stages;

use App\Entity\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

Class StageFileUploading extends AbstractController
{
    /**
     * @Route("api/v1/stages/{stageUuid}", name="StageFileUploading")
     * @param $stageUuid
     * @return JsonResponse
     */
    function StageFileUploading($stageUuid)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;

    }
}