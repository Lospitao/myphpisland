<?php

namespace App\Controller\stageCreationAndView;

use App\Entity\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class StagesController extends AbstractController
{
    var $newStageUuid;
    var $createdStage;
    var $stageToLoad;
    /**
     * @Route("/stages/create", name="stages_create")
     */
    public function stagescreate() {
        try {
            $this->createNewStageService();
            $this->persistToRepository();
            $this->createStageCreationSuccessMessage();

            return $this->redirectToRoute('stages_editor', [
                'stageUuid' => $this->newStageUuid]);
        } catch (\Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }
    }
    /**
     * @Route("/stages/{stageUuid}", name="stages")
     * @param $stageUuid
     */
    public function index($stageUuid)
    {
        try {
            $this->setStageToLoadFromDatabase($stageUuid);
            $this->checkIfStageToLoadExists();
            $stageViewResponse = $this->createStageViewResponse($stageUuid);
            return $stageViewResponse;
        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
            return $this->redirectToRoute('stages_create');
        }

    }

    private function createNewStageService()
    {
        $this->createNewEntity();
        $this->setUuid();
    }

    private function createNewEntity()
    {
        $this->createdStage = new Stage();
    }

    private function setUuid()
    {
        $this->newStageUuid = Uuid::v4();
        $this->createdStage->setUuid($this->newStageUuid);
    }

    private function persistToRepository()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->createdStage);
        $entity_manager->flush();
    }

    private function createStageCreationSuccessMessage()
    {
        $this->addFlash('success', 'Edite el nuevo escenario');
    }

    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }

    private function setStageToLoadFromDatabase($stageUuid)
    {
        $this->stageToLoad = $this->getDoctrine()
            ->getRepository(Stage::class)
            ->findOneBy(['uuid' => $stageUuid]);
    }
    private function createStageViewResponse($stageUuid)
    {
        return $this->render('stages/index.html.twig', [
            'controller_name' => 'StagesController',
            'stageUuid' => $stageUuid,
            'stageTitle' => $this->stageToLoad->getTitle(),
            'stageAmbientSound' => $this->stageToLoad->getAmbientSound(),
            'stageDialog' => $this->stageToLoad->getDialog(),
            'stageBackgroundImage' => $this->stageToLoad->getBackgroundImage(),
        ]);
    }

    private function checkIfStageToLoadExists()
    {
        if (!$this->stageToLoad) {
            throw new Exception("El escenario especificado no existe. Cree un nuevo escenario");
        }
    }

    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        $this->addFlash('error', $errorMessage);
    }

}
