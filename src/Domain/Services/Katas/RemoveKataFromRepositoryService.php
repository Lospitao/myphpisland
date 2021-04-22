<?php
namespace App\Domain\Services\Katas;
use App\Entity\Kata;



class RemoveKataFromRepositoryService
{
    private $entityManager;
    private $kataToRemoveFromRepository;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function execute($kataUuid) {
        try {

            $this->kataToRemoveFromRepository = $this->getKataToRemoveFromRepository($kataUuid);
            $this->removeKataFromRepository();
            return $this->kataHasBeenSuccessfullyRemovedMessage();


        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
        }

    }

    private function getKataToRemoveFromRepository($kataUuid)
    {
        return $this->entityManager
            ->getRepository(Kata::class)
            ->findOneBy(['uuid' => $kataUuid]);
    }

    private function removeKataFromRepository()
    {
        $this->entityManager->remove($this->kataToRemoveFromRepository);
        $this->entityManager->flush();

    }

    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage= $exception->getMessage();
        return $errorMessage;
    }

    private function kataHasBeenSuccessfullyRemovedMessage()
    {
        return "La kata se ha eliminado.";
    }
}
