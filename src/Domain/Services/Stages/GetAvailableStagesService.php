<?php
namespace App\Domain\Services\Stages;
use App\Entity\Stage;
class GetAvailableStagesService
{
    private $availableStages;
    private $stage;
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function execute ()
    {
        try {
            $stagesArray = $this->findAllStages();
            foreach($stagesArray as $this->stage) {
                $this->availableStages = $this->createAvailableStagesArray();
            }
            return $this->availableStages;
        } catch (\Exception $exception) {
            return $this->createErrorMessage($exception);
        }
    }
    private function findAllStages()
    {
        return $this->entityManager
            ->getRepository(Stage::class)
            ->findAll();
    }
    private function createAvailableStagesArray()
    {
        $this->availableStages[$this->stage->getUuid()] = [
            'title' => $this->stage->getTitle(),
            'uuid' => $this->stage->getUuid(),
        ];
        return $this->availableStages;
    }
    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        return $errorMessage;
    }
}