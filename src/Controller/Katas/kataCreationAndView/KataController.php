<?php

namespace App\Controller\Katas\kataCreationAndView;


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

    /**
     * @Route("/katas/create", name="katas_create" )
     */
    public function katasCreate()
    {
        try {
                $this->createNewKataService();
                $this->persistToRepository();
                $this->createKataCreationSuccessMessage();

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

            $this->setKataToLoadFromDataBase($uuid);
            $this->checkIfKataToLoadExists();
            $kataViewResponse = $this->createKataViewResponse($uuid);
            return $kataViewResponse;
        } catch (\Exception $exception) {
            $this->createErrorMessage($exception);
            return $this->redirectToRoute('katas_create');
        }
    }

    private function createNewKataService()
    {
        $this->createNewEntity();
        $this->setUuid();
        $this->setCreatedAt();
        $this->setUpdatedAt();
    }

    private function createNewEntity()
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

    private function persistToRepository()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->createdKata);
        $entity_manager->flush();
    }
    private function createKataCreationSuccessMessage()
    {
        $this->addFlash('success', 'Edite la nueva kata');
    }
    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }
    private function setKataToLoadFromDataBase($uuid)
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
    private function createKataViewResponse($uuid)
    {
        return $this->render('kata/index.html.twig', [
            'controller_name' => 'KataController',
            'title' => $this->kataToLoad->getKataTitle(),
            'description' => $this->kataToLoad->getDescription(),
            'codeEditor' => $this->kataToLoad->getEditorCode(),
            'examples' => $this->kataToLoad->getExamples(),
            'uuid' => $uuid,
        ]);
    }

    private function createErrorMessage($exception)
    {
        $errorMessage=$exception->getMessage();
        $this->addFlash('error', $errorMessage);
    }


}
