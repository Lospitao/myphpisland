<?php

namespace App\Controller\api\v1\test_executions;


use App\Entity\Kata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

Class TestExecutionsController extends AbstractController {
    /**
     * @Route("api/v1/test_executions/{uuid}", name="TestExecutionsController")
     * @param $uuid
     * @return JsonResponse
     */
    function TestExecutions (Request $request, $uuid) {
        //Select kata from uuid
        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $uuid]);

        $editorCode=$request->request->get('code');
        $sampleTest = $kata->getTestCode();

        if ($editorCode == $sampleTest) {
            $answer ="You are right";
        }

        else $answer="keep trying";

        $response = new JsonResponse([
            'data' => $kata,
            'editorCode' => $editorCode,
            'sampleTest' => $sampleTest,
            'answer' => $answer
        ]);

        return $response;

    }
}