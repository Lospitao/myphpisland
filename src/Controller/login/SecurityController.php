<?php

namespace App\Controller\login;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->isUserAlreadyLoggedIn()) {
             $this->throwAlreadyLoggedInUserMessage();
             return $this->redirectToRoute('profile');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $username = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $username, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('app_login');
    }

    private function isUserAlreadyLoggedIn()
    {
        return $this->getUser();
    }
    private function throwAlreadyLoggedInUserMessage()
    {
        $this->addFlash('success', 'Ya se ha iniciado sesión. Es necesario salir de la sesión para acceder a las páginas de registro e inicio de sesión.');
    }
}
