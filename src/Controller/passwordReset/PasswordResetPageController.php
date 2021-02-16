<?php

namespace App\Controller\passwordReset;

use App\Entity\PasswordRecoveryRequest;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordResetPageController extends AbstractController
{
    var $enteredCode;
    var $enteredPassword;
    var $passwordRecoveryRequest;
    var $user;

    /**
     * @Route("/password-recovery/", name="password-recovery")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        try {
            $this->getValueOfEnteredCode($request);
            if ($this->enteredCode) {
                $this->lookForPasswordRecoveryRequestInDataBase();
                $this->checkIfPasswordRecoveryRequestExists();
                $this->getEnteredPassword($request);
                $this->findUserEntityToUpdate();
                //$this->checkIfPasswordIsValid(); **Conditions not specified yet (implement them in RegistrationController too)**
                $this->updateNewPassword($passwordEncoder);

                $this->addFlash('success', 'Su contraseña se ha reestablecido correctamente');

                return $this->redirect($this->generateUrl('app_login'));
            }


        } catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            error_log($ex->getMessage());
        }
        return $this->render('password_reset_page/index.html.twig', [
            'controller_name' => 'PasswordResetPageController',
        ]);
    }
    private function getValueOfEnteredCode(Request $request)
    {
        $this->enteredCode = $request->request->get('code_for_password_recovery');
    }
    private function lookForPasswordRecoveryRequestInDataBase()
    {
        $this->passwordRecoveryRequest = $this->getDoctrine()
            ->getRepository(PasswordRecoveryRequest::class)
            ->findOneBy(['resetPasswordCode' => $this->enteredCode]);
    }
    private function checkIfPasswordRecoveryRequestExists()
    {
        if (!$this->passwordRecoveryRequest) {
            throw new Exception("El código para restablecer la contraseña no es válido.");
        }
    }
    private function getEnteredPassword(Request $request)
    {
        $this->enteredPassword = $request->request->get('new_password');
    }
    private function findUserEntityToUpdate()
    {
        $userID=$this->passwordRecoveryRequest->getIdUser();
        $this->user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id' => $userID]);
    }
    private function updateNewPassword (UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->user->setPassword(
            $passwordEncoder->encodePassword($this->user, $this->enteredPassword)
        );
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->user);
        $entity_manager->flush();
    }




}
