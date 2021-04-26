<?php

namespace App\Controller\Lessons\lessonEdit;

use App\Entity\Kata;
use App\Entity\Lesson;
use App\Entity\LessonKatas;
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

        //get lesson through uuid
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);
        $lessonId = $lesson->getId();
        //get kata collection related to lesson
        $lessonKatas = $this->getDoctrine()
            ->getRepository(LessonKatas::class)
            ->findBy(['lesson' => $lessonId], ['position' => 'ASC']);
        //iteration inside lessonKatas
        foreach($lessonKatas as $lessonKata) {
            //Get kata id
            $kataId= $lessonKata->getKata();
            $kataPosition = $lessonKata->getPosition();
            //Get kata in
            $relevantKata = $this->getDoctrine()
                ->getRepository(Kata::class)
                ->findOneBy(['id' => $kataId]);
            //get kata title
            $lessonKatasTitle = $relevantKata->getKataTitle();
            //get kata uuid
            $lessonKatasUuid = $relevantKata->getUuid();
            //Push both into the array previously created
            $lessonKatasArray[$lessonKatasUuid]= [
                'title' => $lessonKatasTitle,
                'uuid' => $lessonKatasUuid,
                'position' => $kataPosition,
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
            'lessonKatasArray'=> $lessonKatasArray,
            'lessonKatas' => $lessonKatas,
            'lesson_title' => $lesson->getTitle(),
        ]);
    }
}
