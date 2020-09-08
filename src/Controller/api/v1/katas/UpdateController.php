<?php

namespace App\Controller\api\v1\katas;


use App\Entity\Kata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;


Class UpdateController extends AbstractController {
    /**
     * @Route("api/v1/katas/{uuid}/editor", name="UpdateController")
     * @param $uuid
     * @return JsonResponse
     */
    function UpdateController (Request $request,$uuid) {

        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $uuid]);

        $title=$request->request->get('title');
        $description=$request->request->get('description');
        if($uuid) {
            if ($title) {
                $kata->setKataTitle($title);
            }
            if ($description) {
                $kata->setDescription($description);
            }
            $kata->setUpdatedAt(new \DateTime());

            $entity_manager = $this->getDoctrine()->getManager();

            $entity_manager->persist($kata);
            $entity_manager->flush();

            $response = new JsonResponse(['data' => $kata]);
            return $response;
        }
    }
}
