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
        try {
            $this->generateForm($request);
            if ($this->form->isSubmitted() && $this->form->isValid()) {
                $this->createNewUserEntityService($passwordEncoder);
                $this->createNewGameSessionService();
                /*    $this->createNewGameHistoryEntryService(); */
                $this->createSuccessfullyRegisteredNewUser();
                return $this->redirectToRoute('app_login');
            }
            return $this->render('registation/index.html.twig', [
                'form' => $this->form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
            return $this->render('registation/index.html.twig', [
                'form' => $this->form->createView(),
            ]);
        }
        return $this->render('next_page/index.html.twig', [
            'controller_name' => 'NextPageController',
        ]);
    }
}
