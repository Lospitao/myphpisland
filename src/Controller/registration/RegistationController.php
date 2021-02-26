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

class RegistationController extends AbstractController
{
    var $user;
    var $form;
    var $gameSession;
    var $gameHistoryEntry;
    var $gameId;
    var $chaptersInGame;
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
            /*    $this->createNewGameHistoryEntryService(); */
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
        $this->setGameSessionUuid();
        $this->setGameSessionIdUser();
        $this->setDefaultGameToGameSession();
        $this->getAscendingOrderChaptersInGame();
        $this->setFirstChapterToGameSession();
        $this->getAscendingOrderElementsInChapter();
        $this->setFirstChapterElementToGameSession();
        $this->checkChapterElementType();
        if ($this->elementType == 1)
        {
            $this->getAscendingOrderKatasInLesson();
            $this->setFirstKataToGameSession();
        }
        $this->persistNewGameSessionToRepository();
    }
  /*
    private function createNewGameHistoryEntryService() {
        $this->createNewGameHistoryEntry();
        $this->persistNewGameHistoryEntryToRepository();
    }
  */
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
    private function setGameSessionUuid()
    {
        $gameSessionUuid = Uuid::v4();
        $this->gameSession->setUuid($gameSessionUuid);

    }
    private function setGameSessionIdUser()
    {
        $this->gameSession->setIdUser($this->user->getId());
    }
    private function setDefaultGameToGameSession() {
        $this->gameId = Game::ID_MYPHPISLAND;
        $this->gameSession->setIdGame($this->gameId);
    }
    private function getAscendingOrderChaptersInGame()
    {
        $this->chaptersInGame = $this->getDoctrine()
            ->getRepository(GameChapters::class)
            ->findBy(['game' => $this->gameId], ['position' => 'ASC']);
    }
    private function setFirstChapterToGameSession()
    {
        $chapterId = $this->chaptersInGame[0]->getChapter();
        $firstChapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneBy(['id' => $chapterId]);
        $this->firstChapterId = $firstChapter->getId();
        $this->gameSession->setIdChapter($this->firstChapterId);
    }
    private function getAscendingOrderElementsInChapter()
    {
        $this->elementsInChapter = $this->getDoctrine()
            ->getRepository( ChapterElement::class)
            ->findBy(['chapterId' => $this->firstChapterId], ['position' => 'ASC']);
    }
    private function setFirstChapterElementToGameSession () {
        $this->chapterElementId= $this->elementsInChapter[0]->getStageOrLessonId();
        $this->gameSession->setIdChapterElement($this->chapterElementId);
    }
    private function checkChapterElementType()
    {
        $this->elementType = $this->elementsInChapter[0]->getChapterElementType();
    }
    private function  getAscendingOrderKatasInLesson()
    {
        $this->katasInLesson = $this->getDoctrine()
            ->getRepository(LessonKatas::class)
            ->findBy(['lesson' => $this->chapterElementId], ['position' => 'ASC']);
    }
    private function setFirstKataToGameSession()
    {
        $this->kataId=$this->katasInLesson[0]->getKata();
        $firstKata = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['id' => $this->kataId]);
        $this->firstKataId = $firstKata->getId();
        $this->gameSession->setIdKata($this->firstKataId);

}
    private function persistNewGameSessionToRepository()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->gameSession);
        $entityManager->flush();
    }
    /*
    private function createNewGameHistoryEntry()
    {
        $this->gameHistoryEntry = new GameHistory();
    }

    private function persistNewGameHistoryEntryToRepository()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->gameHistoryEntry);
        $entityManager->flush();
    }

*/










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
