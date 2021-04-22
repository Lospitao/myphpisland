<?php
namespace App\Domain\Services\Stages;
use App\Entity\Stage;



class RemoveStageFromRepositoryService
{
    private $entityManager;
    private $stageToRemoveFromRepository;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;

    }
    public function execute($stageUuid) {
        try {

            $this->stageToRemoveFromRepository = $this->getStageToRemoveFromRepository($stageUuid);
                $this->removeStageFromRepository();
                return $this->stageHasBeenSuccessfullyRemovedMessage();


        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
        }

    }

    private function getStageToRemoveFromRepository($stageUuid)
    {
        return $this->entityManager
            ->getRepository(Stage::class)
            ->findOneBy(['uuid' => $stageUuid]);
    }

    private function removeStageFromRepository()
    {
        $this->entityManager->remove($this->stageToRemoveFromRepository);
        $this->entityManager->flush();

    }

    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage= $exception->getMessage();
        return $errorMessage;
    }

    private function stageHasBeenSuccessfullyRemovedMessage()
    {
        return "El escenario se ha eliminado.";
    }
}
