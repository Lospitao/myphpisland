<?php

namespace App\Controller\stageView;

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
     * @Route("/stages/{stageUuid}", name="stages")
     * @param $stageUuid
     */
    public function index($stageUuid)
    {
        //Get stage to be updated
        $stage = $this->getDoctrine()
            ->getRepository(Stage::class)
            ->findOneBy(['uuid' => $stageUuid]);
        //Get stage title
        $stageTitle= $stage->getTitle();
        $stageAmbientSound =$stage->getAmbientSound();
        $stageDialog=$stage->getDialog();
        $stageBackgroundImage=$stage->getBackgroundImage();
        return $this->render('stages/index.html.twig', [
            'controller_name' => 'StagesController',
            'stageUuid' => $stageUuid,
            'stageTitle' => $stageTitle,
            'stageAmbientSound' => $stageAmbientSound,
            'stageDialog' => $stageDialog,
            'stageBackgroundImage' => $stageBackgroundImage,
        ]);
    }
}
