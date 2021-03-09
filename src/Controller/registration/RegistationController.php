<?php

namespace App\Controller\registration;

use App\Entity\Chapter;
use App\Entity\ChapterElement;
use App\Entity\Game;
use App\Entity\GameChapters;
use App\Entity\GameHistory;
use App\Entity\GameSession;
use App\Entity\Kata;
use App\Entity\LessonKatas;
use App\Entity\User;
use App\Form\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Config\Definition\Exception\Exception;

class RegistationController extends AbstractController
{
    var $user;
    var $form;
    var $gameSession;
    var $gameSessionUuid;
    var $gameHistoryEntry;
    var $gameId;
    var $chaptersInGame;
    var $firstChapter;
    var $firstChapterId;
    var $elementsInChapter;
    var $chapterElementId;
    var $katasInLesson;
    var $elementType;
    var $firstKataId;



    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {

        try {
            $this->generateForm($request);
            if ($this->form->isSubmitted() && $this->form->isValid()) {
                $this->createNewUserEntityService($passwordEncoder);
                $this->createNewGameSessionService();
                $this->createNewGameHistoryEntryService();
                $this->createSuccessfullyRegisteredNewUser();
                return $this->redirectToRoute('app_login');
            }
            return $this->render('registation/index.html.twig', [
                'form' => $this->form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
            return $this->render('registation/index.html.twig', [
                'form' => $this->form->createView(),
            ]);
        }

    }
    private function generateForm($request)
    {
        $this->form = $this->createForm(UserRegistrationType::class, $this->user);
        $this->form->handleRequest($request);
    }
    private function createNewUserEntityService($passwordEncoder) {
        $this->createNewUser();
        $this->setUsername();
        $this->setEmail();
        $this->getSignupDate();
        $this->getEncodedPassword($passwordEncoder);
        $this->persistNewUserToRepository();
    }
    private function createNewGameSessionService()
    {
        $this->createNewGameSession();
        $this->setCreatedAt();
        $this->setGameSessionUuid();
        $this->setGameSessionIdUser();
        $this->setDefaultGameToGameSession();
        $this->getAscendingOrderChaptersInGame();
        $this->checkIfGameHasOneChapterAtLeast();
        $this->getFirstChapterId();
        $this->setFirstChapterToGameSession();
        $this->getAscendingOrderElementsInChapter();
        $this->checkIfChapterHasOneChapterElementAtLeast();
        $this->setFirstChapterElementToGameSession();
        $this->checkChapterElementType();
        if ($this->isChapterElementALesson())
        {
            $this->getAscendingOrderKatasInLesson();
            $this->setFirstKataToGameSession();
        }
        $this->persistNewGameSessionToRepository();
    }

    private function createNewGameHistoryEntryService() {
        $this->createNewGameSessionHistoryEntry();
        $this->setGameHistoryCreatedAt();
        $this->setGameSessionHistoryUuid();
        $this->setGameSessionHistoryIdUser();
        $this->setDefaultGameToGameSessionHistory();
        $this->setFirstChapterToGameSessionHistory();
        $this->setFirstChapterElementToGameSessionHistory();
        if ($this->isChapterElementALesson())
        {
            $this->setFirstKataToGameSessionHistory();
        }
        $this->persistNewGameHistoryEntryToRepository();
    }

    /*createNewUserEntityService*/
    private function createNewUser()
    {
        $this->user = new User();
    }
    private function setUsername () {
        $this->user->setUsername($this->form->get('username')->getData());
    }
    private function setEmail() {
        $this->user->setEmail($this->form->get('email')->getData());
    }
    private function getSignupDate()
    {
        $this->user->setSignupDate(new \DateTime());
    }
    private function getEncodedPassword($passwordEncoder)
    {
        $this->user->setPassword(
            $passwordEncoder->encodePassword(
                $this->user,
                $this->form->get('plainPassword')->getData()
            )
        );
    }
    private function persistNewUserToRepository()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->user);
        $entityManager->flush();
    }
    /*createNewGameSessionService*/

    private function createNewGameSession()
    {
        $this->gameSession = new GameSession();
    }
    private function setCreatedAt() {
        $this->gameSession->setCreatedAt(new \DateTime());
    }
    private function setGameSessionUuid()
    {
        $this->gameSessionUuid = Uuid::v4();
        $this->gameSession->setUuid($this->gameSessionUuid);
    }
    private function setGameSessionIdUser()
      {
        $this->gameSession->setIdUser($this->user->getId());
    }
    private function setDefaultGameToGameSession() {
        $this->gameId = $this->getGameId();
        $this->gameSession->setIdGame($this->gameId);
    }

