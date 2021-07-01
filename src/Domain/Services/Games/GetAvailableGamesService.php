<?php
namespace App\Domain\Services\Games;
use App\Entity\Game;
class GetAvailableGamesService
{
    private $availableGames;
    private $games;
    private $game;
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function execute ()
    {
        try {
            $this->loadAllGames();
            foreach($this->games as $this->game) {
             $this->availableGames = $this->createAvailableGamesArray();
            }
            return $this->availableGames;
        } catch (\Exception $exception) {
            return $this->createErrorMessage($exception);
        }
    }
    private function loadAllGames()
    {
        $this->games = $this->entityManager
            ->getRepository(Game::class)
            ->findAll();
    }

    private function createAvailableGamesArray()
    {
        $this->availableGames[$this->game->getUuid()] = [
            'title' => $this->game->getTitle(),
            'uuid' => $this->game->getUuid(),
        ];
        return $this->availableGames;
    }
    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        return $errorMessage;
    }



}