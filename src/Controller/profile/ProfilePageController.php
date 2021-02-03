<?php

namespace App\Controller\profile;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;


class ProfilePageController extends AbstractController
{
    /**
     * @Route("/profile_page/{username}", name="profile_page")
     */
    public function Index($username)
    {
        //Get user through usernames
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);
        

        return $this->render('profile_page/index.html.twig', [
            'controller_name' => 'ProfilePageController',
        ]);
    }


}
