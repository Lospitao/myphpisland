<?php

namespace App\Controller\kataView;


use App\Entity\Kata;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class KataController extends AbstractController

{
    var $uuid;
    var $createdKata;
    var $kataToLoad;
    var $title;
    var $description;
    var $codeEditor;
    var $sampleTest;
    /**
     * @Route("/katas/create", name="katas_create" )
     */
    public function katasCreate()
    {
        try {
                $this->createNewKataService();
                $this->persistToDataBase();
                $this->addFlash('success', 'Edite la nueva kata');

            return $this->redirectToRoute('katas_editor', [
                'uuid' => $this->uuid]);
        } catch (\Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }
    }

    /**
     * @Route("/katas/{uuid}", name="kata")
     * @param $uuid
     */
    public function index($uuid)
    {
        try {

            $this->getKataToLoad($uuid);
            $this->checkIfKataToLoadExists();
            $this->getKataToLoadTitle();
            $this->getKataToLoadDescription();
            $this->getKataToLoadEditorCode();
            $this->getKataToLoadSampleTest();

            return $this->render('kata/index.html.twig', [
                'controller_name' => 'KataController',
                'title' => $this->title,
                'description' => $this->description,
                'codeEditor' => $this->codeEditor,
                'sampleTest' => $this->sampleTest,
                'uuid' => $uuid,
            ]);
        } catch (\Exception $exception) {
            $errorMessage=$exception->getMessage();
            $this->addFlash('error', $errorMessage);
            return $this->redirectToRoute('katas_create');
        }

    }

    private function createNewKataService()
    {
        $this->createNewUuid();
        $this->setUuid();
        $this->setCreatedAt();
        $this->setUpdatedAt();
    }

    private function createNewUuid()
    {
        $this->createdKata = new Kata;
    }

    private function setUuid()
    {
        $this->uuid = Uuid::v4();
        $this->createdKata->setUuid($this->uuid);
    }

    private function setCreatedAt()
    {
        $this->createdKata->setCreatedAt(new \DateTime());
    }

    private function setUpdatedAt()
    {
        $this->createdKata->setUpdatedAt(new \DateTime());
    }

    private function persistToDataBase()
    {    $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->createdKata);
        $entity_manager->flush();
    }

    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
    private function getKataToLoad($uuid)
    {
        $this->kataToLoad = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findOneBy(['uuid'=>$uuid]);
    }
    private function checkIfKataToLoadExists() {
        if (!$this->kataToLoad) {
            throw new Exception("La kata especificada no existe. Cree una nueva kata");
        }
    }
    private function getKataToLoadTitle()
    {
        $this->title= $this->kataToLoad->getKataTitle();
    }

    private function getKataToLoadDescription()
    {
        $this->description = $this->kataToLoad->getDescription();
    }

    private function getKataToLoadEditorCode()
    {
        $this->codeEditor = $this->kataToLoad->getEditorCode();
    }

    private function getKataToLoadSampleTest()
    {
        $this->sampleTest = $this->kataToLoad->getTestCode();
    }
}
