<?php

namespace App\Controller;


use App\Entity\Kata;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class KataController extends AbstractController

{
    /**
     * @Route("/katas/create", name="katas_create" )
     */
    public function katascreate()
    {
        $kata = new Kata;
        $uuid = Uuid::v4();
        $kata->setUuid($uuid);
        $kata->setCreatedAt(new \DateTime());
        $kata->setUpdatedAt(new \DateTime());

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($kata);
        $entity_manager->flush();

        return $this->redirectToRoute('katas_editor', [
            'uuid' => $uuid]);
    }

    /**
     * @Route("/katas/{uuid}", name="kata")
     * @param $uuid
     */
    public function index($uuid)
    {
        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $uuid]);

        $title= $kata->getKataTitle();
        $description = $kata->getDescription();
        $codeEditor = $kata->getEditorCode();
        $sampleTest = $kata->getTestCode();


        return $this->render('kata/index.html.twig', [
            'controller_name' => 'KataController',
            'title' => $title,
            'description' => $description,
            'codeEditor' => $codeEditor,
            'sampleTest' => $sampleTest,
            'uuid' => $uuid,
        ]);
    }




}
