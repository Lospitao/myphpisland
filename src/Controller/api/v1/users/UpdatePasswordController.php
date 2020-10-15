<?php

namespace App\Controller\api\v1\users;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

Class UpdatePasswordController extends AbstractController {
    /**
     * @Route("api/v1/users/{username}", name="UpdatePasswordController")
     * @param Request $request
     * @param $username
     * @param $passwordEncoder
     * @return JsonResponse
     */
    function UpdatePassword(Request $request, $username, UserPasswordEncoderInterface $passwordEncoder) {
        //Get user through usernames
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);
        $name = $user->getName();
        //Get password registered in DataBase
        $registered_password = $user->getPassword();
        //Get password input values
        $current_password = $request->request->get('current_password');
        $new_password = $request->request->get('new_password');
        $repeat_password = $request->request->get('repeat_password');
        /*
        //Encode password specified in current password field
        $encoded_current_password = $passwordEncoder->encodePassword($user, $current_password);
        //Encode password specified in new password field
        $encoded_new_password = $passwordEncoder->encodePassword($user, $new_password);
        */
        //If current_password is registered password
        If ($current_password->passwordEncoder->isPasswordValid($user, $registered_password)) {
                //If repeat password == new password
                if ($new_password == $repeat_password) {
                    //Encode new password
                    $encoded_new_password = $passwordEncoder->encodePassword($user, $new_password);
                    //Set password to new password
                    $user->setPassword($encoded_new_password);
                    //Set success message
                    $result_message = "¡Bien hecho pirata! Has cambiado la contraseña con éxito";
                    //Persist to database
                    $entity_manager = $this->getDoctrine()->getManager();
                    $entity_manager->persist($user);
                    $entity_manager->flush();
                }
                else $result_message = "Repite la misma contraseña";
        }
        else $result_message = "La contraseña actual especificada no existe";

        $response = new JsonResponse([
            'result_message' => $result_message,
        ]);

        return $response;
    }
}