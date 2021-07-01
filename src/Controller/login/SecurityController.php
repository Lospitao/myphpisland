<?php

namespace App\Controller\login;

use App\Domain\Services\FindGameSessionMilestoneService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $entityManager;
    private $urlGenerator;
    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->isUserAlreadyLoggedIn()) {
             $user = $this->getUser();
             $findGameSessionMilestoneService = new FindGameSessionMilestoneService($this->entityManager,$user, $this->urlGenerator);
             return new RedirectResponse($findGameSessionMilestoneService->execute());
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

}
