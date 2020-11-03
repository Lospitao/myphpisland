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

        //Create array where each kata title and uuid will be stored
        $lessonKatasArray = [];
        $availableKatas = [];
        //get lesson through uuid
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);

        //get kata collection related to lesson
        $lessonKatas = $lesson->getKata();

        //iteration inside lessonKatas
        foreach($lessonKatas as $lessonKata) {
            //get kata title
            $lessonKatasTitle = $lessonKata->getKataTitle();
            //get kata uuid
            $lessonKatasUuid = $lessonKata->getUuid();
            //Push both into the array previously created
            $lessonKatasArray[$lessonKatasUuid]= [
                'title' => $lessonKatasTitle,
                'uuid' => $lessonKatasUuid,
            ];
        }

    //Load Available katas as index is loaded
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
        //If Kata is inside of lesson katas, remove it from availableKatas
            if(!array_key_exists($kata_uuid, $lessonKatasArray)) {
                //Push title and uuid of kata into availableKatas
                $availableKatas[$kata_uuid] = [
                    'title' => $title,
                    'uuid' => $kata_uuid,
                ];
            }
        }


        return $this->render('lessons_editor/index.html.twig', [
            'controller_name' => 'LessonsEditorController',
            'lesson_uuid' => $uuid,
            'availableKatas'=> $availableKatas,
            'kata_uuid' => $kata_uuid,
            'lessonKatasArray'=> $lessonKatasArray,
            'lessonKatas' => $lessonKatas
        ]);
    }
}
