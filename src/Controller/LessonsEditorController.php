<?php

namespace App\Controller;

use App\Entity\Kata;
use App\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LessonsEditorController extends AbstractController
{
    /**
     * @Route("/lessons/{uuid}/editor", name="lessons_editor")
     */
    public function index($uuid)
    {

        $availableKatas = [];
        //All katas
        $katasArray = $this->getDoctrine()
            ->getRepository(Kata::class)
            ->findAll();
        //Iteration inside katas array
        foreach($katasArray as $kata) {
        //Get kata title
            $title = $kata->getKataTitle();
        //Get Kata uuid
            $kata_uuid = $kata->getUuid();
        //Push title and uuid of kata into availableKatas
            array_push($availableKatas, [
                'title' => $title,
                'katasUuid' => $kata_uuid,
            ]);
        }
        //Create array where each kata title and uuid will be stored
        $lessonKatasArray = [];
        //get lesson through uuid
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);
        //get kata related to lesson
        $lessonKatas = $lesson->getKata();
        //iteration inside lessonKatas
        foreach($lessonKatas as $lessonKata) {
        //get kata title
            $lessonKatasTitle = $lessonKata->getKataTitle();
        //get kata uuid
            $lessonKatasUuid = $lessonKata->getUuid();
        //Push both into the array previously created
            array_push($lessonKatasArray, [
                'title' => $lessonKatasTitle
            ]);
        }


        return $this->render('lessons_editor/index.html.twig', [
            'controller_name' => 'LessonsEditorController',
            'lesson_uuid' => $uuid,
            'availableKatas'=> $availableKatas,
            'kata_uuid' => $kata_uuid,
            'lessonKatasArray'=> $lessonKatasArray,
        ]);
    }
}
