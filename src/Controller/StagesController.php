<?php

namespace App\Controller;

use App\Entity\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class StagesController extends AbstractController
{
    /**
     * @Route("/stages/create", name="stages_create")
     */
    public function stagescreate() {
        $stage = new Stage();
        $stageUuid = Uuid::v4();
        $stage->setUuid($stageUuid);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($stage);
        $entity_manager->flush();

        return $this->redirectToRoute('stages_editor', [
            'stageUuid' => $stageUuid]);
    }
    /**
     * @Route("/stages/", name="stages")
     */
    public function index()
    {
        return $this->render('stages/index.html.twig', [
            'controller_name' => 'StagesController',
        ]);
    }
}
