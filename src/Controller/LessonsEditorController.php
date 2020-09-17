<?php

namespace App\Controller;

use App\Entity\Kata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LessonsEditorController extends AbstractController
{
    /**
     * @Route("/lessons/{uuid}/editor", name="lessons_editor")
     */
    public function index($uuid)
    {
        $availableKatas = array();
        //Todas las katas
        $katasArray = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findAll();
        //Iteración dentro del array de katas
        foreach($katasArray as $kata) {
            //Obtener el título cada
            $title = $kata->getKataTitle();
            array_push($availableKatas, $title);

        }
        return $this->render('lessons_editor/index.html.twig', [
            'controller_name' => 'LessonsEditorController',
            'uuid' => $uuid,
            'availableKatas'=> $availableKatas,
        ]);
    }
}
