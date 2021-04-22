<?php
namespace App\Domain\Services\Games;
use App\Entity\Game;
use App\Entity\GameChapters;


class RemoveGameFromRepositoryService
{
    private $entityManager;
    private $gameToRemoveFromRepository;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;

    }
    public function execute($gameUuid) {
        try {

            $this->gameToRemoveFromRepository = $this->getGameToRemoveFromRepository($gameUuid);
            if ($this->isGameEmpty()) {
                $this->removeGameFromRepository();
                return $this->gameHasBeenSuccessfullyRemovedMessage();
            }
            return $this->gameIsNotEmptyMessage();

        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
        }

    }

    private function getGameToRemoveFromRepository($gameUuid)
    {
        return $this->entityManager
            ->getRepository(Game::class)
            ->findOneBy(['uuid' => $gameUuid]);
    }

    private function removeGameFromRepository()
    {
        $this->entityManager->remove($this->gameToRemoveFromRepository);
        $this->entityManager->flush();

    }

    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage= $exception->getMessage();
        return $errorMessage;
    }

    private function isGameEmpty()
    {
            return $this->entityManager
            ->getRepository(GameChapters::class)
            ->findOneBy(['game' => $this->gameToRemoveFromRepository->getId()]) === null;
    }

    private function gameIsNotEmptyMessage()
    {
        return "Este juego tiene uno o más capítulos asociados. Es necesario borrar dichos capítulos antes de poder borrar el juego.";

    }

    private function gameHasBeenSuccessfullyRemovedMessage()
    {
        return "El juego se ha eliminado.";
    }
}
