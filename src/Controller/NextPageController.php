<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NextPageController extends AbstractController
{
    /**
     * @Route("/next/page", name="next_page")
     */
    public function index()
    {
        return $this->render('next_page/index.html.twig', [
            'controller_name' => 'NextPageController',
        ]);
    }
}
