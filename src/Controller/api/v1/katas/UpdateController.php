<?php

namespace App\Controller\api\v1\katas;


use App\Entity\Kata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



Class UpdateController extends AbstractController {
    /**
     * @Route("api/v1/katas/{uuid}", name="UpdateController")
     * @param $uuid
     * @return JsonResponse
     */
    function UpdateController (Request $request,$uuid) {

        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $uuid]);

        $title=$request->request->get('title');
        $description=$request->request->get('description');
        $editorCode=$request->request->get('editorCode');
        $sampleTest=$request->request->get('sampleTest');
        if($uuid) {
            if ($title) {
                $kata->setKataTitle($title);
                $kata->setUpdatedAt(new \DateTime());
            }
            if ($description) {
                $kata->setDescription($description);
                $kata->setUpdatedAt(new \DateTime());
            }
            if ($editorCode) {
                $kata->setEditorCode($editorCode);
                $kata->setUpdatedAt(new \DateTime());
            }
            if ($sampleTest) {
                $kata->setTestCode($sampleTest);
                $kata->setUpdatedAt(new \DateTime());
            }

            $entity_manager = $this->getDoctrine()->getManager();

            $entity_manager->persist($kata);
            $entity_manager->flush();

            $response = new JsonResponse([
                'data' => $kata,
                'title' => $title,
                'description' => $description,
                'editorCode' => $editorCode
            ]);

            return $response;

        }
    }

}

