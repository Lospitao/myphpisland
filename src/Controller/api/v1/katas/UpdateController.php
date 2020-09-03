<?php

namespace App\Controller\api\v1\katas;


use App\Entity\Kata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



Class UpdateController extends AbstractController {
    /**
     * @Route("/api/v1/katas/{uuid}/editor", name="UpdateController")
     */
    function UpdateController (Request $request, $uuid) {

        $response = new JsonResponse(['data' => 123]);
        return $response;
        /*
        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findBy(['uuid' =>$uuid]);

        $kata->($request);

        if ($uuid && $request) {

            $kata->setKataTitle('title');
            $kata->setUpdatedAt(new \DateTime());
        }

        $entity_manager->persist($kata);
        $entity_manager->flush();




        return $this->redirectToRoute('katas_editor',
            ['uuid' => $uuid,
            ]);
        */
    }
}
