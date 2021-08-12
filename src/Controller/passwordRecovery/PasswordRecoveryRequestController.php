<?php

namespace App\Controller\passwordRecovery;

use App\Entity\PasswordRecoveryRequest;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
class PasswordRecoveryRequestController extends AbstractController
{

    var $enteredEmail;
    var $emailSender;
    var $user;
    var $passwordRecoveryCode;
    var $subject;
    var $message;
    var $email;
    /**
     * @Route("/forgot_my_password", name="PasswordRecoveryRequest")
     * @param Request $request
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        try {
            $this->enteredEmail = $request->request->get('email_for_password_recovery');
            if ($this->enteredEmail) {
                $this->getUserRequestingPasswordRecovery();
                $this->checkIfUserIsFound();
                $this->generatePasswordGenerationCode();
                $this->setEmailParameters();
                $this->emailCodeForPasswordRecovery($mailer);
                $this->addFlash('success',
                    'Se ha enviado un correo electrónico con el código para restablecer su contraseña. Si no está en la bandeja de entrada revise la carpeta de SPAM');

                return $this->redirectToRoute('password-recovery');
            }
            return $this->render('password_recovery_request/index.html.twig', [
                'controller_name' => 'PasswordRecoveryRequestController',
            ]);
        } catch (TransportExceptionInterface $exception) {
            $errorMessage=$exception->getMessage();
            $this->addFlash('error', $errorMessage);
            return $this->render('password_recovery_request/index.html.twig', [
                'controller_name' => 'PasswordRecoveryRequestController',
            ]);
            }
    }
    private function getUserRequestingPasswordRecovery()
    {
        $this->user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['email' => $this->enteredEmail]);
    }
    private function checkIfUserIsFound()
    {
        if (!$this->user) {
            throw new Exception("El correo electrónico no coincide con ningún usuario registrado");
        }
    }
    private function generatePasswordGenerationCode()
    {
        $userId = $this->user->getId();

        $passwordRecoveryRequest = new PasswordRecoveryRequest;
        $passwordRecoveryRequest->setCreatedAt(new \DateTime());
        $passwordRecoveryRequest->setIdUser($userId);
        $this->passwordRecoveryCode=Uuid::v4();
        $passwordRecoveryRequest->setResetPasswordCode($this->passwordRecoveryCode);
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($passwordRecoveryRequest);
        $entity_manager->flush();
    }

    private function setEmailParameters()
    {

        $this->emailSender = "myphpisland@gmail.com";
        $this->subject = "Solicitud para restablecer la contraseña";
        $this->message = "
        <html lang=\"en\">
        <head>
        <title>Solicitud para restablecer la contraseña</title>
        </head>
        <body>
        <p>Estimado usuario,</p><br>
        <p>se ha recibido una solicitud para restablecer su contraseña. Para poder llevarlo a cabo debe pulsar en el siguiente enlace:</p><br>
        <a href=\"/password-recovery/\">Restablecer contraseña </a><br>
        <p>e introducir el código {$this->passwordRecoveryCode}</p>
        <p>Un saludo.</p>
        </body>
        </html>
        ";

    }
    private function emailCodeForPasswordRecovery($mailer)
    {

        $this->email = (new Email())
            ->from($this->emailSender)
            ->to($this->enteredEmail)
            ->bcc($this->emailSender)
            ->subject($this->subject)
            ->html($this->message);
        $mailer->send($this->email);


    }

}
