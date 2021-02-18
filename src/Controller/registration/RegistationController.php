<?php

namespace App\Controller\registration;

use App\Entity\User;
use App\Form\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistationController extends AbstractController
{

    var $user;
    var $form;
    var $profilePicFile;
    var $filename;
    var $routeName;
    var $destinationPath;
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        try {
            $this->createNewUser();
            $this->generateForm($request);
            if ($this->form->isSubmitted() && $this->form->isValid()) {
                $this->setSignupDate();
                $this->setEncodedPassword($passwordEncoder);
                $this->getProfilePicture();
                if ($this->profilePicFile) {
                    $this->nameProfilePicFile();
                    $this->specifyProfilePicRoute();
                    $this->includeVariableInRoute();
                    $this->storeProfilePicFile();
                    $this->recordPictureInDataBase();
                }
                $this->persistNewUserToDataBase();
                $this->addFlash('success', 'Se ha registrado con éxito');
                return $this->redirectToRoute('app_login');
            }
            return $this->render('registation/index.html.twig', [
                'form' => $this->form->createView(),
            ]);
        } catch (\Exception $exception) {
            $errorMessage=$exception->getMessage();
            $this->addFlash('error', $errorMessage);
            return $this->render('registation/index.html.twig', [
                'form' => $this->form->createView(),
            ]);
        }

    }
    private function createNewUser()
    {
        $this->user = new User();
    }
    private function generateForm($request)
    {
        $this->form = $this->createForm(UserRegistrationType::class, $this->user);
        $this->form->handleRequest($request);
    }
    private function setSignupDate()
    {
        $this->user->setSignupDate(new \DateTime());
    }
    private function setEncodedPassword($passwordEncoder)
    {
        $this->user->setPassword(
            $passwordEncoder->encodePassword(
                $this->user,
                $this->form->get('plainPassword')->getData()
            )
        );
    }
     private function getProfilePicture() {
         /**
          * @var UploadedFile $file
          */
         $this->profilePicFile = $this->form['profilePic']->getData();

     }
    private function nameProfilePicFile()
    {
        $this->filename = md5(uniqid()) . '.' . $this->profilePicFile->guessClientExtension();
    }
    private function specifyProfilePicRoute ()
    {
        $this->routeName=$this->getParameter('user_profile_pics_dir');
    }
    private function includeVariableInRoute()
    {
        $this->destinationPath =  str_replace('username', $this->user->getUsername(), $this->routeName);
    }
    private function storeProfilePicFile()
    {
        $this->profilePicFile->move($this->destinationPath,
            $this->filename);
    }
    private function recordPictureInDataBase () {
        $this->user->setProfilePic($this->filename);
    }
    private function persistNewUserToDataBase()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->user);
        $entityManager->flush();
    }
}
