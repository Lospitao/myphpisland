<?php




namespace App\Controller;


use App\Entity\ChapterElement;
use App\Entity\Game;
use App\Entity\GameHistory;
use App\Entity\GameSession;
use App\Entity\Kata;
use App\Entity\Lesson;
use App\Entity\LessonKatas;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;



class NextPageController extends AbstractController

{


    var $user;
    var $userId;
    var $gameSession;
    var $gameSessionChapterId;
    var $ChapterElementId;
    var $ChapterElement;
    var $ChapterElementType;
    var $ChapterElementIsALesson;
    var $currentKataId;
    var $currentLessonId;
    var $currentKata;
    var $currentKataPosition;
    var $nextKataPosition;
    var $nextKataInLesson;
    var $nextKataInLessonId;
    var $gameHistoryEntry;
    var $gameSessionUuid;
    var $gameSessionGameId;
    var $kataViewResponse;

    /**
     * @Route("/next/page", name="next_page")
     */

    public function index()
    {
        try {
            $this->user = $this->getUserRequestingNextPage();
            $this->userId = $this->getUserIdRequestingNextPage();
            $this->gameSession = $this->getGameSession();
            $this->gameSessionChapterId = $this->getGameSessionChapterId();
            $this->ChapterElementId = $this->getCurrentChapterElementId();
            $this->ChapterElement = $this->getCurrentChapterElement();
            $this->ChapterElementType = $this->getCurrentChapterElementType();
            $this->ChapterElementIsALesson = $this->checkIfCurrentChapterElementTypeIsALesson();
            if ($this->ChapterElementIsALesson) {
                $this->currentKataId = $this->getCurrentKataId();
                $this->currentLessonId = $this->getCurrentLessonId();
                $this->currentKata = $this->getCurrentKataInLessonKatasRepository();
                $this->currentKataPosition = $this->getCurrentKataInLessonPosition();
                $this->nextKataInLesson= $this->getNextKataInLesson();
                $this->nextKataInLessonId =$this->getNextKataInLessonId();
                $this->setNextKataIdToGameSession();
                $this->createNewGameHistoryEntryService();
                $this->kataViewResponse = $this->createKataViewResponse();
                return $this->kataViewResponse;
            }
            return $this->render('registation/index.html.twig');
        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
            return $this->render('next_page/index.html.twig');
        }
    }

    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        $this->addFlash('error', $errorMessage);
    }
    private function getUserRequestingNextPage()
    {
        return $this->getUser();
    }

    private function getUserIdRequestingNextPage()
    {
        return $this->user->getId();
    }

    private function getGameSession()
    {
        return $this->getDoctrine()
            ->getRepository(GameSession::class)
            ->findOneBy(['idUser' => $this->userId]);
    }

    private function getGameSessionChapterId()
    {
        return $this->gameSession->getIdChapter();
    }

    private function getCurrentChapterElementId()
    {
        return $this->gameSession->getIdChapterElement();
    }

    private function getCurrentChapterElement()
    {
        $chapterElement = $this->getDoctrine()
            ->getRepository(ChapterElement::class)
            ->findBy(['id' => $this->ChapterElementId]);
        return $chapterElement[0];
    }

    private function getCurrentChapterElementType()
    {
        return $this->ChapterElement->getChapterElementType();
    }

    private function checkIfCurrentChapterElementTypeIsALesson()
    {
        return $this->ChapterElementType == ChapterElement::ID_chapter_element_type_lesson;
    }

    private function getCurrentKataId()
    {
        return $this->gameSession->getIdKata();
    }

    private function getCurrentLessonId()
    {
        return $this->ChapterElement->getStageOrLessonId();
    }

    private function getCurrentKataInLessonKatasRepository()
    {
        $lessonKata= $this->getDoctrine()
            ->getRepository(LessonKatas::class)
            ->findOneBy(['lesson' => $this->currentLessonId, 'kata' => $this->currentKataId ]);
        return $lessonKata;
    }
    private function getCurrentKataInLessonPosition() {
        return $this->currentKata->getPosition();
    }
    private function getNextKataInLesson() {
        $this->nextKataPosition = $this->currentKataPosition+1;
        $nextKata = $this->getDoctrine()
            ->getRepository(LessonKatas::class)
            ->findOneBy(['lesson'=>$this->currentLessonId, 'position'=> $this->nextKataPosition]);
        return $nextKata;
    }
    private function getNextKataInLessonId() {
     $kataInLessonKatas =  $this->nextKataInLesson->getKata();
     return $kataInLessonKatas->getId();
    }


    private function setNextKataIdToGameSession()
    {
        $this->gameSession->setIdKata($this->nextKataInLessonId);
        $this->gameSession->setUpdatedAt(new \DateTime());
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->gameSession);
        $entity_manager->flush();
    }

    private function  createKataViewResponse()
    {
        $kataUuid= $this->nextKataInLesson->getKata()->getUuid();
        return $this->redirectToRoute('kata', [
            'uuid' => $kataUuid,
        ]);
    }
    private function createNewGameHistoryEntryService()
    {
        $this->createNewGameSessionHistoryEntry();
        $this->setGameHistoryCreatedAt();
        $this->gameSessionUuid = $this->getGameSessionUuid();
        $this->setGameSessionHistoryUuid();
        $this->setGameSessionHistoryIdUser();
        $this->gameSessionGameId = $this->getGameSessionGameId();
        $this->setDefaultGameToGameSessionHistory();
        $this->setChapterToGameSessionHistory();
        $this->setChapterElementToGameSessionHistory();
        if ($this->ChapterElementIsALesson)
        {
            $this->setKataToGameSessionHistory();
        }
        $this->persistNewGameHistoryEntryToRepository();
    }
    private function createNewGameSessionHistoryEntry()
    {
        $this->gameHistoryEntry = new GameHistory();
    }
    private function setGameHistoryCreatedAt()
    {
        $this->gameHistoryEntry->setCreatedAt(new \DateTime());
    }
    private function getGameSessionUuid()
    {
        return $this->gameSession->getUuid();
    }
    private function setGameSessionHistoryUuid()
    {
        $this->gameHistoryEntry->setUuidGameSession($this->gameSessionUuid);
    }
    private function setGameSessionHistoryIdUser()
    {
        $this->gameHistoryEntry->setIdUser($this->userId);
    }
    private function getGameSessionGameId()
    {
        return Game::ID_MYPHPISLAND;
    }
    private function setDefaultGameToGameSessionHistory()
    {
        $this->gameHistoryEntry->setIdGame($this->gameSessionGameId);
    }
    private function setChapterToGameSessionHistory()
    {
        $this->gameHistoryEntry->setIdChapter($this->gameSessionChapterId);
    }

    private function setChapterElementToGameSessionHistory()
    {
        $this->gameHistoryEntry->setIdChapterElement($this->ChapterElementId);
    }

    private function setKataToGameSessionHistory()
    {
        $this->gameHistoryEntry->setIdKata($this->nextKataInLessonId);
    }
    private function persistNewGameHistoryEntryToRepository()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->gameHistoryEntry);
        $entityManager->flush();
    }
}