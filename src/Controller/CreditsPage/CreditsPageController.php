<?php

namespace App\Controller\CreditsPage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditsPageController extends AbstractController
{
    /**
     * @Route("/credits/page", name="credits_page")
     */
    public function index(): Response
    {
        return $this->render('credits_page/index.html.twig', [
            'controller_name' => 'CreditsPageController',
            'apiHost' => $this->getParameter('api_host'),
        ]);
    }
}
