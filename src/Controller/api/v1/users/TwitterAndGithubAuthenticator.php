<?php

namespace App\Controller\api\v1\users;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TwitterAndGithubAuthenticator extends AbstractController {
    /**
     * @Route("api/v1/users/{username}", name="GithubAuthentication")
     */
    function GithubAuthentication () {

        $response = new JsonResponse([
            'result_message' => 'correct'
        ]);

        return $response;
    }
}