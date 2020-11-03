<?php

namespace App\Controller;

use App\Entity\Stage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StagesEditorController extends AbstractController
{
    /**
     * @Route("/stages/{stageUuid}/editor", name="stages_editor")
     * @param $stageUuid
     */
    public function index($stageUuid)
    {

        return $this->render('stages_editor/index.html.twig', [
            'controller_name' => 'StagesEditorController',
            'stageUuid' => $stageUuid,
        ]);
    }
}
