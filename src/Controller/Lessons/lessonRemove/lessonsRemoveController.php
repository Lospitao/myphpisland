<?php

namespace App\Controller\Lessons\lessonRemove;
use App\Domain\Services\Lessons\RemoveLessonFromRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class lessonsRemoveController extends AbstractController
{
    private $entityManager;
    /**
     * @var RemoveLessonFromRepositoryService
     */
    private $removeLessonFromRepository;
    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/lessons/{lessonUuid}/remove", name="lessons_remove")
     * @param $lessonUuid
     */
    function index($lessonUuid) {
        try {
            $this->removeLessonFromRepository = new RemoveLessonFromRepositoryService($this->entityManager);
            $this->showLessonRemovalResult($lessonUuid);
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

    private function showLessonRemovalResult($lessonUuid)
    {
        $this->addFlash("notice", $this->removeLessonFromRepository->execute($lessonUuid));
    }

}