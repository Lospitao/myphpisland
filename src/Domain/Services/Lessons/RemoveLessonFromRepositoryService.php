<?php
namespace App\Domain\Services\Lessons;
use App\Entity\Lesson;
use App\Entity\LessonKatas;


class RemoveLessonFromRepositoryService
{
    private $entityManager;
    private $lessonToRemoveFromRepository;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function execute($lessonUuid) {
        try {

            $this->lessonToRemoveFromRepository = $this->getLessonToRemoveFromRepository($lessonUuid);
            if ($this->isLessonEmpty()) {
                $this->removeLessonFromRepository();
                return $this->lessonHasBeenSuccessfullyRemovedMessage();
            }
            return $this->lessonIsNotEmptyMessage();

        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
        }

    }

    private function getLessonToRemoveFromRepository($lessonUuid)
    {
        return $this->entityManager
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $lessonUuid]);
    }

    private function removeLessonFromRepository()
    {
        $this->entityManager->remove($this->lessonToRemoveFromRepository);
        $this->entityManager->flush();

    }

    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage= $exception->getMessage();
        return $errorMessage;
    }

    private function isLessonEmpty()
    {
        return $this->entityManager
                ->getRepository(LessonKatas::class)
                ->findOneBy(['lesson' => $this->lessonToRemoveFromRepository->getId()]) === null;
    }

    private function lessonIsNotEmptyMessage()
    {
        return "Esta lección tiene una o más katas asociadas. Es necesario borrar dichas katas antes de poder borrar la lección.";

    }

    private function lessonHasBeenSuccessfullyRemovedMessage()
    {
        return "La lección se ha eliminado.";
    }
}