    private function getGameId() {
        return Game::ID_MYPHPISLAND;
    }
    private function getAscendingOrderChaptersInGame()
    {
        $this->chaptersInGame = $this->getDoctrine()
            ->getRepository(GameChapters::class)
            ->findBy(['game' => $this->gameId], ['position' => 'ASC']);
    }
    private function checkIfGameHasOneChapterAtLeast() {
        if ($this->doesTheGameHaveOneChapterAtLeast()) {
            throw new Exception("La edición del juego no se ha completado, por favor, contacte con los adminsitradores.");
        }
    }
    private function doesTheGameHaveOneChapterAtLeast() {
        return !$this->chaptersInGame;
    }
    private function getFirstChapterId() {
        $this->chapterId = $this->getChapterId();
        $this->firstChapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['id' => $this->chapterId]);
        $this->firstChapterId = $this->firstChapter->getId();
    }
    private function setFirstChapterToGameSession()
    {
        $this->gameSession->setIdChapter($this->firstChapterId);
    }
    private function getChapterId()
    {
        return $this->chaptersInGame[0]->getChapter();
    }
    private function getAscendingOrderElementsInChapter()
    {
        $this->elementsInChapter = $this->getDoctrine()
            ->getRepository( ChapterElement::class)
            ->findBy(['chapterId' => $this->firstChapterId], ['position' => 'ASC']);
    }
    private function checkIfChapterHasOneChapterElementAtLeast()
    {
        if ($this->doesTheChapterHaveOneChapterElementAtLeast()) {
            throw new Exception("La edición del juego no se ha completado, por favor, contacte con los adminsitradores.");
        }
    }
    private function doesTheChapterHaveOneChapterElementAtLeast() {
        return !$this->elementsInChapter;
    }
    private function setFirstChapterElementToGameSession () {
        $this->chapterElementId= $this->getChapterElementId();
        $this->gameSession->setIdChapterElement($this->chapterElementId);
    }
    private function getChapterElementId()
    {
        return $this->elementsInChapter[0]->getId();
    }
    private function checkChapterElementType()
    {
        $this->elementType = $this->elementsInChapter[0]->getChapterElementType();
    }
    private function isChapterElementALesson() {
        return $this->elementType == ChapterElement::ID_chapter_element_type_lesson;
    }
    private function  getAscendingOrderKatasInLesson()
    {
        $lessonId=$this->elementsInChapter[0]->getStageOrLessonId();
        $this->katasInLesson = $this->getDoctrine()
            ->getRepository(LessonKatas::class)
            ->findBy(['lesson' => $lessonId], ['position' => 'ASC']);
    }
    private function setFirstKataToGameSession()
    {
        $this->kataId= $this->getKataId();
        $firstKata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['id' => $this->kataId]);
        $this->firstKataId = $firstKata->getId();
        $this->gameSession->setIdKata($this->firstKataId);

    }
    private function getKataId() {
        return $this->katasInLesson[0]->getKata();
    }
    private function persistNewGameSessionToRepository()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->gameSession);
        $entityManager->flush();
    }
    /*CreateNewGameSessionHistoryEntry*/
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
        $this->gameHistoryEntry->setUuidGameSession($this->gameSessionUuid);
    }
    private function setGameSessionHistoryIdUser()
    {
        $this->gameHistoryEntry->setIdUser($this->user->getId());
    }
    private function setDefaultGameToGameSessionHistory ()
    {
        $this->gameHistoryEntry->setIdGame($this->gameId);
    }
    private function setFirstChapterToGameSessionHistory()
    {
        $this->gameHistoryEntry->setIdChapter($this->firstChapterId);
    }
    private function setFirstChapterElementToGameSessionHistory() {
        $this->gameHistoryEntry->setIdChapterElement($this->chapterElementId);
    }
    private function setFirstKataToGameSessionHistory() {
        $this->gameHistoryEntry->setIdKata($this->firstKataId);
    }
    private function persistNewGameHistoryEntryToRepository()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->gameHistoryEntry);
        $entityManager->flush();
    }

    private function createSuccessfullyRegisteredNewUser()
    {
        $this->addFlash('success', 'Se ha registrado con éxito');
    }
    private function createErrorMessage(\Exception $exception)
    {
        $errorMessage=$exception->getMessage();
        $this->addFlash('error', $errorMessage);
    }
}