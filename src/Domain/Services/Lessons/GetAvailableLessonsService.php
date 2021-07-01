<?php
namespace App\Domain\Services\Lessons;
use App\Entity\Lesson;
class GetAvailableLessonsService
{
    private $availableLessons;
    private $lesson;
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function execute ()
    {
        try {
            $lessonsArray = $this->findAllLessons();
            foreach($lessonsArray as $this->lesson) {
                $this->availableLessons = $this->createAvailableLessonsArray();
            }
            return $this->availableLessons;
        } catch (\Exception $exception) {
            return $this->createErrorMessage($exception);
        }
    }
    private function findAllLessons()
    {
        return $this->entityManager
            ->getRepository(Lesson::class)
            ->findAll();
    }

    private function createAvailableLessonsArray()
    {
        $this->availableLessons[$this->lesson->getUuid()] = [
            'title' => $this->lesson->getTitle(),
            'uuid' => $this->lesson->getUuid(),
        ];
        return $this->availableLessons;
    }
    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        return $errorMessage;
    }

}