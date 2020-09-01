<?php

namespace App\Controller;

use App\Entity\Kata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class KataEditorController extends AbstractController
{
    /**
     * @Route("/katas/editor", name="katas_editor")
     */
    public function index()
    {

        return $this->render('kata_editor/index.html.twig', [
            'controller_name' => 'KataEditorController',
        ]);
    }
}
