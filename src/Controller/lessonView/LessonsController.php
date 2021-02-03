<?php

namespace App\Controller\lessonView;

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
    public function lessonscreate()
    {
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
     * @param $uuid
     */
    public function index($uuid)
    {
        /*Load Katas that are already in the lesson as index is loaded*/
        //Create array where each kata title and uuid will be stored
        $lessonKatasArray = [];

        //get lesson through uuid
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->findOneBy(['uuid' => $uuid]);
        //get lesson title
        $lessonTitle = $lesson->getTitle();
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


        return $this->render('lessons/index.html.twig', [
            'controller_name' => 'LessonsEditorController',
            'lesson_uuid' => $uuid,
            'availableKatas'=> $availableKatas,
            'kata_uuid' => $kata_uuid,
            'lessonKatasArray'=> $lessonKatasArray,
            'lessonKatas' => $lessonKatas,
            'lessonTitle' => $lessonTitle,
        ]);
    }
}
