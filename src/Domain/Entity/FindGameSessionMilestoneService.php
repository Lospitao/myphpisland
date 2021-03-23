<?php

namespace App\Domain\Entity;
use App\Entity\ChapterElement;
use App\Entity\GameSession;
use App\Entity\Kata;
use App\Entity\Stage;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FindGameSessionMilestoneService
{
    public const END_OF_GAME_ROUTE = 'end_of_game';
    public const KATA_VIEW = 'kata';
    public const STAGE_VIEW = 'stages';

    private $user;
    private $chapterElementStageId;
    private $userGameSession;
    private $kataUuid;
    private $kataViewResponse;
    private $stageUuid;
    private $stageViewResponse;
    private $endOfGameResponse;

    public function __construct($entityManager, $request, $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
        $this->urlGenerator = $urlGenerator;

    }
    public function execute() {
        try {
        $this->user = $this->findUser();
        $this->userGameSession = $this->findUserGameSession();
        $this->isCurrentMilestoneAKata();
        if ($this->isCurrentMilestoneAKata()) {
            $this->kataUuid = $this->getKataUuid();
            $this->kataViewResponse = $this->createKataViewResponse();
            return $this->kataViewResponse;
        }
        $this->chapterElementStageId = $this->getChapterElementStageId();
        $this->stageUuid = $this->getStageUuid();
        $this->stageViewResponse = $this->createStageViewResponse();
        return $this->stageViewResponse;

        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
            $this->endOfGameResponse = $this->createEndOfGameResponse();
            return $this->endOfGameResponse;
        }
    }

    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        return $errorMessage;
    }

    private function findUser()
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $this->request->get('email')]);
    }
    private function findUserGameSession()
    {
        return $this->entityManager
            ->getRepository(GameSession::class)
            ->findOneBy(['idUser' => $this->user->getId()]);
    }
    private function isCurrentMilestoneAKata()
    {
        return $this->userGameSession->getIdKata();
    }

    private function getKataUuid()
    {
        $kata = $this->entityManager
        ->getRepository(Kata::class)
        ->findOneBy(['id' => $this->userGameSession->getIdKata()]);
        return $kata->getUuid();
    }

    private function createKataViewResponse()
    {
        return $this->urlGenerator->generate(self::KATA_VIEW, ['uuid' => $this->kataUuid,]);
    }
    private function getChapterElementStageId() {
        $chapterElement = $this->entityManager
            ->getRepository(ChapterElement::class)
            ->findOneBy(['id' => $this->userGameSession->getIdChapterElement()]);
        return $chapterElement->getStageOrLessonId();
    }
    private function getStageUuid()
    {
        $stage = $this->entityManager
            ->getRepository(Stage::class)
            ->findOneBy(['id' => $this->chapterElementStageId]);
        return $stage->getUuid();
    }

    private function createStageViewResponse()
    {
        return $this->urlGenerator->generate(self::STAGE_VIEW, ['stageUuid' => $this->stageUuid,]);

    }

    private function createEndOfGameResponse()
    {
        return $this->urlGenerator->generate(self::END_OF_GAME_ROUTE);
    }
}

