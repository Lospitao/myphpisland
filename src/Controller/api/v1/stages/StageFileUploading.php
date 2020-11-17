<?php

namespace App\Controller\api\v1\stages;

use App\Entity\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

Class StageFileUploading extends AbstractController
{
    /**
     * @Route("api/v1/stages/{stageUuid}", name="StageFileUploading")
     * @param $stageUuid
     * @param $targetDirectory
     * @param $slugger
     * @return void
     */
    function StageFileUploading($stageUuid, $targetDirectory, $slugger) {

    }

}