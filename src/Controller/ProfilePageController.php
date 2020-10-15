<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;


class ProfilePageController extends AbstractController
{
    /**
     * @Route("/profile_page/{username}", name="profile_page")
     */
    public function Index($username)
    {
        //Get user through usernames
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);
        //If form is submitted
/*
        //Get password registered in DataBase
        $registered_password = $user->getPassword();
        //Get password input values
        $current_password = $request->request->get('current_password');
        $new_password = $request->request->get('new_password');
        $repeat_password = $request->request->get('repeat_password');
        //Encode password specified in current password field
        $encoded_current_password = $passwordEncoder->encodePassword($user, $current_password);
        //Encode password specified in new password field
        $encoded_new_password = $passwordEncoder->encodePassword($user, $new_password);
        //If current_password exists in database
        If ($registered_password == $encoded_current_password) {
            //If new password is != current password
            if ($encoded_current_password != $encoded_new_password) {
                //If repeat password == new password
                if ($new_password == $repeat_password) {
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
            else $result_message = "Usa una contraseña nueva";
        }
        else $result_message = "La contraseña actual especificada no existe";

        function phpAlert($result_message) {
            echo '<script type="text/javascript">alert("' . $result_message . '")</script>';
        }

*/

        return $this->render('profile_page/index.html.twig', [
            'controller_name' => 'ProfilePageController',
        ]);
    }


}
