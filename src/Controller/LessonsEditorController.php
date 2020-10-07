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

        $lessonKatasArray = [];
        //get lesson through uuid
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);
        $lessonKatas = $lesson->getKata();
        foreach($lessonKatas as $lessonKata) {
            $title = $lessonKata->getKataTitle();
            array_push($lessonKatasArray, ['title' => $title]);
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
