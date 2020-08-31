<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->redirectToRoute('app_katas/edit.html.twig');
    }



}
