<?php

namespace App\Controller\profile;

use App\Entity\User;

use App\Form\ProfilePictureUpdateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class ProfilePageController extends AbstractController
{
    var $user;
    var $enteredCurrentPassword;
    var $enteredNewPassword;
    var $enteredRepeatPassword;
    var $profilePictureForm;
    var $profilePicFile;
    var $profilePictureFileName;
    var $destinationPath;


    /**
     * @Route("/profile/", name="profile")
     *
     */
    public function Index(Request $request, UserPasswordEncoderInterface $passwordEncoder, AuthenticationUtils $authenticationUtils )
    {
        try {
            /*passsword update*/
            $this->createProfilePictureForm();
            $this->getUserToUpdate( $authenticationUtils);
            $this->getValueOfEnteredCurrentPassword($request);
            $this->getValueOfEnteredNewPassword($request);
            $this->getValueOfEnteredRepeatedPassword($request);

            if ($this->enteredCurrentPassword && $this->enteredNewPassword && $this->enteredRepeatPassword) {
                $this->checkIfCurrentPasswordExists($passwordEncoder);
                $this->checkIfNewPasswordMatchesRepeatedPassword();
                $this->updateNewPassword($passwordEncoder);
                $this->persistNewDataToUserInDataBase();
                $this->createSuccessfulPasswordUpdateMessage();
            }
            /*profile picture update*/

            $this->handleProfilePictureForm($request);
            if ($this->profilePictureForm->isSubmitted()) {
                $this->getProfilePictureFile();
                $this->nameProfilePictureFile();
                $this->specifyDirectoryRouteForProfilePicture();
                $this->storeProfilePicture();
                $this->setProfilePictureInDataBase();
                $this->persistNewDataToUserInDataBase();
            }

            return $this->render('profile_page/index.html.twig', [
                'controller_name' => 'ProfilePageController',
                'profilePictureForm' => $this->profilePictureForm->createView(),
            ]);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return $this->render('profile_page/index.html.twig', [
                'controller_name' => 'ProfilePageController',
                'profilePictureForm' => $this->profilePictureForm->createView(),
            ]);
        }
    }

    private function getUserToUpdate(AuthenticationUtils $authenticationUtils)
    {
        $email = $authenticationUtils->getLastUsername();
        $this->user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }

    private function getValueOfEnteredCurrentPassword(Request $request)
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
        $isPasswordValid = $passwordEncoder->isPasswordValid($this->user, $this->enteredCurrentPassword);
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
    }
    private function persistNewDataToUserInDataBase()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->user);
        $entity_manager->flush();
    }
    private function createSuccessfulPasswordUpdateMessage()
    {
        $this->addFlash('success', 'Su contraseña se ha actualizado correctamente');
    }

    private function createProfilePictureForm()
    {
        $this->profilePictureForm = $this->createForm(ProfilePictureUpdateType::class, $this->user);
    }

    private function handleProfilePictureForm(Request $request)
    {
        $this->profilePictureForm->handleRequest($request);
    }

    private function getProfilePictureFile()
    {
        /**
         * @var UploadedFile $file
         */
        $this->profilePicFile = $this->profilePictureForm['profilePic']->getData();

    }

    private function nameProfilePictureFile()
    {
        $this->profilePictureFileName = md5(uniqid()) . '.' . $this->profilePicFile->guessClientExtension();
    }

    private function specifyDirectoryRouteForProfilePicture()
    {
        $this->routeName=$this->getParameter('user_profile_pics_dir');
        $this->destinationPath =  str_replace('username', $this->user->getUsername(), $this->routeName);
    }

    private function storeProfilePicture()
    {
        $this->profilePicFile->move($this->destinationPath,
            $this->profilePictureFileName);
    }

    private function setProfilePictureInDataBase()
    {
        $this->user->setProfilePic($this->profilePictureFileName);
    }


}