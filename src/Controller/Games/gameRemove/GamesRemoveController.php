<?php

namespace App\Controller\Games\gameRemove;
use App\Domain\Services\Games\RemoveGameFromRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class GamesRemoveController extends AbstractController
{

    private $entityManager;
    /**
     * @var RemoveGameFromRepositoryService
     */
    private $removeGameFromRepository;


    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/games/{gameUuid}/remove", name="games_remove")
     * @param $gameUuid
     */
    function index($gameUuid)
    {
        try{

            $this->removeGameFromRepository = new RemoveGameFromRepositoryService($this->entityManager);
            $this->showGameRemovalResult($gameUuid);

        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
        }
        return $this->redirectToRoute('admin_menu');
    }
    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        return $errorMessage;
    }

    private function showGameRemovalResult($gameUuid)
    {
        $this->addFlash("notice", $this->removeGameFromRepository->execute($gameUuid));
    }
}