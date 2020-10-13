<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilePageController extends AbstractController
{
    /**
     * @Route("/profile_page/", name="profile_page")
     */
    public function index()
    {
        return $this->render('profile_page/index.html.twig', [
            'controller_name' => 'ProfilePageController',
        ]);
    }

    public function updatePassword() {

    }
}
