<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilePictureUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profilePic', FileType::class,
                [
                'label' => 'Foto de perfil   ',
                'empty_data' => 'Seleccione un archivo.'])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success float-right'
                ],
                'label' => 'Actualizar foto de perfil'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
