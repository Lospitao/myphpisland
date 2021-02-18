<?php

namespace App\Controller\profile;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class ProfilePageController extends AbstractController
{
    var $user;
    var $enteredCurrentPassword;
    var $enteredNewPassword;
    var $enteredRepeatPassword;
    var $encodedEnteredCurrentPassword;
    /**
     * @Route("/profile_page/{username}", name="profile_page")
     */
    public function Index(Request $request, UserPasswordEncoderInterface $passwordEncoder, $username)
    {
        try {

            $this->getUserToUpdate($username);
            $this->getValueOfEnteredCurrentPassword($request, $passwordEncoder);
            $this->getValueOfEnteredNewPassword($request);
            $this->getValueOfEnteredRepeatedPassword($request);
            if($this->enteredCurrentPassword && $this->enteredNewPassword && $this->enteredRepeatPassword) {
                $this->checkIfCurrentPasswordExists($passwordEncoder);
                $this->checkIfNewPasswordMatchesRepeatedPassword();
                $this->updateNewPassword($passwordEncoder);
                $this->addFlash('success', 'Su contraseña se ha actualizado correctamente');
            }
            return $this->render('profile_page/index.html.twig', [
                'controller_name' => 'ProfilePageController',
            ]);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return $this->render('profile_page/index.html.twig', [
                'controller_name' => 'ProfilePageController',
            ]);
        }
    }

    private function getUserToUpdate($username)
    {
        $this->user= $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);
    }

    private function getValueOfEnteredCurrentPassword(Request $request, $passwordEncoder)
    {
        $this->enteredCurrentPassword = $request->request->get('current_password');
    }

    private function getValueOfEnteredNewPassword(Request $request)
    {
        $this->enteredNewPassword = $request->request->get('new_password');
    }

    private function getValueOfEnteredRepeatedPassword(Request $request)
    {
        $this->enteredRepeatPassword = $request->request->get('repeat_password');
    }

    private function checkIfCurrentPasswordExists($passwordEncoder)
    {
        $isPasswordValid =$passwordEncoder->isPasswordValid($this->user, $this->enteredCurrentPassword);
        if (!$isPasswordValid) {
            throw new Exception("La contraseña actual introducida no es correcta.");
        }
    }

    private function checkIfNewPasswordMatchesRepeatedPassword()
    {
        if ($this->enteredNewPassword !== $this->enteredRepeatPassword) {
            throw new Exception("Debe especificar la misma contraseña en los campos de nueva contraseña y repetir contraseña.");
        }
    }

    private function updateNewPassword(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->user->setPassword(
            $passwordEncoder->encodePassword($this->user, $this->enteredNewPassword)
        );
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->user);
        $entity_manager->flush();
    }
}
