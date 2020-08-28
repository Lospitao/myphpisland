<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestCodeController extends AbstractController
{
    /**
     * @Route("/test/code", name="test_code")
     */
    public function index()
    {
        return $this->render('test_code/index.html.twig', [
            'controller_name' => 'TestCodeController',
        ]);
    }
}
