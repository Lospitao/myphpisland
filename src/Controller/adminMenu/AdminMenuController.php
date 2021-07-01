<?php

namespace App\Controller\adminMenu;

use App\Domain\Services\Chapters\GetAvailableChaptersService;
use App\Domain\Services\Games\GetAvailableGamesService;
use App\Domain\Services\Katas\GetAvailableKatasService;
use App\Domain\Services\Lessons\GetAvailableLessonsService;
use App\Domain\Services\Stages\GetAvailableStagesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMenuController extends AbstractController
{
    private $availableKatas;
    private $availableLessons;
    private $availableStages;
    private $availableChapters;
    private $availableGames;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/admin/menu", name="admin_menu")
     */
    public function index(): Response
    {
        try {

            $this->availableKatas = new GetAvailableKatasService($this->entityManager);
            $this->availableLessons = new GetAvailableLessonsService($this->entityManager);
            $this->availableStages = new GetAvailableStagesService($this->entityManager);
            $this->availableChapters = new GetAvailableChaptersService($this->entityManager);
            $this->availableGames = new GetAvailableGamesService($this->entityManager);

            return $this->render('admin_menu/index.html.twig', [
                'controller_name' => 'AdminMenuController',
                'availableKatas' => $this->availableKatas->execute(),
                'availableLessons' => $this->availableLessons->execute(),
                'availableStages' => $this->availableStages->execute(),
                'availableChapters' => $this->availableChapters->execute(),
                'availableGames' => $this->availableGames->execute(),
                'apiHost' => $this->getParameter('api_host'),
            ]);
        } catch (\Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }
    }

    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
}
