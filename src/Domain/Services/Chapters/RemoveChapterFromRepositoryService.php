<?php
namespace App\Domain\Services\Chapters;
use App\Entity\Chapter;
use App\Entity\ChapterElement;

class RemoveChapterFromRepositoryService
{
    private $entityManager;
    private $chapterToRemoveFromRepository;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;

    }
    public function execute($chapterUuid) {
        try {

            $this->chapterToRemoveFromRepository = $this->getChapterToRemoveFromRepository($chapterUuid);
            if ($this->isChapterEmpty()) {
                $this->removeChapterFromRepository();
                return $this->ChapterHasBeenSuccessfullyRemovedMessage();
            }
            return $this->ChapterIsNotEmptyMessage();

        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
        }

    }

    private function getChapterToRemoveFromRepository($chapterUuid)
    {
        return $this->entityManager
            ->getRepository(Chapter::class)
            ->findOneBy(['uuid' => $chapterUuid]);
    }

    private function removeChapterFromRepository()
    {
        $this->entityManager->remove($this->chapterToRemoveFromRepository);
        $this->entityManager->flush();

    }

    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage= $exception->getMessage();
        return $errorMessage;
    }

    private function isChapterEmpty()
    {
        return $this->entityManager
                ->getRepository(ChapterElement::class)
                ->findOneBy(['chapterId' => $this->chapterToRemoveFromRepository->getId()]) === null;
    }

    private function chapterIsNotEmptyMessage()
    {
        return "Este capítulo tiene uno o más escenarios o lecciones asociados. Es necesario borrar dichos elementos antes de poder borrar el capítulo.";

    }

    private function ChapterHasBeenSuccessfullyRemovedMessage()
    {
        return "El capítulo se ha eliminado.";
    }
}
