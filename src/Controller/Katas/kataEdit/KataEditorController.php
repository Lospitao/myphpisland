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

        return $this->render('kata_editor/index.html.twig', [
            'controller_name' => 'KataEditorController',
            'uuid' => $uuid,
        ]);
    }


}
