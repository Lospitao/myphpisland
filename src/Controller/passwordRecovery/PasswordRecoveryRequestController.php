<?php

namespace App\Controller\passwordRecovery;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PasswordRecoveryRequestController extends AbstractController
{
    /**
     * @Route("/forgot-my-password", name="password_recovery_request")
     */
    public function index()
    {
        return $this->render('password_recovery_request/index.html.twig', [
            'controller_name' => 'PasswordRecoveryRequestController',
        ]);
    }
}
