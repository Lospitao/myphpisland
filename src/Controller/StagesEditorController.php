<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\AmbientSoundFileUploadType;
use App\Form\BackgroundImageFileUploadType;
use App\Form\DialogFileUploadType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StagesEditorController extends AbstractController
{
    /**
     * @Route("/stages/{stageUuid}/editor", name="stages_editor")
     * @param $stageUuid
     */
    public function index(Request $request, $stageUuid)
    {
        function alert($message) {
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        //Get stage to be updated
        $stage = $this->getDoctrine()
            ->getRepository(Stage::class)
            ->findOneBy(['uuid' => $stageUuid]);

        //Define forms
        $ambientSoundUploadForm = $this->createForm(AmbientSoundFileUploadType::class, $stage);
        $backgroundImageUploadForm = $this->createForm(BackgroundImageFileUploadType::class, $stage);
        $dialogUploadForm = $this->createForm(DialogFileUploadType::class, $stage);
        //Forms handler
        $ambientSoundUploadForm->handleRequest($request);
        $backgroundImageUploadForm->handleRequest($request);
        $dialogUploadForm->handleRequest($request);
        //If Ambient Sound File is submitted
        if ($ambientSoundUploadForm->isSubmitted()) {
            //Get Ambient Sound File
            /**
             * @var UploadedFile $ambientSoundFile
             */
            $ambientSoundFile = $ambientSoundUploadForm['ambient_sound']->getData();

                /*give file a name*/
                $ambientSoundFileName = 'ambient.' . $ambientSoundFile->guessClientExtension();
                /*specify directory route*/
                $ambientRouteName=$this->getParameter('stage_resources_ambient_dir');
                $ambientDestinationPath =  str_replace('stageUuid', $stageUuid, $ambientRouteName);
                /*Store it somewhere*/
                $ambientSoundFile->move(
                    $ambientDestinationPath,
                    $ambientSoundFileName
                );
                $stage->setAmbientSound($ambientSoundFileName);

            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($stage);
            $entity_manager->flush();
            alert("Yo-Ho-Ho! Archivo subido correctamente");
            }

        //If Background Image File is submitted
        else if ($backgroundImageUploadForm->isSubmitted()) {
            //Get Ambient Sound File
            /**
             * @var UploadedFile $backgroundImageFile
             */
            $backgroundImageFile = $backgroundImageUploadForm['background_image']->getData();
            //If there is a file
                /*give file a name*/
                $backgroundImageFileName =  'background-image.' . $backgroundImageFile->guessClientExtension();
            /*specify directory route*/
            $backgroundImageRouteName=$this->getParameter('stage_resources_background_images_dir');
            $backgroundImageDestinationPath =  str_replace('stageUuid', $stageUuid, $backgroundImageRouteName);
                /*Store it somewhere*/
                $backgroundImageFile->move(
                    $backgroundImageDestinationPath,
                    $backgroundImageFileName
                );
                $stage->setBackgroundImage($backgroundImageFileName);
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($stage);
            $entity_manager->flush();
            alert("Yo-Ho-Ho! Archivo subido correctamente");
        }

        //If dialog File is submitted
        else if ($dialogUploadForm->isSubmitted()) {
            //Get Ambient Sound File
            /**
             * @var UploadedFile $dialogFile
             */
            $dialogFile = $dialogUploadForm['dialog']->getData();
            //If there is a file
                /*give file a name*/
                $dialogFileName = 'dialog.' . $dialogFile->guessClientExtension();
                /*specify directory route*/
                $dialogRouteName=$this->getParameter('stage_resources_dialog_dir');
                $dialogDestinationPath =  str_replace('stageUuid', $stageUuid, $dialogRouteName);
                /*Store it somewhere*/
                $dialogFile->move(
                    $dialogDestinationPath,
                    $dialogFileName
                );
                $stage->setDialog($dialogFileName);
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($stage);
            $entity_manager->flush();
            alert("Yo-Ho-Ho! Archivo subido correctamente");
        }
        

        return $this->render('stages_editor/index.html.twig', [
            'controller_name' => 'StagesEditorController',
            'stageUuid' => $stageUuid,
            'ambientSoundUploadForm' => $ambientSoundUploadForm->createView(),
            'backgroundImageUploadForm' => $backgroundImageUploadForm->createView(),
            'dialogUploadForm' => $dialogUploadForm->createView(),
        ]);
    }
}
