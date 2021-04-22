<?php
namespace App\Domain\Services\Katas;
use App\Entity\Kata;
class GetAvailableKatasService
{

    private $availableKatas;
    private $kata;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function execute () {
        try {
            $katasArray = $this->findAllKatas();
            foreach($katasArray as $this->kata) {
                $this->availableKatas = $this->createAvailableKatasArray();
            }
            return $this->availableKatas;
        } catch (\Exception $exception) {
            return $this->createErrorMessage($exception);
        }
}

    private function findAllKatas()
    {
        return $this->entityManager
            ->getRepository(Kata::class)
            ->findAll();
    }
    private function createAvailableKatasArray()
    {
        $this->availableKatas[$this->kata->getUuid()] = [
            'title' => $this->kata->getKataTitle(),
            'uuid' => $this->kata->getUuid(),
        ];
        return $this->availableKatas;
    }
    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        return $errorMessage;
    }

}