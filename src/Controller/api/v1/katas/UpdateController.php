<?php

namespace App\Controller\api\v1\katas;


use App\Entity\Kata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



Class UpdateController extends AbstractController {
    /**
     * @Route("/api/v1/katas/{uuid}", name="UpdateController")
     */
    function UpdateController (Request $request, $uuid) {

        $entity_manager = $this->getDoctrine()->getEntityManager();

        $kata = $entity_manager->getRepository('ChallengeRepository:Kata')->findBy($uuid);
        $uuidInDB = $kata->getUuid($kata);

        if ($uuidInDB == $uuid && 'title')
        $kata->setKataTitle('title');
        $kata->setUpdatedAt(new \DateTime());

        $entity_manager->persist($kata);
        $entity_manager->flush();




        return $this->redirectToRoute('katas_editor',
            ['uuid' => $uuid,
            ]);
    }
}
