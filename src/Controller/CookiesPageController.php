<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CookiesPageController extends AbstractController
{
    /**
     * @Route("/politica-de-cookies", name="cookies_page")
     */
    public function index(): Response
    {
        return $this->render('cookies_page/index.html.twig', [
            'controller_name' => 'CookiesPageController',
        ]);
    }
}
