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
        //Get password registered in DataBase
        $registered_password = $user->getPassword();
        //Get password input values
        $currentPassword = $request->request->get('current_password');
        $newPassword = $request->request->get('new_password');
        $repeatPassword = $request->request->get('repeat_password');
        //If current_password is registered password
        $isPasswordValid =$passwordEncoder->isPasswordValid($user, $currentPassword);
        If ($isPasswordValid) {
                //If repeat password == new password
                if ($newPassword == $repeatPassword) {
                    //Encode new password
                    $encodedNewPassword = $passwordEncoder->encodePassword($user, $newPassword);
                    //Set password to new password
                    $user->setPassword($encodedNewPassword);
                    //Set success message
                    $resultMessage = "¡Bien hecho pirata! Has cambiado la contraseña con éxito";
                    //Persist to database
                    $entity_manager = $this->getDoctrine()->getManager();
                    $entity_manager->persist($user);
                    $entity_manager->flush();
                }
                else $resultMessage = "Repite la misma contraseña";
        }
        else $resultMessage = "La contraseña actual especificada no existe";

        $response = new JsonResponse([
            'result_message' => $resultMessage,
        ]);

        return $response;
    }
}