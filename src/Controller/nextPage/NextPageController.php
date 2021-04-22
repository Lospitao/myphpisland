<?php
namespace App\Controller\nextPage;
use App\Entity\Chapter;
use App\Entity\ChapterElement;
use App\Entity\Game;
use App\Entity\GameChapters;
use App\Entity\GameHistory;
use App\Entity\GameSession;
use App\Entity\Kata;
use App\Entity\LessonKatas;
use App\Entity\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class NextPageController extends AbstractController

{
    var $user;
    var $gameHistoryEntry;
    var $gameSession;
    var $chapterElement;
    var $nextKataInNewLesson;
    var $currentKata;
    var $nextKataInLesson;
    var $nextKata;
    var $nextKataInNewLessonId;
    var $nextKataInLessonId;
    var $nextChapterElement;
    var $currentChapter;
    var $nextChapter;
    var $nextChapterInGameId;
    var $kataViewResponse;
    var $stageViewResponse;
    var $endOfGameResponse;


    /**
     * @Route("/next/page", name="next_page")
     */

    public function index()
    {
        try {

            $this->user = $this->getUserRequestingNextPage();
            $this->gameSession = $this->getGameSession();
            $this->getChapterInGame();
            $this->chapterElement = $this->getChapterElementInChapter();
            $this->isChapterElementALesson();
            //Si el chapter Element actual es una LESSON
            if ($this->isChapterElementALesson()) {
                $this->nextKataInLesson= $this->getNextKataInLesson();
                if(!$this->isThereNoNextKataInThisLesson()) {
                    $this->nextChapterElement = $this->getNextChapterElement();
                    if(!$this->IsThereNoNextChapterElement()) {
                        $this->nextChapter = $this->getNextChapterInGame();
                        if (!$this->isThereNoNextChapter()) {
                            $this->endOfGameResponse = $this->createEndOfGameResponse();
                            return $this->endOfGameResponse;
                        }
                            $this->nextChapterInGameId = $this->getChapterInGameId();
                            $this->setNextChapterToGameSession();
                            $this->chapterElement = $this->getChapterElementInNextChapter();
                            if ($this->isChapterElementALesson()) {
                                $this->getNextKataInLesson();
                                $this->nextKataInLessonId = $this->getNextKataInLessonId();
                                $this->setNextChapterElementToGameSession();
                                $this->setNextKataIdToGameSession();
                                return $this->kataViewResponse;
                            } else {
                                $this->setKataToNull();
                                $this->setNextChapterElementToGameSession();
                                $this->createNewGameHistoryEntryService();
                                $this->stageViewResponse = $this->createStageViewResponse();
                                return $this->stageViewResponse;
                            }
                    }
                    if ($this->isNextChapterElementALesson()) {
                        $this->getNextKataInLesson();
                        $this->nextKataInLessonId = $this->getNextKataInLessonId();
                        $this->setNextChapterElementToGameSession();
                        $this->setNextKataIdToGameSession();
                        return $this->kataViewResponse;
                    }
                    $this->setKataToNull();
                    $this->setNextChapterElementToGameSession();
                    $this->createNewGameHistoryEntryService();
                    $this->stageViewResponse = $this->createStageViewResponse();
                    return $this->stageViewResponse;

                } else //Si la Lessons actual tiene al menos una kata más
                $this->nextKataInLessonId =$this->getNextKataInLessonId();
                $this->setNextKataIdToGameSession();
                $this->createNewGameHistoryEntryService();
                $this->kataViewResponse = $this->createKataViewResponse();
                return $this->kataViewResponse;
            }
            //Si el chapterElement actual es un STAGE
            $this->nextChapterElement = $this->getNextChapterElement();
            if(!$this->IsThereNoNextChapterElement()) {
                $this->nextChapter = $this->getNextChapterInGame();
                if (!$this->isThereNoNextChapter()) {
                    $this->endOfGameResponse = $this->createEndOfGameResponse();
                    return $this->endOfGameResponse;
                }
                $this->nextChapterInGameId = $this->getChapterInGameId();
                $this->setNextChapterToGameSession();
                $this->chapterElement = $this->getChapterElementInNextChapter();
                if ($this->isChapterElementALesson()) {
                    $this->setNewChapterElementToGameSession();
                    $this->nextKataInNewLesson = $this->getNextKataInNewLesson();
                    $this->nextKataInNewLessonId = $this->getNextKataInNewLessonId();
                    $this->setNextKataInNewLessonIdToGameSession();
                    $this->createNewGameHistoryEntryService();
                    $this->kataViewResponse= $this->createKataViewResponse();
                    return $this->kataViewResponse;
                } else {
                    $this->setKataToNull();
                    $this->setNewChapterElementToGameSession();
                    $this->createNewGameHistoryEntryService();
                    $this->stageViewResponse = $this->createStageViewResponse();
                    return $this->stageViewResponse;
                }
            }
            if ($this->isNextChapterElementALesson()) {
                $this->nextKataInNewLesson = $this->getNextKataInNewLesson();
                $this->nextKataInNewLessonId = $this->getNextKataInNewLessonId();
                $this->setNextChapterElementToGameSession();
                $this->setNextKataInNewLessonIdToGameSession();
                $this->createNewGameHistoryEntryService();
                $this->kataViewResponse= $this->createKataViewResponse();
                return $this->kataViewResponse;
            }
            $this->setKataToNull();
            $this->setNextChapterElementToGameSession();
            $this->createNewGameHistoryEntryService();
            $this->stageViewResponse = $this->createStageViewResponse();
            return $this->stageViewResponse;

        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
            return $this->redirectToRoute('next_page');
        }
    }

    private function getUserRequestingNextPage()
    {
        return $this->getUser();
    }

    private function getGameSession()
    {
        return $this->getDoctrine()
            ->getRepository(GameSession::class)
            ->findOneBy(['idUser' => $this->user->getId()]);
    }
    private function getChapterInGame()
    {
        return $this->gameSession->getIdChapter();

    }
    private function getChapterElementInChapter()
    {
        $chapterElement = $this->getDoctrine()
            ->getRepository(ChapterElement::class)
            ->findBy(['id' => $this->gameSession->getIdChapterElement()]);
        return $chapterElement[0];
    }

    private function getNextChapterElement()
    {   $nextChapterElementPosition = $this->chapterElement->getPosition()+1;
        return $this->getDoctrine()
            ->getRepository(ChapterElement::class)
            ->findOneBy(['chapterId' => $this->gameSession->getIdChapter(),'position' => $nextChapterElementPosition]);
    }
    private function IsThereNoNextChapterElement() {
        return $this->nextChapterElement;
    }
    private function isNextChapterElementALesson()
    {
        return $this->nextChapterElement->getChapterElementType() === ChapterElement::ID_chapter_element_type_lesson;
    }
    private function setKataToNull() {
        $this->gameSession->setIdKata(null);
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->gameSession);
        $entity_manager->flush();
    }
    private function setNextChapterElementToGameSession()
    {
        $this->gameSession->setIdChapterElement($this->nextChapterElement->getId());
        $this->gameSession->setUpdatedAt(new \DateTime());
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->gameSession);
        $entity_manager->flush();
    }

    private function isChapterElementALesson()
    {
        return $this->chapterElement->getChapterElementType() === ChapterElement::ID_chapter_element_type_lesson;
    }

    private function getNextKataInLesson()
    {
        $this->currentKata = $this->getCurrentKataInLessonKatasRepository();
        $this->nextKata= $this->getNextKata();
        return $this->nextKata;
    }
    private function getCurrentKataInLessonKatasRepository()
    {
        $lessonKata= $this->getDoctrine()
            ->getRepository(LessonKatas::class)
            ->findOneBy(['lesson' => $this->chapterElement->getStageOrLessonId(), 'kata' => $this->gameSession->getIdKata()]);
        return $lessonKata;
    }
    private function getNextKata() {
        $nextKataPosition = $this->currentKata->getPosition()+1;
        return  $this->getDoctrine()
            ->getRepository(LessonKatas::class)
            ->findOneBy(['lesson'=>$this->chapterElement->getStageOrLessonId(), 'position'=> $nextKataPosition]);
    }
    private function getNextKataInLessonId() {
        $kataInLessonKatas =  $this->nextKata->getKata();
        return $kataInLessonKatas->getId();
    }
    private function isThereNoNextKataInThisLesson() {
        return $this->nextKata;
    }

    private function setNextKataIdToGameSession()
    {
        $this->gameSession->setIdKata($this->nextKataInLessonId);
        $this->gameSession->setUpdatedAt(new \DateTime());
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->gameSession);
        $entity_manager->flush();
    }

    private function getNextChapterInGame()
    {
        $this->currentChapter = $this->getCurrentChapter();
        $this->nextChapter= $this->getNextChapter();
        return $this->nextChapter;
    }
    private function isThereNoNextChapter() {
        return $this->nextChapter;
    }
    private function getCurrentChapter()
    {   $chapter = $this->getDoctrine()
        ->getRepository(Chapter::class)
        ->findOneBy(['id' => $this->gameSession->getIdChapter()]);
        return $this->getDoctrine()
            ->getRepository(GameChapters::class)
            ->findOneBy(['chapter' => $chapter]);
    }

    private function getNextChapter()
    {
        $nextChapterPosition = $this->currentChapter->getPosition()+1;
        return $this->getDoctrine()
            ->getRepository(GameChapters::class)
            ->findOneBy(['position'=>$nextChapterPosition ]);
    }
    private function getChapterInGameId()
    {
        
        $chapterInGameChapters =  $this->nextChapter->getChapter();
        return $chapterInGameChapters->getId();
    }
    private function setNextChapterToGameSession()
    {
        $this->gameSession->setIdChapter($this->nextChapterInGameId);
        $this->gameSession->setUpdatedAt(new \DateTime());
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->gameSession);
        $entity_manager->flush();
    }



    /*Create View Responses*/
    private function  createKataViewResponse()
    {
        $kata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['id' =>$this->gameSession->getIdKata()]);
        return $this->redirectToRoute('kata', [
            'uuid' => $kata->getUuid(),
        ]);
    }
    private function createStageViewResponse()
    {
        $chapterElement = $this->getDoctrine()
            ->getRepository(ChapterElement::class)
            ->findOneBy(['id'=>$this->gameSession->getIdChapterElement()]);
        $stage= $this->getDoctrine()
            ->getRepository(Stage::class)
            ->findOneBy(['id' => $chapterElement->getStageOrLessonId()]);
        return $this->redirectToRoute('stages', [
            'stageUuid' => $stage->getUuid()
        ]);
    }
    private function createEndOfGameResponse()
    {
        return $this->redirectToRoute('end_of_game');
    }
    /*New Game History Entry */
    private function createNewGameHistoryEntryService()
    {
        $this->createNewGameSessionHistoryEntry();
        $this->setGameHistoryCreatedAt();
        $this->setGameSessionHistoryUuid();
        $this->setGameSessionHistoryIdUser();
        $this->setDefaultGameToGameSessionHistory();
        $this->setChapterToGameSessionHistory();
        $this->setChapterElementToGameSessionHistory();
        $this->setKataToGameSessionHistory();
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

    private function setGameSessionHistoryUuid()
    {
        $this->gameHistoryEntry->setUuidGameSession($this->gameSession->getUuid());
    }
    private function setGameSessionHistoryIdUser()
    {
        $this->gameHistoryEntry->setIdUser($this->user->getId());
    }
    private function setDefaultGameToGameSessionHistory()
    {
        $this->gameHistoryEntry->setIdGame(Game::ID_MYPHPISLAND);
    }
    private function setChapterToGameSessionHistory()
    {
        $this->gameHistoryEntry->setIdChapter($this->gameSession->getIdChapter());
    }

    private function setChapterElementToGameSessionHistory()
    {
        $this->gameHistoryEntry->setIdChapterElement($this->gameSession->getIdChapterElement());
    }
    private function setKataToGameSessionHistory()
    {
        $this->gameHistoryEntry->setIdKata($this->gameSession->getIdKata());
    }
    private function persistNewGameHistoryEntryToRepository()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->gameHistoryEntry);
        $entityManager->flush();
    }
    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        $this->addFlash('error', $errorMessage);
    }

    private function getChapterElementInNextChapter()
    {
        $this->gameSession->getIdChapter();
        $chapterElement = $this->getDoctrine()
            ->getRepository(ChapterElement::class)
            ->findBy(['chapterId' => $this->gameSession->getIdChapter(), 'position' => 'ASC']);
        return $chapterElement[0];
    }

    private function setNewChapterElementToGameSession()
    {
        $this->gameSession->setIdChapterElement($this->chapterElement->getId());
        $this->gameSession->setUpdatedAt(new \DateTime());
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->gameSession);
        $entity_manager->flush();
    }

    private function getNextKataInNewLesson()
    {
        $lessonKata= $this->getDoctrine()
            ->getRepository(LessonKatas::class)
            ->findOneBy(['lesson' => $this->nextChapterElement->getStageOrLessonId(), 'position' => '0']);
        return $lessonKata;
    }

    private function getNextKataInNewLessonId()
    {
        $kataInLessonKatas =  $this->nextKataInNewLesson->getKata();
        return $kataInLessonKatas->getId();
    }

    private function setNextKataInNewLessonIdToGameSession()
    {
        $this->gameSession->setIdKata($this->nextKataInNewLessonId);
        $this->gameSession->setUpdatedAt(new \DateTime());
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->gameSession);
        $entity_manager->flush();
    }
}