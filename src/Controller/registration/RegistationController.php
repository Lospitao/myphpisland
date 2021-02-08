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
    private $appKernel;

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $username = $user->getUsername();
            $password = $user->getPassword();
            $user->setSignupDate(new \DateTime());
            $user->setUsername($username);
            $user->setPassword(
            $passwordEncoder->encodePassword($user, $password)
            );



            $entity_manager = $this->getDoctrine()->getManager();
            /**
             * @var UploadedFile $file
             */
            $file = $form['profilePic']->getData();


            if ($file) {
                /*give file a name*/
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();
                /*specify directory route*/
                $routeName=$this->getParameter('user_profile_pics_dir');
                /*include variable in route*/
                $destinationPath =  str_replace('username', $username, $routeName);
                /*Store it somewhere*/
                $file->move($destinationPath,
                $filename);
                $user->setProfilePic($filename);
            }
            $entity_manager->persist($user);
            $entity_manager->flush();

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('registation/index.html.twig', [
            'form' => $form->createView(),

        ]);


    }
}
