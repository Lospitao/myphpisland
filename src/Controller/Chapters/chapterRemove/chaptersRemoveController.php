<?php

namespace App\Controller\Chapters\chapterRemove;
use App\Domain\Services\Chapters\RemoveChapterFromRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class chaptersRemoveController extends AbstractController
{

    private $entityManager;
    /**
     * @var RemoveChapterFromRepositoryService
     */
    private $removeChapterFromRepository;


    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;

    }
    /**
     * @Route("/chapters/{chapterUuid}/remove", name="chapters_remove")
     * @param $chapterUuid
     */
    function index($chapterUuid)
    {
        try{

            $this->removeChapterFromRepository = new RemoveChapterFromRepositoryService($this->entityManager);
            $this->showChapterRemovalResult($chapterUuid);

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

    private function showChapterRemovalResult($chapterUuid)
    {
        $this->addFlash("notice", $this->removeChapterFromRepository->execute($chapterUuid));
    }
}