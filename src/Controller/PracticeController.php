<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PracticeController extends AbstractController
{
    /**
     * @Route("/practice", name="practice")
     */
    public function index()
    {



        return $this->render('practice/index.html.twig', [
            'controller_name' => 'PracticeController',
        ]);
    }


}
