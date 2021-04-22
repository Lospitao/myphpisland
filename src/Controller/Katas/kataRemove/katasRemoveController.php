<?php

namespace App\Controller\Katas\kataRemove;
use App\Domain\Services\Katas\RemoveKataFromRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class katasRemoveController extends AbstractController
{
    private $entityManager;
    /**
     * @var RemoveKataFromRepositoryService
     */
    private $removeKataFromRepository;


    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/katas/{kataUuid}/remove", name="katas_remove")
     * @param $kataUuid
     */
    function index($kataUuid)  {
        try{

            $this->removeKataFromRepository = new RemoveKataFromRepositoryService($this->entityManager);
            $this->showKataRemovalResult($kataUuid);

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

    private function showKataRemovalResult($kataUuid)
    {
        $this->addFlash("notice", $this->removeKataFromRepository->execute($kataUuid));
    }

}