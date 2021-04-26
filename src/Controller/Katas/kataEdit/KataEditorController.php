<?php

namespace App\Controller\Katas\kataEdit;

use App\Entity\Kata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class KataEditorController extends AbstractController
{
    /**
     * @Route("/katas/{uuid}/editor", name="katas_editor")
     */
    public function index($uuid)
    {
        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $uuid]);
        return $this->render('kata_editor/index.html.twig', [
            'controller_name' => 'KataEditorController',
            'uuid' => $uuid,
            'kataDescription' => $kata->getDescription(),
            'kataEditorCode' => $kata->getEditorCode(),
            'kataExamples' => $kata->getExamples(),
            'kataTitle' => $kata->getKataTitle(),
            'kataTest' => $kata->getKataTestCode(),

        ]);
    }


}
