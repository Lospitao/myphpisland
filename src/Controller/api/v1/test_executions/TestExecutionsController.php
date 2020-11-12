<?php

namespace App\Controller\api\v1\test_executions;


use App\Entity\Kata;
use PhpunitExecutionFromPhp\TestExecutor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

Class TestExecutionsController extends AbstractController {
    /**
     * @Route("api/v1/test_executions/{uuid}", name="TestExecutionsController")
     * @param $uuid
     * @return JsonResponse
     */
    function TestExecutions (Request $request, $uuid) {
        //Select kata from uuid
        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $uuid]);

        $editorCode=$request->request->get('code');
        $sampleTest = $kata->getTestCode();

        $projectRoot = $this->get('kernel')->getProjectDir();

        $temporaryFilesPath = $projectRoot . DIRECTORY_SEPARATOR . 'tmp' ;
        if ( ! is_dir($temporaryFilesPath) && ! mkdir($temporaryFilesPath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $temporaryFilesPath));
        }

        // Execute test
        $phpunitShellPath = $projectRoot . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phpunit';
        $phpunitBootstrapShellPath = $projectRoot . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        $testExecutor = new TestExecutor($temporaryFilesPath, $phpunitShellPath, $phpunitBootstrapShellPath);

        if ($editorCode == $sampleTest) {
            $isTestPassed = true;
            $title = "Passed test";
            $message= "You are right";
        }

        else {
            $isTestPassed = false;
            $title = "Test Failed";
            $message= "Keep trying";
        }

        $response = new JsonResponse([
            'isTestPassed' => $isTestPassed,
            'title' => $title,
            'message' => $message,

        ]);

        return $response;

    }
}