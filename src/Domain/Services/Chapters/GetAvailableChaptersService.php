<?php
namespace App\Domain\Services\Chapters;
use App\Entity\Chapter;
class GetAvailableChaptersService
{
    private $availableChapters;
    private $chapter;
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function execute ()
    {
        try {
            $chaptersArray = $this->findAllChapters();
            foreach($chaptersArray as $this->chapter) {
             $this->availableChapters = $this->createAvailableChaptersArray();
            }
            return $this->availableChapters;
        } catch (\Exception $exception) {
            return $this->createErrorMessage($exception);
        }
    }
    private function findAllChapters()
    {
        return $this->entityManager
            ->getRepository(Chapter::class)
            ->findAll();
    }
    private function createAvailableChaptersArray()
    {
        $this->availableChapters[$this->chapter->getUuid()] = [
            'title' => $this->chapter->getTitle(),
            'uuid' => $this->chapter->getUuid(),
        ];
        return $this->availableChapters;
    }
    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        return $errorMessage;
    }


}