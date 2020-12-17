<?php

namespace App\Controller\api\v1\test_executions;


use App\Entity\Kata;
use Exception;
use PhpunitExecutionFromPhp\TestExecutionStatus;
use PhpunitExecutionFromPhp\TestExecutor;
use PhpunitExecutionFromPhp\TestResult;
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
        try {

            //Select kata from uuid
            $kata = $this->getDoctrine()
                ->getRepository(Kata::class)
                ->findOneBy(['uuid' => $uuid]);

            $editorCode = $request->request->get('code');

            $projectRoot = $this->getParameter('kernel.project_dir');

            $temporaryFilesPath = $projectRoot . DIRECTORY_SEPARATOR . 'tmp' ;
            if ( ! is_dir($temporaryFilesPath) && (! mkdir($temporaryFilesPath))) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $temporaryFilesPath));
            }

            // Execute test
            $phpunitShellPath = $projectRoot . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phpunit';
            $phpunitBootstrapShellPath = $projectRoot . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
            $testExecutor = new TestExecutor($temporaryFilesPath .  DIRECTORY_SEPARATOR, $phpunitShellPath, $phpunitBootstrapShellPath);

            // Create kata test file from string
            $kataTestCode = <<<'EOD'
<?php 
namespace KataTestExecutions;

use PHPUnit\Framework\TestCase;


class AlwaysPassedTest extends TestCase
{
    public function testAlwaysPassed()
    {
        $alwaysPassedSourceCode = new AlwaysPassedSourceCode();
        $semanticNames = $alwaysPassedSourceCode->getSemanticNames();
        $areNamesValid = ($semanticNames['Nombre de usuario'] === 'username')
            && ($semanticNames['Correo electrónico'] === 'email')
            && ($semanticNames['contraseña'] === 'password');

        $this->assertTrue($areNamesValid);
    }
}

EOD;

            $kataTestExecutionsPath = $projectRoot . DIRECTORY_SEPARATOR . 'tmp' .  DIRECTORY_SEPARATOR ;
            $kataTestPath = $kataTestExecutionsPath . 'AlwaysPassedTest.php';
            $isSaved = file_put_contents($kataTestPath, $kataTestCode);
            if ($isSaved === false) {
                throw new Exception('Kata test file has not could to be created.');
            }

            // Execute the test
            $testResult = $testExecutor->execute($kataTestPath, $editorCode);

            if ($this->hasAnErrorHadDuringTheTestExecution($testResult)) {
                throw new Exception('Se ha producido un error al ejecutar el test.');
            }

            if ($this->hasTestFailed($testResult)) {
                $response = $this->getFailResponse();

                return $response;
            }

            $response = $this->getSuccessResponse();

            return $response;
        } catch (Exception $exception) {
            $response = new JsonResponse([
                'error' => 'Ha petao!' . $exception->getMessage()
            ], 409);

            return $response;
        }

    }

    /**
     * @param TestResult $testResult
     * @return bool
     */
    private function hasAnErrorHadDuringTheTestExecution(TestResult $testResult): bool
    {
        return $testResult->getTestExecutionStatusUuid() === TestExecutionStatus::UUID_ERROR;
    }

    /**
     * @param TestResult $testResult
     * @return bool
     */
    private function hasTestFailed(TestResult $testResult): bool
    {
        return $testResult->getTestExecutionStatusUuid() === TestExecutionStatus::UUID_FAIL;
    }

    /**
     * @return JsonResponse
     */
    private function getFailResponse(): JsonResponse
    {
        $isTestPassed = false;
        $title = "Test Failed";
        $message = "Keep trying";
        $response = new JsonResponse([
            'isTestPassed' => $isTestPassed,
            'title' => $title,
            'message' => $message,

        ]);
        return $response;
    }

    /**
     * @return JsonResponse
     */
    private function getSuccessResponse(): JsonResponse
    {
        $isTestPassed = true;
        $title = "Passed test";
        $message = "You are right";

        $response = new JsonResponse([
            'isTestPassed' => $isTestPassed,
            'title' => $title,
            'message' => $message,

        ]);
        return $response;
    }
}