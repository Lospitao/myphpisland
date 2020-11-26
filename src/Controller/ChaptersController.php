<?php

namespace App\Controller;

use App\Entity\Chapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ChaptersController extends AbstractController
{
    /**
     * @Route("/chapters/create", name="chapters_create" )
     */
    public function chapterscreate()
    {
        $chapter = new Chapter();
        $chapterUuid = Uuid::v4();
        $chapter->setUuid($chapterUuid);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($chapter);
        $entity_manager->flush();

        return $this->redirectToRoute('chapters_editor', [
            'chapterUuid' => $chapterUuid]);
    }
    /**
     * @Route("/chapters/{chapterUuid}/", name="chapters")
     */
    public function index()
    {
        return $this->render('chapters/index.html.twig', [
            'controller_name' => 'ChaptersController',
        ]);
    }
}
