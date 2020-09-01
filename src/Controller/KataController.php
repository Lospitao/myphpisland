<?php

namespace App\Controller;


use App\Entity\Kata;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class KataController extends AbstractController

{
    /**
     * @Route("/katas", name="kata")
     */
    public function index()
    {



        return $this->render('kata/index.html.twig', [
            'controller_name' => 'KataController',

        ]);
    }

    /**
     * @Route("/katas/create", name="katas_create")
     */
    public function katascreate()
    {
        $kata = new Kata;
        $kata_uuid = Uuid::v4();
        $kata->setUuid($kata_uuid);
        $kata->setCreatedAt(new \DateTime());
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($kata);
        $entity_manager->flush();

        return $this->redirectToRoute('katas_editor');

    }



}
