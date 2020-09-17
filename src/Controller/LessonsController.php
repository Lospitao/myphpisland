<?php

namespace App\Controller;

use App\Entity\Kata;
use App\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class LessonsController extends AbstractController
{
    /**
     * @Route("/lessons/create", name="lessons_create" )
     */
    public function lessonscreate() {
        $lesson = new Lesson();
        $uuid = Uuid::v4();
        $lesson->setUuid($uuid);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($lesson);
        $entity_manager->flush();

        return $this->redirectToRoute('lessons_editor', [
            'uuid' => $uuid]);
    }

    /**
     * @Route("/lessons/{uuid}", name="lessons")
     */
    public function index($uuid)
    {
        $availableKatas = array();
        //Todas las katas
        $katasArray = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findAll();
        //Iteración dentro del arry de katas
        foreach($katasArray as $kata) {
            //Obtener el título cada
                $title = $kata->getKataTitle();
                array_push($availableKatas, $title);

        }
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);
        $lessonTitle= $lesson->getTitle();

        return $this->render('lessons/index.html.twig', [
            'controller_name' => 'LessonsController',
            'availableKatas'=> $availableKatas,
            'uuid' => $uuid,
            'lessonTitle' => $lessonTitle,

        ]);
    }
}
