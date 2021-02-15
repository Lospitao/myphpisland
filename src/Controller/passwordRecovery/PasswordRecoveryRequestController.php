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

class PasswordRecoveryRequestController extends AbstractController
{

    var $enteredEmail;
    var $emailSender;
    var $user;
    var $passwordRecoveryCode;
    var $subject;
    var $message;
    var $headers;
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
            }
            return $this->render('password_recovery_request/index.html.twig', [
                'controller_name' => 'PasswordRecoveryRequestController',
            ]);
        }catch (\Doctrine\ORM\EntityNotFoundException $ex) {
                error_log($ex->getMessage());
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
        $passwordRecoveryCode=Uuid::v4();
        $passwordRecoveryRequest->setResetPasswordCode($passwordRecoveryCode);
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($passwordRecoveryRequest);
        $entity_manager->flush();
    }

    private function setEmailParameters()
    {
        $this->emailSender = "myphpisland@gmail.com";
        $this->subject = "Solicitud para restablecer la contraseña";
        $this->message = "
        <html>
        <head>
        <title>Solicitud para restablecer la contraseña</title>
        </head>
        <body>
        <p>Estimado usuario,</p><br>
        <p>se ha recibido una solicitud para restablecer su contraseña. Para poder llevarlo a cabo debe pulsar en el siguiente enlace:</p><br>
        <a href=\"password-recovery/\" {$this->passwordRecoveryCode}>Restablecer contraseña </a><br>
        <p>Un saludo.</p>
        </body>
        </html>
        ";
        $this->headers = "MIME-Version: 1.0" . "\r\n";
        $this->headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    }
    private function emailCodeForPasswordRecovery($mailer)
    {
        $email = (new Email())
            ->from($this->emailSender)
            ->to($this->enteredEmail)
            ->bcc($this->emailSender)
            ->subject($this->subject)
            ->html($this->message);

        $mailer->send($email);
    }

}
