<?php

namespace App\Controller\Stages\stageRemove;
use App\Domain\Services\Stages\RemoveStageFromRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class stagesRemoveController extends AbstractController
{

    private $entityManager;
    /**
     * @var RemoveStageFromRepositoryService
     */
    private $removeStageFromRepository;


    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;

    }
    /**
     * @Route("/stages/{stageUuid}/remove", name="stages_remove")
     * @param $stageUuid
     */
    function index($stageUuid)
    {
        try{

            $this->removeStageFromRepository = new RemoveStageFromRepositoryService($this->entityManager);
            $this->showGameRemovalResult($stageUuid);

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
        $this->addFlash("notice", $this->removeStageFromRepository->execute($gameUuid));
    }
}